<?php

namespace JiraClient\Request;

use JiraClient\JiraClient,
    JiraClient\Exception\JiraException,
    JiraClient\Resource\Field,
    JiraClient\Resource\AbstractResource,
    JiraClient\Resource\ResourcesList,
    JiraClient\Resource\FieldMetadata,
    JiraClient\Resource\Comment,
    JiraClient\Resource\FluentIssueCreate;

/**
 * Description of Issue
 *
 * @author rastor
 */
class Issue extends AbstractRequest
{

    /**
     * Creates an issue or a sub-task
     * 
     * @param string $projectKey
     * @param string $issueTypeName
     * @return FluentIssueCreate
     * @throws JiraException
     */
    public function create($projectKey, $issueTypeName)
    {
        $fieldsMetadata = $this->getCreateMetadataFields($projectKey, $issueTypeName);

        $fluentIssueCreate = new FluentIssueCreate($this->client, $fieldsMetadata);

        return $fluentIssueCreate->field(Field::PROJECT, $projectKey)
                        ->field(Field::ISSUE_TYPE, $issueTypeName);
    }

    /**
     * 
     * @param string $projectKey
     * @param string $issueTypeName
     * @return JiraClient\Resource\FieldMetadata[]
     * @throws JiraException
     */
    public function getCreateMetadataFields($projectKey, $issueTypeName)
    {
        $metadata = $this->getCreateMetadata(null, $projectKey, null, $issueTypeName, true);

        if (!isset($metadata['projects'][0]['issuetypes'][0]['fields'])) {
            throw new JiraException("Project '$projectKey' and issue type '$issueTypeName' missing from create metadata");
        }

        $fieldsMetadata = array();
        foreach ($metadata['projects'][0]['issuetypes'][0]['fields'] as $key => $fieldData) {
            $fieldsMetadata[$key] = new FieldMetadata($this->client, $fieldData);
        }

        return $fieldsMetadata;
    }

    /**
     * 
     * @param string $issue
     * @return \JiraClient\Request\FieldMetadata
     */
    public function getEditMetadataFields($issue)
    {
        $metadata = $this->getEditMetadata($issue);

        $fieldsMetadata = array();
        foreach ($metadata['fields'] as $key => $fieldData) {
            $fieldsMetadata[$key] = new FieldMetadata($this->client, $fieldData);
        }

        return $fieldsMetadata;
    }

    /**
     * 
     * @param type $issue
     * @return \JiraClient\Resource\FluentIssueTransition
     */
    public function transition($issue)
    {
        return new \JiraClient\Resource\FluentIssueTransition($issue);
    }

    /**
     * Returns all comments for an issue.
     * 
     * @param string $issue
     * @param boolean $expand
     * @return ResourcesList
     * @throws JiraException
     */
    public function getComments($issue, $expand = false)
    {
        $path = "/issue/{$issue}/comment" . ($expand ? '?expand' : '');

        try {
            $result = $this->client->callGet($path);

            return AbstractResource::deserializeListValue(AbstractResource::COMMENT, 'comments', $result->getData(), $this->client);
        } catch (Exception $e) {
            throw new JiraException("Failed to get issue '{$issue}' commens", $e);
        }
    }

    /**
     * Returns all comments for an issue.
     * 
     * @param string $issue
     * @param int $commentId
     * @param boolean $expand
     * @return Comment
     * @throws JiraException
     */
    public function getComment($issue, $commentId, $expand = false)
    {
        $path = "/issue/{$issue}/comment/{$commentId}" . ($expand ? '?expand' : '');

        try {
            $result = $this->client->callGet($path);

            return new Comment($this->client, $result->getData());
        } catch (Exception $e) {
            throw new JiraException("Failed to get issue '{$issue}' commens", $e);
        }
    }

    /**
     * Adds a new comment to an issue.
     * 
     * @param string $issue
     * @param string $body
     * @param string $visibilityType
     * @param string $visibilityName
     * @param boolean $expand provides body rendered in HTML
     * @return Comment
     * @throws JiraException
     */
    public function addComment($issue, $body, $visibilityType = null, $visibilityName = null, $expand = false)
    {
        $path = "/issue/{$issue}/comment" . ($expand ? '?expand' : '');

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
            $result = $this->client->callPost($path, $data);

            return new Comment($this->client, $result->getData());
        } catch (Exception $e) {
            throw new JiraException("Failed to add comment", $e);
        }
    }

    /**
     * Updates an existing comment 
     * 
     * @param type $issue
     * @param int $commentId
     * @param type $body
     * @param type $visibilityType
     * @param type $visibilityName
     * @param type $expand
     * @return Comment
     * @throws JiraException
     */
    public function updateComment($issue, $commentId, $body, $visibilityType = null, $visibilityName = null, $expand = false)
    {
        $path = "/issue/{$issue}/comment/{$commentId}" . ($expand ? '?expand' : '');

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
            $result = $this->client->callPut($path, $data);

            return new Comment($this->client, $result->getData());
        } catch (Exception $e) {
            throw new JiraException("Failed to update comment", $e);
        }
    }

    /**
     * Deletes an existing comment
     * 
     * @param string $issue
     * @param int $commentId
     * @throws JiraException
     */
    public function deleteComment($issue, $commentId)
    {
        $path = "/issue/{$issue}/comment/{$commentId}";

        try {
            $this->client->callDelete($path);
        } catch (Exception $e) {
            throw new JiraException("Failed to delete comment", $e);
        }
    }

    /**
     * Returns the meta data for editing an issue.
     * 
     * @param string $issue
     * @return type
     * @throws JiraException
     */
    public function getEditMetadata($issue)
    {
        $path = "/issue/{$issue}/editmeta";

        try {
            $data = $this->client->callGet($path)->getData();

            if (!isset($data['fields'])) {
                throw new JiraException("Bad metadata");
            }

            return $data;
        } catch (Exception $e) {
            throw new JiraException("Failed to retrieve issue metadata", $e);
        }
    }

    public function notify()
    {
        
    }

    public function getWatchers()
    {
        
    }

    /**
     * Adds a user to an issue's watcher list.
     * 
     * @param string $issue
     * @param string $login
     * @return \JiraClient\Request\Issue
     * @throws JiraException
     */
    public function addWatcher($issue, $login)
    {
        $path = "/issue/{$issue}/watchers";

        try {
            $this->client->callPost($path, $login);
        } catch (Exception $e) {
            throw new JiraException("Failed to add watcher '{$login}' to issue '{$issue}'", $e);
        }

        return $this;
    }

    /**
     * Removes a user from an issue's watcher list.
     * 
     * @param string $issue
     * @param string $login
     * @throws JiraException
     */
    public function deleteWatcher($issue, $login)
    {
        $path = "/issue/{$issue}/watchers?username={$login}";

        try {
            $this->client->callDelete($path);
        } catch (Exception $e) {
            throw new JiraException("Failed to delete watcher '{$login}' to issue '{$issue}'", $e);
        }
    }

    public function getWorklog()
    {
        
    }

    public function addWorklog()
    {
        
    }

    public function updateWorklog()
    {
        
    }

    public function deleteWorklog()
    {
        
    }

    public function getCreateMetadata($projectIds = null, $projectKeys = null, $issueTypeIds = null, $issuetypeNames = null, $expandFields = true)
    {
        $queryParams = array();

        if ($expandFields) {
            $queryParams['expand'] = 'projects.issuetypes.fields';
        }

        if ($projectIds !== null) {
            $queryParams['projectIds'] = implode(',', (array) $projectIds);
        }

        if ($projectKeys !== null) {
            $queryParams['projectKeys'] = implode(',', (array) $projectKeys);
        }

        if ($issueTypeIds !== null) {
            $queryParams['issueTypeIds'] = implode(',', (array) $issueTypeIds);
        }

        if ($issuetypeNames !== null) {
            $queryParams['issuetypeNames'] = implode(',', (array) $issuetypeNames);
        }

        $path = "/issue/createmeta?" . http_build_query($queryParams);

        try {
            return $this->client->callGet($path)->getData();
        } catch (Exception $e) {
            throw new JiraException("Failed to retrieve create metadata", $e);
        }
    }

    public function search($jql, $includedFields = null, $expandFields = false, $maxResults = null, $startAt = null)
    {
        $params = array(
            'jql' => $jql
        );

        if ($includedFields !== null) {
            $params['fields'] = $includedFields;
        }

        if ($expandFields) {
            $params['expand'] = '';
        }

        if ($maxResults !== null) {
            $params['maxResults'] = $maxResults;
        }

        if ($startAt !== null) {
            $params['startAt'] = $startAt;
        }

        $path = "/search?" . http_build_query($params);

        //try {
        $data = $this->client->callGet($path)->getData();

        return AbstractResource::deserializeListValue('issue', 'issues', $data, $this->client);
    }

    /**
     * Returns a full representation of the issue for the given issue key.
     * 
     * @param string|int $issue the issue id or key to update
     * @param type $includedFields the list of fields to return for the issue. By default, all fields are returned.
     * @param type $expandFields
     * @return \JiraClient\Resource\Issue
     */
    public function get($issue, $includedFields = null, $expandFields = false)
    {
        $params = array();
        if ($includedFields !== null) {
            $params['fields'] = $includedFields;
        }

        if ($expandFields) {
            $params['expand'] = '';
        }

        $path = "/issue/{$issue}?" . http_build_query($params);

        $result = $this->client->callGet($path)->getData();

        return new \JiraClient\Resource\Issue($this->client, $result);
    }

    public function update($issue, IssueFieldsResource $fields, $expand = false)
    {
        $path = '/issue/' . $issue . '?fields=' . $fields . ($expand ? '?expand' : '');

        $response = $this->client->call(self::METHOD_GET, $path);

        $result = $response->getData();

        return new \JiraClient\Resource\Issue($this->client, $result);
    }

    /**
     * 
     * @param string $issue id or key of issue
     * @param $deleteSubtasks string a String of true or false indicating that any subtasks should also be deleted. If the issue has no subtasks this parameter is ignored. If the issue has subtasks and this parameter is missing or false, then the issue will not be deleted and an error will be returned.
     */
    public function delete($issue, $deleteSubtasks = false)
    {
        $params = '';
        if ($deleteSubtasks !== null) {
            $params = '?deleteSubtasks=' . ($deleteSubtasks ? 'true' : 'false');
        }
        $path = '/issue/' . $issue . $params;

        $response = $this->client->call(self::METHOD_DELETE, $path);

        $result = $response->getData();

        return $result;
    }

    public function getTransitions($issue, $transitionId = null, $expandFields = false)
    {
        $params = array();
        if ($transitionId !== null) {
            $params['transitionId'] = $transitionId;
        }

        if ($expandFields) {
            $params['expand'] = '';
        }

        $path = "/issue/{$issue}/transitions?" . http_build_query($params);

        $response = $this->client->callGet($path);

        $result = $response->getData();

        return AbstractResource::deserializeArrayValue('transition', $result['transitions'], $this->client);
    }

}
