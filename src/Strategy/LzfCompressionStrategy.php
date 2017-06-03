<?php
namespace Aliance\Compressor\Strategy;

class LzfCompressionStrategy implements CompressionStrategyInterface
{
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
