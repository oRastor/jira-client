<?php

namespace JiraClient\Resource;

/**
 * Description of Version
 *
 * @author rastor
 */
class Version extends AbstractResource
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
    protected $description;
    
    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var boolean
     */
    protected $archived;
    
    /**
     *
     * @var boolean
     */
    protected $released;


    /**
     *
     * @var \DateTime
     */
    protected $releaseDate;

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
     * @var string
     */
    public function getDescription()
    {
        return $this->description;
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
     * @return boolean
     */
    public function isArchived()
    {
        return $this->archived;
    }

    /**
     *
     * @return boolean
     */
    public function isReleased()
    {
        return $this->released;
    }
    
    /**
     * 
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
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
            'description' => array(
                '_type' => 'string'
            ),
            'name' => array(
                '_type' => 'string'
            ),
            'archived' => array(
                '_type' => 'boolean'
            ),
            'released' => array(
                '_type' => 'boolean'
            ),
            'releaseDate' => array(
                '_type' => 'date'
            )
        );
    }

}
