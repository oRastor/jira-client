<?php

namespace JiraClient\Resource;

/**
 * Description of FieldOperation
 *
 * @author rastor
 */
class FieldOperation
{

    const ADD = 'add';
    const REMOVE = 'remove';
    const SET = 'set';
    
    private $name;
    private $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function getValue()
    {
        return $this->value;
    }

}
