<?php
namespace Aliance\Compressor\Tests;

use Aliance\Compressor\Compressor;

class JsonGzTest extends CompressorTestCase
{
    /**
     * @inheritdoc
     */
    public function getPackType()
    {
        return Compressor::PACK_TYPE_JSON;
    }

    /**
     * @inheritdoc
     */
    public function getCompressionType()
    {
        return Compressor::COMPRESSION_TYPE_GZ;
    }
}
