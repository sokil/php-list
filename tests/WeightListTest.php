<?php

namespace Sokil\DataType;

class WeightListTest extends \PHPUnit_Framework_TestCase
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

    public function setUp()
    {
        $this->weightList = new WeightList($this->weights);
        
    }
    
    public function testGetKey()
    {
        $this->assertEquals('apple', $this->weightList->getKey(0));

        $this->assertEquals('apple', $this->weightList->getKey(4));

        $this->assertEquals('orange', $this->weightList->getKey(45));

        $this->assertEquals('orange', $this->weightList->getKey(70));

        $this->assertEquals('lemon', $this->weightList->getKey(71));

        $this->assertEquals('potato', $this->weightList->getKey(100));
    }
    
    function testGetRandomKey()
    {
        $stat = array();

        for($i = 0; $i < 10000; $i++) {
            $key = $this->weightList->getRandomKey();

            if(!isset($stat[$key])) {
                $stat[$key] = 0;
            }

            $stat[$key]++;
        }

        arsort($stat);
        $this->assertEquals(array_keys($this->weights), array_keys($stat));
    }
}
