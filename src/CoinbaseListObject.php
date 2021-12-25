<?php

namespace StevePolite\Coinbase;

class CoinbaseListObject
{
    /**
     * @var string
     */
    private $object;

    /**
     * @var array
     */
    private $data;

    /**
     * @var null|string
     */
    private $prev_cursor;

    /**
     * @var null|string
     */
    private $next_cursor;

    public function __construct(string $object, array $header, array $data)
    {
        $this->object = $object;
        $this->data = $data;

        if (\array_key_exists("cb-before", $header)) {
            $this->prev_cursor = $header["cb-before"];
        }

        if (\array_key_exists("cb-after", $header)) {
            $this->next_cursor = $header["cb-after"];
        }
    }
}
