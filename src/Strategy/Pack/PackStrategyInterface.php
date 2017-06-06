<?php
namespace Aliance\Compressor\Strategy\Pack;

interface PackStrategyInterface
{
    /**
     * @return int
     */
    public function getMinLength();

    /**
     * @param mixed $value
     * @return string
     */
    public function pack($value);

    /**
     * @param string $value
     * @return mixed
     */
    public function unpack($value);
}
