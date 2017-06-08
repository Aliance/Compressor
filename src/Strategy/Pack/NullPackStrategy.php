<?php
namespace Aliance\Compressor\Strategy\Pack;

class NullPackStrategy implements PackStrategyInterface
{
    /** @inheritdoc */
    public function getMinLength()
    {
        return PHP_INT_MAX;
    }

    /** @inheritdoc */
    public function pack($value)
    {
        return $value;
    }

    /** @inheritdoc */
    public function unpack($value)
    {
        return $value;
    }
}
