<?php

namespace Sokil\DataType;

use PHPUnit\Framework\TestCase;

class WeightListTest extends TestCase
{
    
    /**
     * @var array Items and their weights. Total sum is 100
     */
    private $weights = array(
        'apple'     => 40,
        'orange'    => 30,
        'lemon'     => 20,
        'tomato'    => 7,
        'potato'    => 3,
    );

    /**
     *
     * @var \Sokil\Structure\WeightList
     */
    private $weightList;

    protected function setUp()
    {
        $this->weightList = new WeightList($this->weights);
        
    }
    
    public function testGetValue()
    {
        $reflection = new \ReflectionClass($this->weightList);
        $method = $reflection->getMethod('getValueByPosition');
        $method->setAccessible(true);
        
        $this->assertEquals('apple', $method->invoke($this->weightList, 0));

        $this->assertEquals('apple', $method->invoke($this->weightList, 4));

        $this->assertEquals('orange', $method->invoke($this->weightList, 45));

        $this->assertEquals('orange', $method->invoke($this->weightList, 70));

        $this->assertEquals('lemon', $method->invoke($this->weightList, 71));

        $this->assertEquals('potato', $method->invoke($this->weightList, 100));

    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testGetValueWithEmptyWeightList()
    {
        $emptyWeightList = new WeightList(array());
        $emptyWeightList->getRandomValue();
    }

    public function testSet()
    {
        $this->weightList->set('pear', 20);
        
        $reflection = new \ReflectionClass($this->weightList);
        $method = $reflection->getMethod('getValueByPosition');
        $method->setAccessible(true);

        $this->assertEquals('pear', $method->invoke($this->weightList, 105));
    }
    
    public function testGetRandomValue()
    {
        $stat = array();

        for($i = 0; $i < 10000; $i++) {
            $value = $this->weightList->getRandomValue();

            if(!isset($stat[$value])) {
                $stat[$value] = 0;
            }

            $stat[$value]++;
        }

        arsort($stat);
        $this->assertEquals(array_keys($this->weights), array_keys($stat));
    }

    public function testGetValues()
    {
        $weightList = new WeightList(['apple' => 100]);
        $result = $weightList->getValues();

        $this->assertInternalType('array', $result);
        $this->assertContains('apple', $result);
    }
}
