<?php

namespace Sokil\DataType;

/**
 * Class used to get some identifier according to
 * probability of this key.
 *
 */
class WeightList
{
    private $list;

    public function __construct(array $list = array())
    {
        $this->list = $list;
    }

    public function set($value, $weight)
    {
        $this->list[$value] = $weight;
        return $this;
    }

    private function getValueByPosition($position)
    {
        if (count($this->list) === 0) {
            throw new \OutOfBoundsException('Index of ' . $position . ' is out of bounds for the array.');
        }

        $accumulator = 0;
        foreach ($this->list as $value => $weight) {
            $accumulator += $weight;
            if ($position <= $accumulator) {
                return $value;
            }
        }

        return $value;
    }

    public function getRandomValue()
    {
        $position = mt_rand(0, array_sum($this->list));
        return $this->getValueByPosition($position);
    }

    public function getValues()
    {
        return array_keys($this->list);
    }
}
