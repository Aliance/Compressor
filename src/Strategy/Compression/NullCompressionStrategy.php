<?php
namespace Aliance\Compressor\Strategy\Compression;

class NullCompressionStrategy implements CompressionStrategyInterface
{
    /** @inheritdoc */
    public function compress($value)
    {
        return $value;
    }

    /** @inheritdoc */
    public function decompress($value)
    {
        return $value;
    }
}
