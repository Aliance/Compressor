<?php
namespace Aliance\Compressor\Strategy;

interface PackStrategyInterface
{
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
