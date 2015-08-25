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

    private function mappingDeserialize($mapping, $data)
    {   
        foreach ($mapping as $key => $value) {
            if (!isset($data[$key])) {
                $data[$key] = null;
            }
            
            if (isset($value['_type'])) {
                $propertyName = isset($value['_property']) ? $value['_property'] : $key;

                if ($value['_type'] === 'list') {
                    $this->{$propertyName} = self::deserializeListValue($value['_itemType'], $value['_listKey'], $data[$key], $this->client);
                } else if ($value['_type'] === 'array') {
                    $this->{$propertyName} = self::deserializeArrayValue($value['_itemType'], $data[$key], $this->client);
                } else {
                    $this->{$propertyName} = self::deserializeValue($value['_type'], $data[$key], $this->client);
                }
            } else {
                $this->mappingDeserialize($value, $data[$key]);
            }
        }
    }

    protected function deserialize($data)
    {
        
    }

    public static function deserializeArrayValue($type, $data, $client)
    {
        $result = array();

        if (!is_array($data)) {
            return array();
        }

        foreach ($data as $value) {
            $result[] = self::deserializeValue($type, $value, $client);
        }

        return $result;
    }

    /**
     * 
     * @param type $type
     * @param type $key
     * @param type $data
     * @return \JiraClient\Resource\ResourcesList
     */
    public static function deserializeListValue($type, $key, $data, $client)
    {
        $start = (isset($data['startAt'])) ? $data['startAt'] : 0;
        $max = (isset($data['maxResults'])) ? $data['maxResults'] : 0;
        $total = (isset($data['total'])) ? $data['total'] : 0;

        $array = self::deserializeArrayValue($type, $data[$key], $client);

        return new ResourcesList($start, $max, $total, $array, $client);
    }

    protected static function deserializeValue($type, $data, $client)
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
            if ($data === null) {
                return null;
            }
            
            return new \DateTime($data);
        }

        if ($type == 'schema') {
            return new FieldMetadataSchema($client, $data);
        }

        if ($type == 'customfieldoption') {
            return new CustomFieldOption($client, $data);
        }

        if ($type == 'issue') {
            return new Issue($client, $data);
        }

        if ($type == 'comment') {
            return new Comment($client, $data);
        }

        if ($type == 'user') {
            return new User($client, $data);
        }

        if ($type == 'project') {
            return new Project($client, $data);
        }

        if ($type == 'attachment') {
            return new Attachment($client, $data);
        }

        if ($type == 'priority') {
            return new Priority($client, $data);
        }

        if ($type == 'issuetype') {
            return new IssueType($client, $data);
        }
        
        if ($type == 'status') {
            return new Status($client, $data);
        }
        
        if ($type == 'statusCategory') {
            return new StatusCategory($client, $data);
        }
        
        if ($type == 'transition') {
            return new Transition($client, $data);
        }

        if ($type == 'watches') {
            return new Watches($client, $data);
        }

        if ($type == 'votes') {
            return new Votes($client, $data);
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
