<?php

namespace JiraClient\Resource;

/**
 * Description of Transition
 *
 * @author rastor
 */
class Transition extends AbstractResource
{

    /**
     *
     * @var int
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var Status
     */
    protected $toStatus;

    /**
     *
     * @todo Add required fields support
     * @var array
     */
    protected $fields;
    
    /**
     *
     * @return integer
     *
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @return Status
     */
    public function getToStatus()
    {
        return $this->toStatus;
    }

    public function getObjectMappings()
    {
        return array(
            'id' => array(
                '_type' => 'integer'
            ),
            'name' => array(
                '_type' => 'string'
            ),
            'to' => array(
                '_type' => 'status',
                '_property' => 'toStatus'
            )
        );
    }

}
