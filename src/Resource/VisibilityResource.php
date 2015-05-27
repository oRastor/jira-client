<?php

namespace JiraClient\Resource;

/**
 * Description of VisibilityResource
 *
 * @author rastor
 */
class VisibilityResource extends AbstractResource
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
    protected $value;

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
     *
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     *
     * @return VisibilityResource
     */
    public function setType($type)
    {
        $this->type = $type;
        
        return $this;
    }

    /**
     *
     * @return VisibilityResource
     */
    public function setValue($value)
    {
        $this->value = $value;
        
        return $this;
    }
    
    public function getSaveData()
    {
        return array(
            'type' => $this->type,
            'value' => $this->value
        );
    }

}
