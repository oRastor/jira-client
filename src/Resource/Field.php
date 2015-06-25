<?php

namespace JiraClient\Resource;

use JiraClient\JiraClient,
    JiraClient\Exception\JiraException;

/**
 * Description of Field
 *
 * @author rastor
 */
class Field
{

    const STRING = 'string';
    const NUMBER = 'number';
    const ARRAY_FIELD = 'array';
    const PROJECT = 'project';
    const ISSUE_TYPE = 'issuetype';
    const ISSUE_LINK = 'issuelink';
    const SUMMARY = 'summary';
    const LABELS = 'labels';
    const COMPONENT = 'component';
    const GROUP = 'group';
    const USER = 'user';
    const VERSION = 'version';
    const PRIORITY = 'priority';
    const CUSTOM_PREFIX = 'customfield_';

    private static function getSaveArrayValue($name, $value, $metadata)
    {
        $result = array();

        $itemsType = $metadata[$name]['schema']['items'];

        foreach ($value as $item) {
            $operation = null;
            $realValue = null;
            $realResult = null;

            if ($item instanceof FieldOperation) {
                $operation = $item->getName();

                if (!in_array($operation, $metadata[$name]['operations'])) {
                    throw new JiraException("Not allowed operation '{$operation}' for '{$name}' field!");
                }

                $realValue = $item->getValue();
            } else {
                $realValue = $item;
            }

            if (in_array($itemsType, array(self::COMPONENT, self::GROUP, self::USER, self::VERSION))) {
                $realResult = array(
                    'name' => $value
                );
            } elseif ($itemsType == self::STRING) {
                $realResult = $value;
            }

            if ($operation !== null) {
                array_push($result, array(
                    $operation => $realValue
                ));
            } else {
                array_push($result, $realValue);
            }
        }

        return $result;
    }

    public static function getSaveValue($name, $value, $metadata)
    {
        if (!isset($metadata[$name])) {
            throw new JiraException("Field '{$name}' does not exist or read-only");
        }

        if ($metadata[$name]->getSchema()->getType() === null) {
            throw new JiraException("Field metadata is missing a type");
        }

        $type = $metadata[$name]->getSchema()->getType();

        if ($type == self::NUMBER || $type == self::STRING) {
            return $value;
        } else if ($type == self::ARRAY_FIELD) {
            if ($value == null) {
                $value = array();
            }

            if (!is_array($value)) {
                throw new JiraException("Field expects an array value");
            }

            return self::getSaveArrayValue($name, $value, $metadata);
        } else if (in_array($type, array(self::ISSUE_TYPE, self::PRIORITY, self::USER))) {
            return array(
                'name' => $value
            );
        } else if (in_array($type, array(self::PROJECT, self::ISSUE_LINK))) {
            return array(
                'key' => $value
            );
        }

        throw new JiraException("Field type '{$type}' not supported");
    }

    public static function getRequiredFields($metadata)
    {
        $required = array();

        foreach ($metadata as $key => $value) {
            if ($value->isRequired()) {
                array_push($required, $key);
            }
        }

        return $required;
    }

    /**
     * Returns a full representation of the Custom Field Option that has the given id.
     * 
     * @param JiraClient $client
     * @param int $id
     * @return \JiraClient\Resource\CustomFieldOption
     * @throws JiraException
     */
    public static function getCustomFieldOption(JiraClient $client, $id)
    {
        $path = "/customFieldOption/{$id}";

        try {
            $data = $client->callGet($path)->getData();
            $data['id'] = $id;

            return new CustomFieldOption($client, $data);
        } catch (Exception $e) {
            throw new JiraException("Failed to get custom field option", $e);
        }
    }

}
