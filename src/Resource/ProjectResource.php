<?php

namespace JiraClient\Resource;

/**
 * Description of ProjectResource
 *
 * @author rastor
 */
class ProjectResource extends AbstractResource
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
    protected $key;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var array
     */
    protected $avatarUrls;

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
    public function getKey()
    {
        return $this->key;
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
     * @return array
     */
    public function getAvatarsUrls()
    {
        return $this->avatarUrls;
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
            'key' => array(
                '_type' => 'string'
            ),
            'name' => array(
                '_type' => 'string'
            ),
            'avatarUrls' => array(
                '_type' => 'assoc'
            )
        );
    }

}
