<?php

namespace JiraClient\Resource;

use JiraClient\JiraClient,
    JiraClient\Resource\User,
    JiraClient\Exception\JiraException;

/**
 * Description of Issue
 *
 * @author rastor
 */
class Issue extends AbstractResource
{

    /**
     *
     * @var string
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $self;

    /**
     *
     * @var string
     */
    protected $key;

    /**
     *
     * @var string
     */
    protected $summary;

    /**
     *
     * @var string
     */
    protected $description;

    /**
     *
     * @var IssueType
     */
    protected $issueType;

    /**
     *
     * @var Status
     */
    protected $status;

    /**
     *
     * @var User
     */
    protected $creator;

    /**
     *
     * @var User
     */
    protected $reporter;

    /**
     *
     * @var User
     */
    protected $assignee;

    /**
     *
     * @var Watches
     */
    protected $watches;

    /**
     *
     * @var Project
     */
    protected $project;

    /**
     *
     * @var array
     */
    protected $labels;

    /**
     *
     * @var array
     */
    protected $attachments;

    /**
     *
     * @var ResourcesList
     */
    protected $comments;

    /**
     *
     * @var \DateTime
     */
    protected $dueDate;

    /**
     *
     * @var Priority
     */
    protected $priority;

    /**
     *
     * @var Votes
     */
    protected $votes;

    /**
     *
     * @var \DateTime
     */
    protected $lastViewed;

    /**
     *
     * @var \DateTime
     */
    protected $created;

    /**
     *
     * @var \DateTime
     */
    protected $updated;

    /**
     *
     * @var array
     */
    protected $customFields = array();

    /**
     *
     * @var array
     */
    protected $createMetadata = null;

    /**
     *
     * @var array
     */
    protected $editMetadata = null;

    /**
     *
     * @var array
     */
    protected $totalMetadata = null;

    /**
     *
     * @return string
     *
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return string
     *
     */
    public function getSelf()
    {
        return $this->self;
    }

    /**
     *
     * @return string
     *
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * 
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 
     * @return IssueType
     */
    public function getIssueType()
    {
        return $this->issueType;
    }

    /**
     * 
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 
     * @return User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * 
     * @return User
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * 
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * 
     * @return Watches
     */
    public function getWatches()
    {
        return $this->watches;
    }

    /**
     * 
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * 
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * 
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * 
     * @return ResourcesList
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * 
     * @return Priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * 
     * @return Votes
     */
    public function getVotes()
    {
        return $this->votes;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * 
     * @return \DateTime
     */
    public function getLastViewed()
    {
        return $this->lastViewed;
    }

    /**
     * 
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * 
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    public function getObjectMappings()
    {
        return array(
            'id' => array(
                '_type' => 'integer'
            ),
            'key' => array(
                '_type' => 'string'
            ),
            'fields' => array(
                'summary' => array(
                    '_type' => 'string'
                ),
                'description' => array(
                    '_type' => 'string'
                ),
                'issuetype' => array(
                    '_type' => 'issuetype',
                    '_property' => 'issueType'
                ),
                'status' => array(
                    '_type' => 'status',
                    '_property' => 'status'
                ),
                'creator' => array(
                    '_type' => 'user'
                ),
                'reporter' => array(
                    '_type' => 'user'
                ),
                'assignee' => array(
                    '_type' => 'user'
                ),
                'watches' => array(
                    '_type' => 'watches'
                ),
                'project' => array(
                    '_type' => 'project'
                ),
                'labels' => array(
                    '_type' => 'array',
                    '_itemType' => 'string'
                ),
                'attachment' => array(
                    '_type' => 'array',
                    '_itemType' => 'attachment',
                    '_property' => 'attachments'
                ),
                'priority' => array(
                    '_type' => 'priority'
                ),
                'votes' => array(
                    '_type' => 'votes'
                ),
                'comment' => array(
                    '_type' => 'list',
                    '_itemType' => 'comment',
                    '_listKey' => 'comments',
                    '_property' => 'comments'
                ),
                'duedate' => array(
                    '_type' => 'date',
                    '_property' => 'dueDate'
                ),
                'lastViewed' => array(
                    '_type' => 'date'
                ),
                'created' => array(
                    '_type' => 'date'
                ),
                'updated' => array(
                    '_type' => 'date'
                )
            )
        );
    }

    private function getMetadata()
    {
        if ($this->totalMetadata !== null) {
            return $this->totalMetadata;
        }

        if ($this->createMetadata === null) {
            $this->createMetadata = $this->client->issue()->getCreateMetadataFields($this->getProject()->getKey(), $this->getIssueType()->getName());
        }

        if ($this->editMetadata === null) {
            $this->editMetadata = $this->client->issue()->getEditMetadataFields($this->getKey());
        }

        $this->totalMetadata = array_merge($this->createMetadata, $this->editMetadata);

        return $this->totalMetadata;
    }

    protected function deserialize($data)
    {
        $metadata = $this->getMetadata();

        //process custom fields
        foreach ($data['fields'] as $key => $value) {
            if (strpos($key, Field::CUSTOM_PREFIX) !== 0) {
                continue;
            }

            $metadata = $this->getFieldMetadata($key);

            $id = substr($key, strlen(Field::CUSTOM_PREFIX));

            if ($metadata === false) {
                $this->customFields[$id] = $value;
                continue;
            }
            
            $schema = $metadata->getSchema();
            if ($schema->getType() === Field::ARRAY_TYPE) {
                if ($schema->getCustom() == 'com.atlassian.jira.plugin.system.customfieldtypes:cascadingselect') {
                    $this->customFields[$id] = self::deserializeValue('customFieldNestedValue', $value, $this->client);
                } elseif ($schema->getCustom() == 'com.atlassian.jira.plugin.system.customfieldtypes:multicheckboxes') {
                    $this->customFields[$id] = self::deserializeArrayValue('customfieldoption', $value, $this->client);
                } else {
                    $this->customFields[$id] = self::deserializeArrayValue($schema->getItems(), $value, $this->client);
                }
            } else {
                $this->customFields[$id] = self::deserializeValue($schema->getType(), $value, $this->client, $schema->getCustom());
            }
        }
    }

    public function getCustomFieldsNames()
    {
        $metadata = $this->getMetadata();

        $result = array();

        foreach (array_keys($this->customFields) as $id) {
            $result[$id] = $metadata[Field::CUSTOM_PREFIX . $id]->getName();
        }

        return $result;
    }

    public function getCustomField($id)
    {
        if (!isset($this->customFields[$id])) {
            return null;
        }
        
        return $this->customFields[$id];
    }

    /**
     * 
     * @param string $name
     * @return FieldMetadata | boolean
     */
    public function getFieldMetadata($name)
    {
        $metadata = $this->getMetadata();

        if (!isset($metadata[$name])) {
            return false;
        }

        return $metadata[$name];
    }

    /**
     * 
     * @param int $id
     * @return FieldMetadata | boolean
     */
    public function getCustomFieldMetadata($id)
    {
        return $this->getFieldMetadata(Field::CUSTOM_PREFIX . $id);
    }

    public function getCustomFieldType($id)
    {
        $metadata = $this->getMetadata();

        if (!isset($metadata[Field::CUSTOM_PREFIX . $id])) {
            return false;
        }

        return $metadata[Field::CUSTOM_PREFIX . $id]->getSchema()->getType();
    }

    public function getCustomFieldAllowedValues($id)
    {
        $metadata = $this->getMetadata();

        if (!isset($metadata[Field::CUSTOM_PREFIX . $id])) {
            return false;
        }

        return $metadata[Field::CUSTOM_PREFIX . $id]->getAllowedValues();
    }

    public function update()
    {
        if ($this->editMetadata === null) {
            $this->editMetadata = $this->client->issue()->getEditMetadataFields($this->getKey());
        }

        return new FluentIssueUpdate($this, $this->editMetadata);
    }

    public function transition()
    {
        return new FluentIssueTransition($this);
    }

    public function refresh()
    {
        
    }

    public function addComment($body, $visibilityType = null, $visibilityName = null)
    {
        $this->client->issue()->addComment($this->getId(), $body, $visibilityType, $visibilityName);

        return $this;
    }

}
