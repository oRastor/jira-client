<?php

namespace JiraClient\Resource;

use JiraClient\Exception\JiraException;

/**
 * Description of Field
 *
 * @author rastor
 */
class Field
{

    const PROJECT = 'project';
    const ISSUE_TYPE = 'issuetype';
    const SUMMARY = 'summary';
    const LABELS = 'labels';

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

            if (in_array($itemsType, array('component', 'group', 'user', 'version'))) {
                $realResult = array(
                    'name' => $value
                );
            } elseif ($itemsType == 'string') {
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

        if (!isset($metadata[$name]['schema']['type'])) {
            throw new JiraException("Field metadata is missing a type");
        }

        $type = $metadata[$name]['schema']['type'];

        if ($type == 'number') {
            return $value;
        } else if ($type == 'string') {
            return $value;
        } else if ($type == 'array') {
            if ($value == null) {
                $value = array();
            }

            if (!is_array($value)) {
                throw new JiraException("Field expects an array value");
            }

            return self::getSaveArrayValue($name, $value, $metadata);
        } else if (in_array($type, array('issuetype', 'priority', 'user', 'resolution'))) {
            return array(
                'name' => $value
            );
        } else if (in_array($type, array('project', 'issuelink'))) {
            return array(
                'key' => $value
            );
        }

        throw new JiraException("Field type '{$type}' not supported!");
    }

    public static function getRequiredFields($metadata)
    {
        $required = array();

        foreach ($metadata as $key => $value) {
            if ($value['required']) {
                array_push($required, $key);
            }
        }

        return $required;
    }

}
