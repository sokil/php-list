<?php

namespace Sokil\DataType;

/**
 * Class used to get some identifier according to 
 * probability of this key.
 * 
 */
class WeightList implements ListInterface
{
    private $weights;
    
    public function __construct(array $weights)
    {
        $this->weights = $weights;
    }
    
    public function getRandomKey()
    {
        return $this->getKey(mt_rand(0, array_sum($this->weights)));
    }
    
    public function getKey($position)
    {
        $accumulator = 0;
        foreach($this->weights as $key => $weight) {
            $accumulator += $weight;
            if($position <= $accumulator) {
                return $key;
            }
        }

        return $key;
    }
}