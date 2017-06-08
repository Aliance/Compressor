<?php
namespace Aliance\Compressor;

use Aliance\Bitmask\Bitmask;
use Aliance\Compressor\Strategy\Compression\CompressionStrategyInterface;
use Aliance\Compressor\Strategy\Compression\GzCompressionStrategy;
use Aliance\Compressor\Strategy\Compression\LzfCompressionStrategy;
use Aliance\Compressor\Strategy\Compression\NullCompressionStrategy;
use Aliance\Compressor\Strategy\Pack\JsonPackStrategy;
use Aliance\Compressor\Strategy\Pack\MsgPackStrategy;
use Aliance\Compressor\Strategy\Pack\NullPackStrategy;
use Aliance\Compressor\Strategy\Pack\PackStrategyInterface;
use Aliance\Compressor\Strategy\Pack\SerializePackStrategy;

/**
 * Pack string/array into short format and compress it.
 */
class Compressor {
    /**
     * Two-bytes prefix: hex representation of chars 'I' (49) and 'L' (4c).
     * @var int
     */
    const PREFIX = 0x494c;

    const PACK_TYPE_NULL       = 0;
    const PACK_TYPE_JSON       = 1;
    const PACK_TYPE_MSGPACK    = 2;
    const PACK_TYPE_SERIALIZER = 3;

    const COMPRESSION_TYPE_NULL = 0;
    const COMPRESSION_TYPE_GZ   = 1;
    const COMPRESSION_TYPE_LZF  = 2;

    /**
     * @param mixed $value
     * @param int $packType
     * @param int $compressionType
     * @return string
     * @throws \InvalidArgumentException
     */
    public function compress($value, $packType = self::PACK_TYPE_JSON, $compressionType = self::COMPRESSION_TYPE_NULL)
    {
        if (!is_string($value) && !is_array($value)) {
            throw new \InvalidArgumentException(sprintf(
                'Value to compress should be string or array, but "%s" given.',
                gettype($value)
            ));
        }

        $packStrategy = $this->getPackStrategy($packType);
        $packedValue = $packStrategy->pack($value);

//        if (strlen($packedValue) < $packStrategy->getMinLength()) {
            //$compressionType = self::COMPRESSION_TYPE_NULL;
//        }

        $compressedValue = $this->getCompressionStrategy($compressionType)->compress($packedValue);

        return pack(
            'nLa*',
            self::PREFIX,
            ($compressionType << 2) + $packType,
            $compressedValue
        );
    }

    /**
     * @param string $value
     * @return mixed
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function decompress($value)
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException(sprintf(
                'Value to decompress should be string, but "%s" given.',
                gettype($value)
            ));
        }

        if (strlen($value) == 0) {
            throw new \InvalidArgumentException('Zero-length string given to decompress.');
        }

        $unpackedData = unpack('nprefix/Loptions/a*data', $value);

        if ($unpackedData['prefix'] != self::PREFIX) {
            throw new \LogicException('Incorrect format.');
        }

        $packType        = ($unpackedData['options'] >> 0) & 0b11;
        $compressionType = ($unpackedData['options'] >> 2) & 0b11;

        return $this->getPackStrategy($packType)->unpack(
            $this->getCompressionStrategy($compressionType)->decompress($unpackedData['data'])
        );
    }

    /**
     * @param string $packType
     * @return PackStrategyInterface
     * @throws \InvalidArgumentException
     */
    private function getPackStrategy($packType)
    {
        switch ($packType) {
            case self::PACK_TYPE_NULL:
                return new NullPackStrategy();
            case self::PACK_TYPE_JSON:
                return new JsonPackStrategy();
            case self::PACK_TYPE_MSGPACK:
                return new MsgPackStrategy();
            case self::PACK_TYPE_SERIALIZER:
                return new SerializePackStrategy();
            default:
                throw new \InvalidArgumentException(sprintf(
                    'Invalid pack type passed ("%s").',
                    $packType
                ));
        }
    }

    /**
     * @param string $compressionType
     * @return CompressionStrategyInterface
     * @throws \InvalidArgumentException
     */
    private function getCompressionStrategy($compressionType)
    {
        switch ($compressionType) {
            case self::COMPRESSION_TYPE_NULL:
                return new NullCompressionStrategy();
            case self::COMPRESSION_TYPE_GZ:
                return new GzCompressionStrategy();
            case self::COMPRESSION_TYPE_LZF:
                return new LzfCompressionStrategy();
            default:
                throw new \InvalidArgumentException(sprintf(
                    'Invalid compression type passed ("%s").',
                    $compressionType
                ));
        }
    }
}
