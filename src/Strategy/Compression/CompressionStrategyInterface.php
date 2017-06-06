<?php
namespace Aliance\Compressor\Strategy\Compression;

interface CompressionStrategyInterface
{
    /**
     * @param mixed $value
     * @return string
     */
    public function compress($value);

    /**
     * @param string $value
     * @return string
     */
    public function decompress($value);
}
