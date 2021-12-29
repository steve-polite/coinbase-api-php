<?php

namespace StevePolite\Coinbase\Service;

abstract class AbstractService
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    protected function request($method, $path, $params, $body = null)
    {
        return $this->getClient()->request($method, $path, $params, $body);
    }

    protected function buildPath($basePath, ...$ids)
    {
        foreach ($ids as $id) {
            if ($id === null || \trim($id) === '') {
                throw new \StevePolite\Coinbase\Exception\InvalidArgumentException('The resource ID cannot be null or whitespace');
            }
        }

        return \sprintf($basePath, ...\array_map('\urlencode', $ids));
    }
}
