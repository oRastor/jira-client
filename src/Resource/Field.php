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
    const DATE = 'date';
    const ARRAY_TYPE = 'array';
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
    const DUE_DATE = 'duedate';
    const ASSIGNEE = 'assigne';
    const DESCRIPTION = 'description';
    const CUSTOM_PREFIX = 'customfield_';
    const OPTION = 'option';
    const OPTION_WITH_CHILD = 'option-with-child';

    private static function getSaveArrayValue($name, $value, $metadata)
    {
        $result = array();

        $itemsType = $metadata[$name]->getSchema()->getItems();

        foreach ($value as $item) {
            $operation = null;
            $realValue = null;
            $realResult = null;

            if ($item instanceof FieldOperation) {
                $operation = $item->getName();

                if (!in_array($operation, $metadata[$name]->getOperations())) {
                    throw new JiraException("Not allowed operation '{$operation}' for '{$name}' field!");
                }

                $realValue = $item->getValue();
            } else {
                $realValue = $item;
            }

            if (in_array($itemsType, array(self::COMPONENT, self::GROUP, self::USER, self::VERSION))) {
                $realResult = array(
                    'name' => $realValue
                );
            } elseif ($itemsType == self::STRING) {
                if ($metadata[$name]->getSchema()->getCustom() == 'com.atlassian.jira.plugin.system.customfieldtypes:multicheckboxes') {
                    $realResult = array(
                        'value' => (string) $realValue
                    );
                } else {
                    $realResult = (string) $realValue;
                }
            }

            if ($operation !== null) {
                array_push($result, array(
                    $operation => $realResult
                ));
            } else {
                array_push($result, $realResult);
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
            throw new JiraException("Field '{$name}' metadata is missing a type");
        }

        $type = $metadata[$name]->getSchema()->getType();

        if ($type == self::STRING) {
            if ($value == null) {
                $value = '';
            }

            if ($metadata[$name]->getSchema()->getCustom() == 'com.atlassian.jira.plugin.system.customfieldtypes:select') {
                return array(
                    'value' => (string) $value
                );
            }

            return (string) $value;
        } else if ($type == self::NUMBER) {
            return $value;
        } else if ($type == self::ARRAY_TYPE) {
            if ($value == null) {
                $value = array();
            }

            if (!is_array($value)) {
                throw new JiraException("Field expects an array value");
            }

            if ($metadata[$name]->getSchema()->getCustom() == 'com.atlassian.jira.plugin.system.customfieldtypes:cascadingselect') {
                return $value;
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
        } else if ($type == self::DATE) {
            if ($value == null) {
                return null;
            }

            return $value->format('Y-m-d');
        } else if ($type == self::OPTION) {
            /** @var FieldMetadata $fieldMetadata */
            $fieldMetadata = $metadata[$name];
            /** @var CustomFieldOption $customField */
            foreach ($fieldMetadata->getAllowedValues() as $customField) {
                if (strtolower($customField->getValue()) === strtolower($value)) {
                    return ['value' => $customField->getValue()];
                }
            }
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
