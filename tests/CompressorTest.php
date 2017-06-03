<?php
namespace Aliance\Compressor\Tests;

use Aliance\Compressor\Compressor;
use PHPUnit\Framework\TestCase;

class CompressorTest extends TestCase
{
    /**
     * @var Compressor
     */
    private $Compressor;

    /**
     * @covers \Aliance\Compressor\Compressor::__construct
     */
    public function testCompressorCreation()
    {
        $this->assertInstanceOf('\Aliance\Compressor\Compressor', $this->Compressor);
    }

    /**
     * @covers \Aliance\Compressor\Compressor::compress
     * @covers \Aliance\Compressor\Compressor::decompress
     * @dataProvider getValuesDataProvider
     * @param mixed $value
     */
    public function testCompressorBase($value)
    {
        $this->assertSame(
            $value,
            $this->Compressor->decompress(
                $this->Compressor->compress(
                    $value,
                    Compressor::PACK_TYPE_JSON,
                    Compressor::COMPRESSION_TYPE_GZ
                )
            )
        );
    }

    /**
     * @return array
     */
    public function getValuesDataProvider()
    {
        return array_map(function ($value) {
            return [$value];
        }, $this->getValues());
    }

    /**
     * @covers \Aliance\Compressor\Compressor::compress
     * @dataProvider getDataProvider
     * @param mixed $value
     * @param string $expected
     */
    public function testJsonGzCompress($value, $expected)
    {
        $compressedValue = $this->Compressor->compress(
            $value,
            Compressor::PACK_TYPE_JSON,
            Compressor::COMPRESSION_TYPE_GZ
        );
        $this->assertSame($expected, $compressedValue);
    }

    /**
     * @covers \Aliance\Compressor\Compressor::decompress
     * @dataProvider getDataProvider
     * @param mixed $expected
     * @param string $value
     */
    public function testDecompress($expected, $value)
    {
        $decompressedValue = $this->Compressor->decompress($value);
        $this->assertSame($expected, $decompressedValue);
    }

    /**
     * @return array
     */
    public function getDataProvider()
    {
        $dataProvider = [];

        foreach ($this->getValues() as $value) {
            $dataProvider[] = [
                $value,
                gzcompress(json_encode($value)),
            ];
        }

        return $dataProvider;
    }

    /**
     * @return array
     */
    private function getValues()
    {
        return [
            'some string',
            'some very long string with dummy text here: Lorem ipsum dolor sit amet, eam falli bonorum definitionem et. An vix stet quas ignota. Impedit maluisset imperdiet sea no, deseruisse inciderint sit et, mea purto putant consulatu ad. Eam an hinc persecuti, mel noster complectitur eu, his cu mucius dicunt. Ad expetenda suavitate quo. Vide nostrum ut vix, vix lorem persius reprimique ea. Eam agam instructior theophrastus at. Ut usu unum aeterno eloquentiam, cum ex etiam dicunt lucilius, ne vix hinc perpetua forensibus. Ne porro postea aliquid sed, te quo minim gloriatur. Qui lorem aliquam labores te, cu sea aperiam invidunt tractatos.',
            '1234567890 !@#$%^&*()_+QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm[]{};\':"\\,./><<?~`',
            [1,2,3,4,5,6,7,8,9,0],
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
        ];
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->Compressor = new Compressor();
    }
}
