<?php
namespace Aliance\Compressor\Strategy;

class GzCompressionStrategy implements CompressionStrategyInterface
{
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
