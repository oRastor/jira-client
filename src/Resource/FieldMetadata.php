<?php

namespace JiraClient\Resource;

/**
 * Description of FieldMetadata
 *
 * @author rastor
 */
class FieldMetadata extends AbstractResource
{

    /**
     *
     * @var bool
     */
    protected $required = false;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var FieldMetadataSchema
     */
    protected $schema;

    /**
     *
     * @var bool
     */
    protected $hasDefaultValue = false;

    /**
     *
     * @var array
     */
    protected $operations = array();

    /**
     *
     * @var array
     */
    protected $allowedValues = array();

    /**
     *
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * 
     * @return FieldMetadataSchema
     */
    public function getSchema()
    {
        return $this->schema;
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
     * @return bool
     */
    public function hasDefaultValue()
    {
        return $this->hasDefaultValue;
    }

    /**
     *
     * @return array
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * 
     * @return array
     */
    public function getAllowedValues()
    {
        return $this->allowedValues;
    }

    public function getObjectMappings()
    {
        return array(
            'required' => array(
                '_type' => 'boolean'
            ),
            'schema' => array(
                '_type' => 'schema'
            ),
            'name' => array(
                '_type' => 'string'
            ),
            'hasDefaultValue' => array(
                '_type' => 'boolean'
            ),
            'operations' => array(
                '_type' => 'array',
                '_itemType' => 'string'
            ),
            'allowedValues' => array(
                '_type' => 'array',
                '_itemType' => 'customfieldoption'
            )
        );
    }

}
