<?php

namespace JiraClient\Resource;

use JiraClient\JiraClient,
    JiraClient\Resource\UserResource,
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
     * @var IssueTypeResource
     */
    protected $issueType;

    /**
     *
     * @var UserResource
     */
    protected $creator;
    
    /**
     *
     * @var UserResource
     */
    protected $reporter;

    /**
     *
     * @var UserResource
     */
    protected $assignee;
    
    /**
     *
     * @var WatchesResource
     */
    protected $watches;

    /**
     *
     * @var ProjectResource
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
     * @var PriorityResource
     */
    protected $priority;

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
     * @return IssueTypeResource
     */
    public function getIssueType()
    {
        return $this->issueType;
    }

    /**
     * 
     * @return UserResource
     */
    public function getCreator()
    {
        return $this->creator;
    }
    
    /**
     * 
     * @return UserResource
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * 
     * @return UserResource
     */
    public function getAssignee()
    {
        return $this->assignee;
    }
    
    /**
     * 
     * @return WatchesResource
     */
    public function getWatches()
    {
        return $this->watches;
    }

    /**
     * 
     * @return ProjectResource
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
     * @return PriorityResource
     */
    public function getPriority()
    {
        return $this->priority;
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
//                'comments' => array(
//                    '_type' => 'array',
//                    '_itemType' => 'comment'
//                ),
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

    public function update()
    {
        $metadata = self::getEditMetadata($this->client, $this->key);

        return new FluentIssueUpdate($this, $metadata);
    }

    public function addWatcher($login)
    {
        $path = "/issue/{$this->getKey()}/watchers";

        try {
            $this->client->callPost($path, $login);
        } catch (Exception $e) {
            throw new JiraException("Failed to add watcher '{$login}' to issue '{$this->getKey()}'", $e);
        }

        return $this;
    }

    public function deleteWatcher($login)
    {
        $path = "/issue/{$this->getKey()}/watchers?username={$login}";

        try {
            $this->client->callDelete($path);
        } catch (Exception $e) {
            throw new JiraException("Failed to delete watcher '{$login}' to issue '{$this->getKey()}'", $e);
        }

        return $this;
    }

    public function addComment($body, $visibilityType = null, $visibilityName = null)
    {
        $path = "/issue/{$this->getKey()}/comment";

        $data = array(
            'body' => $body
        );

        if ($visibilityType !== null && $visibilityName !== null) {
            $data['visibility'] = array(
                'type' => $visibilityType,
                'value' => $visibilityName
            );
        }

        try {
            $this->client->callPost($path, $data);
        } catch (Exception $e) {
            throw new JiraException("Failed to retrieve issue metadata", $e);
        }

        return $this;
    }

    private static function getEditMetadata(JiraClient $client, $issue)
    {
        $path = "/issue/{$issue}/editmeta";

        try {
            $data = $client->callGet($path)->getData();
        } catch (Exception $e) {
            throw new JiraException("Failed to retrieve issue metadata", $e);
        }

        if (!isset($data['fields'])) {
            throw new JiraException("Bad metadata!");
        }

        return $data['fields'];
    }

    private static function getCreateMetadata(JiraClient $client, $project, $issueType)
    {
        $path = "/issue/createmeta?expand=projects.issuetypes.fields&projectKeys={$project}&issuetypeNames={$issueType}";

        try {
            $data = $client->callGet($path)->getData();
        } catch (Exception $e) {
            throw new JiraException("Failed to retrieve issue metadata", $e);
        }

        if (!isset($data['projects'][0]['issuetypes'][0]['fields'])) {
            throw new JiraException("Project '$project' and issue type '$issueType' missing from create metadata");
        }

        return $data['projects'][0]['issuetypes'][0]['fields'];
    }

    public static function getIssue(JiraClient $client, $issue, $fields = null, $expand = false)
    {
        $params = array();
        if ($fields !== null) {
            $params['fields'] = $fields;
        }

        if ($expand) {
            $params['expand'] = '';
        }

        $path = "/issue/{$issue}?" . http_build_query($params);

        $result = $client->callGet($path)->getData();

        return new Issue($client, $result);
    }

    public static function createIssue(JiraClient $client, $project, $issueType)
    {
        $metadata = self::getCreateMetadata($client, $project, $issueType);

        $fluentIssueCreate = new FluentIssueCreate($client, $metadata);

        return $fluentIssueCreate->field(Field::PROJECT, $project)
                        ->field(Field::ISSUE_TYPE, $issueType);
    }

}
