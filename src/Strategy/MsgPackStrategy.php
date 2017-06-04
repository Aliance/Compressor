<?php
namespace Aliance\Compressor\Strategy;

class MsgPackStrategy implements PackStrategyInterface
{
    /**
     * @throws \RuntimeException
     */
    public function __construct()
    {
        if (!extension_loaded('msgpack')) {
            throw new \RuntimeException('Missed required PHP extension "msgpack".');
        }
    }

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
