<?php
namespace Aliance\Compressor\Strategy;

class JsonPackStrategy implements PackStrategyInterface
{
    /** @inheritdoc */
    public function pack($value)
    {
        return json_encode($value);
    }

    /** @inheritdoc */
    public function unpack($value)
    {
        return json_decode($value, true);
    }
}
