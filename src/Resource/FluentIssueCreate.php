<?php

namespace JiraClient\Resource;

use JiraClient\JiraClient,
    JiraClient\Resource\IssueResource,
    JiraClient\Exception\JiraException;

/**
 * Description of FluentIssueCreate
 *
 * @author rastor
 */
class FluentIssueCreate
{

    /**
     *
     * @var JiraClient 
     */
    private $client;
    private $fields = array();
    private $createMetadata;

    public function __construct(JiraClient $client, $createMetadata)
    {
        $this->client = $client;
        $this->createMetadata = $createMetadata;
    }

    public function execute($includedFields = null)
    {
        foreach ($this->fields as $name => $value) {
            $this->fields[$name] = Field::getSaveValue($name, $value, $this->createMetadata);
        }

        $required = Field::getRequiredFields($this->createMetadata);

        foreach ($required as $name) {
            if (!isset($this->fields[$name])) {
                throw new JiraException("Field '{$name}' is required!");
            }
        }

        $data = array(
            'fields' => $this->fields
        );

        try {
            $result = $this->client->callPost('/issue', $data)->getData();
        } catch (Exception $e) {
            throw new JiraException("Failed to create issue", $e);
        }
        
        return Issue::getIssue($this->client, $result['id'], $includedFields);
    }

    public function field($name, $value)
    {
        $this->fields[$name] = $value;

        return $this;
    }

}