<?php
namespace Aliance\Compressor\Tests;

use Aliance\Compressor\Compressor;
use PHPUnit\Framework\TestCase;

class CompressorTest extends TestCase
{
    /**
     * @covers \Aliance\Compressor\Compressor::__construct
     */
    public function testCompressorCreation()
    {
        $this->assertInstanceOf(Compressor::class, new Compressor());
    }
}
