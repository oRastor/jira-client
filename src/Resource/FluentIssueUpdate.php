<?php

namespace JiraClient\Resource;

use JiraClient\JiraClient,
    JiraClient\Resource\IssueResource,
    JiraClient\Exception\JiraException;

/**
 * Description of FluentIssueUpdate
 *
 * @author rastor
 */
class FluentIssueUpdate
{

    /**
     *
     * @var Issue
     */
    private $issue;
    private $fields = array();
    private $fieldOperations = array();
    private $updateMetadata;

    public function __construct(Issue $issue, $updateMetadata)
    {
        $this->issue = $issue;
        $this->updateMetadata = $updateMetadata;
    }

    public function execute($includedFields = null)
    {
        if (!count($this->fields) && !count($this->fieldOperations)) {
            throw new JiraException("No fields to update");
        }

        foreach ($this->fields as $name => $value) {
            $this->fields[$name] = Field::getSaveValue($name, $value, $this->updateMetadata);
        }

        foreach ($this->fieldOperations as $name => $value) {
            $this->fieldOperations[$name] = Field::getSaveValue($name, $value, $this->updateMetadata);
        }

        $data = array();

        if (count($this->fieldOperations)) {
            $data['update'] = $this->fieldOperations;
        }

        if (count($this->fields)) {
            $data['fields'] = $this->fields;
        }

        try {
            $this->issue->getClient()->callPut('/issue/' . $this->issue->getKey(), $data)->getData();
        } catch (Exception $e) {
            throw new JiraException("Failed to create issue", $e);
        }

        return Issue::getIssue($this->issue->getClient(), $this->issue->getKey(), $includedFields);
    }

    public function field($name, $value)
    {
        $this->fields[$name] = $value;

        return $this;
    }

    public function fieldOperation($operation, $name, $value)
    {
        $this->fieldOperations[$name][] = new FieldOperation($operation, $value);

        return $this;
    }

    public function fieldAdd($name, $value)
    {
        return $this->fieldOperation(FieldOperation::ADD, $name, $value);
    }

    public function fieldRemove($name, $value)
    {
        return $this->fieldOperation(FieldOperation::REMOVE, $name, $value);
    }

}