<?php
namespace Aliance\Compressor\Strategy;

class MsgPackStrategy implements PackStrategyInterface
{
    /** @inheritdoc */
    public function pack($value)
    {
        return msgpack_pack($value);
    }

    /** @inheritdoc */
    public function unpack($value)
    {
        return msgpack_unpack($value);
    }
}
