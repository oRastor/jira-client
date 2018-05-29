<?php

namespace JiraClient\Resource;

/**
 * Description of StatusCategory
 *
 * @author pbrasseur
 */
class StatusCategory extends AbstractResource
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
    protected $colorName;

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
    public function getKey()
    {
        return $this->key;
    }

    /**
     *
     * @return string
     */
    public function getColorName()
    {
        return $this->colorName;
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
            'key' => array(
                '_type' => 'string'
            ),
            'colorName' => array(
                '_type' => 'string'
            ),
            'name' => array(
                '_type' => 'string'
            )
        );
    }
}
