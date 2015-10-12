<?php

namespace JiraClient\Resource;

/**
 * Description of CustomFieldOption
 *
 * @author rastor
 */
class CustomFieldOption extends AbstractResource
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
    
    public function __toString()
    {
        return (string) $this->value;
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
            )
        );
    }

}
