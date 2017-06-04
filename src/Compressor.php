<?php
namespace Aliance\Compressor;

use Aliance\Compressor\Strategy\CompressionStrategyInterface;
use Aliance\Compressor\Strategy\GzCompressionStrategy;
use Aliance\Compressor\Strategy\JsonPackStrategy;
use Aliance\Compressor\Strategy\LzfCompressionStrategy;
use Aliance\Compressor\Strategy\MsgPackStrategy;
use Aliance\Compressor\Strategy\NullCompressionStrategy;
use Aliance\Compressor\Strategy\PackStrategyInterface;

/**
 * Pack string/array into short format and compress it.
 */
class Compressor {
    const PACK_TYPE_JSON = 'json';
    const PACK_TYPE_MSGPACK = 'msgpack';

    const COMPRESSION_TYPE_NULL = 'null';
    const COMPRESSION_TYPE_GZ = 'gz';
    const COMPRESSION_TYPE_LZF = 'lzf';

    /**
     * @param mixed $value
     * @param string $packType
     * @param string $compressionType
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

        $packedValue = $this->getPackStrategy($packType)->pack($value);

        $compressedValue = $this->getCompressionStrategy($compressionType)->compress($packedValue);

        return $compressedValue;
    }

    /**
     * @param string $value
     * @return mixed
     * @throws \InvalidArgumentException
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

        $decompressedValue = $this->getCompressionStrategy(self::COMPRESSION_TYPE_GZ)->decompress($value);

        $unpackedValue = $this->getPackStrategy(self::PACK_TYPE_JSON)->unpack($decompressedValue);

        return $unpackedValue;
    }

    /**
     * @param string $packType
     * @return PackStrategyInterface
     * @throws \InvalidArgumentException
     */
    private function getPackStrategy($packType)
    {
        switch ($packType) {
            case self::PACK_TYPE_JSON:
                return new JsonPackStrategy();
            case self::PACK_TYPE_MSGPACK:
                return new MsgPackStrategy();
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
            case self::COMPRESSION_TYPE_GZ:
                return new GzCompressionStrategy();
            case self::COMPRESSION_TYPE_LZF:
                return new LzfCompressionStrategy();
            case self::COMPRESSION_TYPE_NULL:
                return new NullCompressionStrategy();
            default:
                throw new \InvalidArgumentException(sprintf(
                    'Invalid compression type passed ("%s").',
                    $compressionType
                ));
        }
    }
}
