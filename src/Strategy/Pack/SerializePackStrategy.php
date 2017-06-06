<?php
namespace Aliance\Compressor\Strategy\Pack;

class SerializePackStrategy implements PackStrategyInterface
{
    /** @inheritdoc */
    public function getMinLength()
    {
        return 100;
    }

    /** @inheritdoc */
    public function pack($value)
    {
        return serialize($value);
    }

    /** @inheritdoc */
    public function unpack($value)
    {
        return unserialize($value);
    }
}
