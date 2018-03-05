<?php

namespace Sokil\DataType;

class PriorityMap implements \Iterator, \Countable
{
    private $lastSequence = 0;

    private $list = array();

    const ORDER_ASC = 'asc';
    const ORDER_DESC = 'desc';

    private $order = self::ORDER_DESC;

    /**
     * Get scalar key from mixed
     */
    private function getScalarKey($key)
    {
        if (is_object($key)) {
            return spl_object_hash($key);
        } else {
            return $key;
        }
    }

    /**
     * Add new item to map
     *
     * @param mixed $key scalar value or object to add into priority map
     * @param mixed $value value
     * @param int $priority priority
     *
     * @return PriorityMap
     */
    public function set($key, $value, $priority = 0)
    {
        $key = $this->getScalarKey($key);

        $this->list[$key] = new \stdclass();
        $this->list[$key]->value = $value;
        $this->list[$key]->priority = (int) $priority;
        $this->list[$key]->sequence = $this->lastSequence++;

        return $this->list[$key];
    }

    /**
     * Get item from map
     *
     * @param mixed $key
     * @return mixed
     *
     * @throws \OutOfBoundsException when key is not exists
     */
    public function get($key)
    {
        $key = $this->getScalarKey($key);
        if (isset($this->list[$key])) {
            return $this->list[$key]->value;
        }

        throw new \OutOfBoundsException('The key ' . $key . ' is not existed.');
    }

    /**
     * Check if item in map
     *
     * @param mixed $key
     * @return bool
     */
    public function has($key)
    {
        $key = $this->getScalarKey($key);
        return isset($this->list[$key]);
    }

    /**
     * Get list of keys
     *
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->list);
    }

    /**
     * Get count or map
     *
     * @return int
     */
    public function count()
    {
        return count($this->list);
    }

    /**
     * Set ASC direction of sorting
     *
     * @return $this
     */
    public function setAscOrder()
    {
        $this->order = self::ORDER_ASC;
        return $this;
    }

    /**
     * Set DESC direction of sorting
     *
     * @return $this
     */
    public function setDescOrder()
    {
        $this->order = self::ORDER_DESC;
        return $this;
    }

    /**
     * ASC sort strategy
     *
     * @param $declaration1
     * @param $declaration2
     * @return int
     */
    private function ascSortStrategy($declaration1, $declaration2)
    {
        if ($declaration1->priority === $declaration2->priority) {
            return $declaration1->sequence < $declaration2->sequence ? 1 : -1;
        }

        return $declaration1->priority > $declaration2->priority ? 1 : -1;
    }

    /**
     * DESC sort strategy
     *
     * @param $declaration1
     * @param $declaration2
     * @return int
     */
    private function descSortStrategy($declaration1, $declaration2)
    {
        if ($declaration1->priority === $declaration2->priority) {
            return $declaration1->sequence < $declaration2->sequence ? 1 : -1;
        }

        return $declaration1->priority < $declaration2->priority ? 1 : -1;
    }

    /**
     * Reset iterator
     */
    public function rewind()
    {
        uasort($this->list, array($this, $this->order . 'SortStrategy'));
        reset($this->list);
    }

    /**
     * Get current item
     *
     * @return mixed
     */
    public function current()
    {
        $item = current($this->list);
        return $item->value;
    }

    /**
     * Get current key
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->list);
    }

    /**
     * Mve iterator next
     */
    public function next()
    {
        next($this->list);
    }

    /**
     * Check if current key is valid
     *
     * @return bool
     */
    public function valid()
    {
        return null !== $this->key();
    }

    /**
     * Convert map to array
     *
     * @return array
     */
    public function toArray()
    {
        return iterator_to_array($this);
    }
}
