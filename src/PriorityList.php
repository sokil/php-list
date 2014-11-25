<?php

namespace Sokil;

class PriorityList implements \Iterator, \Countable
{    
    private $lastSequence = 0;
    
    private $list = array();
    
    const ORDER_ASC = 'asc';
    const ORDER_DESC = 'desc';
    
    private $order = self::ORDER_DESC;
    
    /**
     * 
     * @param string $name name
     * @param string $value value
     * @param string $priority priority
     * @return \Sokil\PriorityList
     */
    public function set($name, $value, $priority = 0)
    {
        $this->list[$name] = new \stdclass();
        $this->list[$name]->value = $value;
        $this->list[$name]->priority = $priority;
        $this->list[$name]->sequence = $this->lastSequence++;
        
        return $this->list[$name];
    }
    
    public function get($name)
    {
        return isset($this->list[$name]) ? $this->list[$name] : null;
    }
    
    public function count()
    {
        return count($this->list);
    }
    
    public function setAscOrder()
    {
        $this->order = self::ORDER_ASC;
        return $this;
    }
    
    public function setDescOrder()
    {
        $this->order = self::ORDER_DESC;
        return $this;
    }
    
    private function ascSortStrategy($declaration1, $declaration2)
    {
        if($declaration1->priority === $declaration2->priority) {
            return $declaration1->sequence < $declaration2->sequence ? 1 : -1;
        }

        return $declaration1->priority > $declaration2->priority ? 1 : -1;
    }
    
    private function descSortStrategy($declaration1, $declaration2)
    {
        if($declaration1->priority === $declaration2->priority) {
            return $declaration1->sequence < $declaration2->sequence ? 1 : -1;
        }

        return $declaration1->priority < $declaration2->priority ? 1 : -1;
    }
    
    public function rewind()
    {
        uasort($this->list, array($this, $this->order . 'SortStrategy'));
        reset($this->list);
    }
    
    public function current()
    {
        $item = current($this->list);
        return $item->value;
    }
    
    public function key()
    {
        return key($this->list);
    }
    
    public function next()
    {
        next($this->list);
    }
    
    public function valid()
    {
        return null !== $this->key();
    }
    
    public function toArray()
    {
        return iterator_to_array($this);
    }
}