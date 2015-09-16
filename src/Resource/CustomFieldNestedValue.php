<?php

namespace JiraClient\Resource;

/**
 * Description of CustomFieldNestedValue
 *
 * @author rastor
 */
class CustomFieldNestedValue extends AbstractResource
{

    /**
     *
     * @var string
     */
    protected $self;

    /**
     *
     * @var int
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $value;
    
    /**
     *
     * @var JiraClient\Resource\CustomFieldNestedValue
     */
    protected $child;

    /**
     *
     * @return string
     */
    public function getSelf()
    {
        return $this->self;
    }

    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     *
     * @return JiraClient\Resource\CustomFieldNestedValue
     */
    public function getChild()
    {
        return $this->child;
    }

    public function getObjectMappings()
    {
        return array(
            'self' => array(
                '_type' => 'string'
            ),
            'id' => array(
                '_type' => 'integer'
            ),
            'value' => array(
                '_type' => 'string'
            ),
            'child' => array(
                '_type' => 'customFieldNestedValue'
            )
        );
    }

}
