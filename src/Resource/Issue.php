<?php

namespace JiraClient\Resource;

use JiraClient\JiraClient,
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
     * @var \JiraClient\Resource\IssueFieldsResource 
     */
    protected $fields;

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
     * @return \JiraClient\Resource\IssueFieldsResource
     */
    public function getFields()
    {
        return $this->fields;
    }

    public function getObjectMappings()
    {
        return array(
            'fields' => array(
                'result' => 'object',
                'className' => '\JiraClient\Resource\IssueFieldsResource'
            )
        );
    }

    public function getSaveData()
    {
        return array(
            'fields' => $this->getFields()->getSaveData()
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
