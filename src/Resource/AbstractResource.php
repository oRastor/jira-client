<?php

namespace JiraClient\Resource;

use JiraClient\JiraClient;

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

    public function __construct(JiraClient $client, $data = null)
    {
        $this->client = $client;

        if ($data == null) {
            return;
        }

        if (is_object($data)) {
            $data = (array) $data;
        }

        if (!is_array($data)) {
            // error
        }

        $mappings = $this->getObjectMappings();
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->setPropery($key, $value, $mappings);
            }
        }
    }

    private function setPropery($key, $value, $mappings)
    {
        if (!isset($mappings[$key])) {
            $this->{$key} = $value;
            return;
        }

        switch ($mappings[$key]['result']) {
            case 'object':
                if ($value === null) {
                    $this->{$key} = null;
                } else {
                    $className = $mappings[$key]['className'];
                    $this->{$key} = new $className($this->client, $value);
                }
                break;

            case 'array':
                if ($value === null) {
                    $this->{$key} = array();
                } else {
                    $className = $mappings[$key]['className'];
                    $this->{$key} = $this->buildList((array) $value, $className);
                }
                break;

            case 'assoc':
                if ($value === null) {
                    $this->{$key} = array();
                } else {
                    $this->{$key} = (array) $value;
                }
                break;

            default:
                //error: invalid mapping record
                break;
        }
    }

    public static function buildList(array $data, $className = null)
    {
        if ($className === null) {
            $className = get_called_class();
        }

        $list = array();
        foreach ($data as $object) {
            $list[] = new $className($object);
        }
        return $list;
    }

    public function getSaveData()
    {
        return array();
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
