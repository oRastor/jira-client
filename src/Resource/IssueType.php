<?php

namespace JiraClient\Resource;

/**
 * Description of IssueType
 *
 * @author rastor
 */
class IssueType extends AbstractResource
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
    protected $iconUrl;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var boolean
     */
    protected $subtask;

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
     *
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @return string
     */
    public function getIconUrl()
    {
        return $this->iconUrl;
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
     *
     */
    public function getSubtask()
    {
        return $this->active;
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
            'iconUrl' => array(
                '_type' => 'string'
            ),
            'name' => array(
                '_type' => 'string'
            ),
            'subtask' => array(
                '_type' => 'boolean'
            )
        );
    }

}
