<?php

namespace Yiisoft\Db\ElasticSearch\Tests;

use Yiisoft\Db\ElasticSearch\Connection;

/**
 * @group elasticsearch
 */
class ConnectionTest extends TestCase
{
    /**
     * @var Connection
     */
    private $connection;

    protected function setUp()
    {
        parent::setUp();
        $this->connection = $this->getConnection();
    }

    public function testCreateUrl()
    {
        $reflectedMethod = new \ReflectionMethod($this->connection, 'createUrl');
        $reflectedMethod->setAccessible(true);

        $protocol = $this->connection->nodes[$this->connection->activeNode]['protocol'];
        $httpAddress = $this->connection->nodes[$this->connection->activeNode]['http_address'];
        $this->assertEquals([$protocol, $httpAddress, ''], $reflectedMethod->invoke($this->connection, []));

        $this->assertEquals([$protocol, $httpAddress, '_cat/indices'],
            $reflectedMethod->invoke($this->connection, '_cat/indices'));

        $this->assertEquals([$protocol, $httpAddress, 'customer'],
            $reflectedMethod->invoke($this->connection, 'customer'));

        $this->assertEquals([$protocol, $httpAddress, 'customer/external/1'],
            $reflectedMethod->invoke($this->connection, ['customer', 'external', '1']));

        $this->assertEquals([$protocol, $httpAddress, 'customer/external/1/_update'],
            $reflectedMethod->invoke($this->connection, ['customer', 'external', 1, '_update',]));
    }
}
