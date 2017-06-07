<?php
namespace Aliance\Compressor\Tests;

use Aliance\Compressor\Compressor;
use PHPUnit\Framework\TestCase;

abstract class CompressorTestCase extends TestCase
{
    /**
     * @return int one of Compressor::PACK_TYPE_* constant.
     */
    abstract protected function getPackType();

    /**
     * @return int one of Compressor::COMPRESSION_TYPE_* constant.
     */
    abstract protected function getCompressionType();

    /**
     * @covers \Aliance\Compressor\Compressor::compress
     * @covers \Aliance\Compressor\Compressor::decompress
     * @dataProvider getValuesDataProvider
     * @param mixed $value
     */
    public function testCompressor($value)
    {
        $Compressor = new Compressor();

        $this->assertSame(
            $value,
            $Compressor->decompress($Compressor->compress($value, $this->getPackType(), $this->getCompressionType()))
        );
    }

    /**
     * @return array
     */
    public function getValuesDataProvider()
    {
        return [
            [
                [
                    'some key 1' => 'some value 1',
                    'some key 2' => 'some value 2',
                    'some key 3' => 'some value 3',
                    'some key 4' => [
                        'some key 4.1' => 'some value 4.1',
                        'some key 4.2' => 'some value 4.2',
                        'some key 4.3' => 'some value 4.3',
                    ],
                ],
            ],
            [
                range(0, 10000),
            ],
        ];
    }
}
