<?php

namespace Sokil\DataType;

use PHPUnit\Framework\TestCase;

class PriorityMapTest extends TestCase
{
    public function testToArrayDesc()
    {
        $list = new PriorityMap();

        $list->set('k1', 'v1', 2);
        $list->set('k2', 'v2', 8);
        $list->set('k3', 'v3', 16);
        $list->set('k4', 'v4', 1);
        $list->set('k5', 'v5', 4);

        $expectedArray = array(
            'k3' => 'v3',
            'k2' => 'v2',
            'k5' => 'v5',
            'k1' => 'v1',
            'k4' => 'v4',
        );

        foreach($list as $key => $value) {
            $this->assertEquals(key($expectedArray), $key);
            $this->assertEquals(current($expectedArray), $value);

            next($expectedArray);
        }

        if(key($expectedArray)) {
            $this->fail('Actual list less than expected');
        }
    }

    public function testToArrayAsc()
    {
        $list = new PriorityMap();

        $list->setAscOrder();

        $list->set('k1', 'v1', 2);
        $list->set('k2', 'v2', 8);
        $list->set('k3', 'v3', 16);
        $list->set('k4', 'v4', 1);
        $list->set('k5', 'v5', 4);

        $expectedArray = array(
            'k4' => 'v4',
            'k1' => 'v1',
            'k5' => 'v5',
            'k2' => 'v2',
            'k3' => 'v3',
        );

        foreach($list as $key => $value) {
            $this->assertEquals(key($expectedArray), $key);
            $this->assertEquals(current($expectedArray), $value);

            next($expectedArray);
        }

        if(key($expectedArray)) {
            $this->fail('Actual list less than expected');
        }
    }

    public function testGet()
    {
        $list = new PriorityMap();

        $list->set('k1', 'v1', 2);
        $list->set('k2', 'v2', 8);
        $list->set('k3', 'v3', 16);
        $list->set('k4', 'v4', 1);
        $list->set('k5', 'v5', 4);

        $this->assertEquals('v5', $list->get('k5'));
    }

    public function testGetKeys()
    {
        $list = new PriorityMap();

        $list->set('k1', 'v1', 2);
        $list->set('k2', 'v2', 8);
        $list->set('k3', 'v3', 16);
        $list->set('k4', 'v4', 1);
        $list->set('k5', 'v5', 4);

        $result = $list->getKeys();

        $this->assertCount(5, $result);
        foreach($result as $key) {
            $this->assertContains($key, $result);
        }
    }

    public function testCount()
    {
        $list = new PriorityMap();

        $list->set('K1', 'v1', 2);

        $this->assertSame(1, $list->count());
    }

    public function testGetKeys_EmptyList()
    {
        $list = new PriorityMap();

        $this->assertCount(0, $list->getKeys());
    }

    public function testGet_KeyNotExists()
    {
        $list = new PriorityMap();

        $list->set('k1', 'v1', 2);
        $list->set('k2', 'v2', 8);
        $list->set('k3', 'v3', 16);
        $list->set('k4', 'v4', 1);
        $list->set('k5', 'v5', 4);

        $this->assertNull($list->get('KEY_NOT_EXISTS'));
    }

    public function testHas()
    {
        $list = new PriorityMap();

        $list->set('k1', 'v1', 2);

        $this->assertTrue($list->has('k1'));
        $this->assertFalse($list->has('UNKNOWN_KEY'));
    }

    public function testSet_ObjectKey()
    {
        $key1 = new \stdClass();
        $key2 = new \stdClass();
        $key3 = new \stdClass();

        $list = new PriorityMap();
        $list->setAscOrder();

        $list->set($key1, 42, 1);
        $list->set($key2, 41, 0);
        $list->set($key3, 43, 2);

        $list->rewind();
        $this->assertEquals(41, $list->current());
    }

    public function testSetDescOrder()
    {
        $key = new \stdClass();

        $list = new PriorityMap();
        $list->setDescOrder();

        $list->set($key, 42, 1);
        $list->set($key, 41, 0);
        $list->set($key, 43, 2);

        $this->assertSame(43, $list->current());
    }

    public function testToArray()
    {
        $key = new \stdClass();

        $list = new PriorityMap();

        $list->set($key, 42, 1);
        $list->set($key, 41, 0);
        $list->set($key, 43, 2);

        $this->assertInternalType('array', $list->toArray());
    }
}
