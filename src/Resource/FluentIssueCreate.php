<?php

namespace JiraClient\Resource;

use JiraClient\JiraClient,
    JiraClient\Resource\Issue,
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
                throw new JiraException("Field '{$name}' is required");
            }
        }

        $data = array(
            'fields' => $this->fields
        );
        
        try {
            $result = $this->client->callPost('/issue', $data)->getData();
        } catch (\Exception $e) {
            throw new JiraException("Failed to create issue", $e);
        }

        return $this->client->issue()
                        ->get($result['id'], $includedFields);
    }

    public function field($name, $value)
    {
        $this->fields[$name] = $value;

        return $this;
    }

    public function customField($id, $value)
    {
        $this->field(Field::CUSTOM_PREFIX . $id, $value);

        return $this;
    }

}
