<?php
namespace Aliance\Compressor\Strategy\Compression;

class GzCompressionStrategy implements CompressionStrategyInterface
{
    /**
     * @throws \RuntimeException
     */
    public function __construct()
    {
        if (!extension_loaded('zlib')) {
            throw new \RuntimeException('Missed required PHP extension "zlib".');
        }
    }

    /** @inheritdoc */
    public function compress($value)
    {
        return gzcompress($value);
    }

    /** @inheritdoc */
    public function decompress($value)
    {
        return gzuncompress($value);
    }
}
