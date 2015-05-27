<?php

namespace JiraClient\Resource;

use JiraClient\JiraClient,
    JiraClient\Exception\JiraException;

/**
 * Description of AbstractResource
 *
 * @author rastor
 */
class AbstractResource
{

    /**
     *
     * @var JiraClient 
     */
    protected $client;

    public final function __construct(JiraClient $client, $data = null)
    {
        $this->client = $client;

        if ($data == null) {
            return;
        }

        if (!is_array($data)) {
            throw new JiraException("Data expects an array value");
        }

        $this->mappingDeserialize($this->getObjectMappings(), $data);
        $this->deserialize($data);
    }

    private final function mappingDeserialize($mapping, $data)
    {
        foreach ($mapping as $key => $value) {
            if (isset($data[$key])) {
                if (isset($value['_type'])) {
                    $propertyName = isset($value['_property']) ? $value['_property'] : $key;

                    if (property_exists($this, $propertyName)) {
                        if ($value['_type'] === 'array') {
                            $this->{$propertyName} = $this->deserializeArrayValue($value['_itemType'], $data[$key]);
                        } else {
                            $this->{$propertyName} = $this->deserializeValue($value['_type'], $data[$key]);
                        }
                    }
                } else {
                    $this->mappingDeserialize($value, $data[$key]);
                }
            }
        }
    }

    protected function deserialize($data)
    {
        
    }

    private function deserializeArrayValue($type, $data)
    {
        $result = array();

        foreach ($data as $value) {
            $result[] = $this->deserializeValue($type, $value);
        }

        return $result;
    }

    private function deserializeValue($type, $data)
    {
        if ($type == 'string') {
            return $data;
        }

        if ($type == 'integer') {
            return $data;
        }

        if ($type == 'assoc') {
            return $data;
        }

        if ($type == 'boolean') {
            return $data;
        }

        if ($type == 'date') {
            return new \DateTime($data);
        }

        if ($type == 'user') {
            return new UserResource($this->client, $data);
        }

        if ($type == 'project') {
            return new ProjectResource($this->client, $data);
        }

        if ($type == 'attachment') {
            return new AttachmentResource($this->client, $data);
        }
        
        if ($type == 'priority') {
            return new PriorityResource($this->client, $data);
        }
        
        if ($type == 'issuetype') {
            return new IssueTypeResource($this->client, $data);
        }
        
        if ($type == 'watches') {
            return new WatchesResource($this->client, $data);
        }

        return null;
    }

    public function getObjectMappings()
    {
        return array();
    }

    /**
     * 
     * @return JiraClient
     */
    public function getClient()
    {
        return $this->client;
    }

}
