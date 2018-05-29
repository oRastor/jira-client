<?php

namespace JiraClient\Resource;

/**
 * Description of Priority
 *
 * @author pbrasseur
 */
class Priority extends AbstractResource
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
    protected $iconUrl;

    /**
     *
     * @var string
     */
    protected $name;

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

    public function getObjectMappings()
    {
        return array(
            'self' => array(
                '_type' => 'string'
            ),
            'id' => array(
                '_type' => 'integer'
            ),
            'iconUrl' => array(
                '_type' => 'string'
            ),
            'name' => array(
                '_type' => 'string'
            )
        );
    }

}
