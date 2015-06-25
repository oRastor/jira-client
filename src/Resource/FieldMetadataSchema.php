<?php

namespace JiraClient\Resource;

/**
 * Description of FieldMetadataSchema
 *
 * @author rastor
 */
class FieldMetadataSchema extends AbstractResource
{

    /**
     *
     * @var string
     */
    protected $type;
    
    /**
     *
     * @var string
     */
    protected $items;
    
    /**
     *
     * @var string
     */
    protected $system;
    
    /**
     *
     * @var string
     */
    protected $custom;
    
    /**
     *
     * @var int
     */
    protected $customId;

    /**
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     *
     * @return string
     */
    public function getItems()
    {
        return $this->items;
    }
    
    /**
     *
     * @return string
     */
    public function getSystem()
    {
        return $this->system;
    }
    
    /**
     *
     * @return string
     */
    public function getCustom()
    {
        return $this->custom;
    }

    /**
     *
     * @return int
     */
    public function getCustomId()
    {
        return $this->customId;
    }

    /**
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getObjectMappings()
    {
        return array(
            'type' => array(
                '_type' => 'string'
            ),
            'items' => array(
                '_type' => 'string'
            ),
            'system' => array(
                '_type' => 'string'
            ),
            'custom' => array(
                '_type' => 'string'
            ),
            'customId' => array(
                '_type' => 'integer'
            )
        );
    }

}
