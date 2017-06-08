<?php
namespace Aliance\Compressor\Strategy\Compression;

class LzfCompressionStrategy implements CompressionStrategyInterface
{
    /**
     * @throws \RuntimeException
     */
    public function __construct()
    {
        if (!extension_loaded('lzf')) {
            throw new \RuntimeException('Missed required PHP extension "lzf".');
        }
    }

    /** @inheritdoc */
    public function compress($value)
    {
        return lzf_compress($value);
    }

    /** @inheritdoc */
    public function decompress($value)
    {
        return lzf_decompress($value);
    }
}
