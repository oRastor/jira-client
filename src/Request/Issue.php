<?php

namespace JiraClient\Request;

use Exception;
use JiraClient\JiraClient,
    JiraClient\Exception\JiraException,
    JiraClient\Resource\Field,
    JiraClient\Resource\AbstractResource,
    JiraClient\Resource\ResourcesList,
    JiraClient\Resource\FieldMetadata,
    JiraClient\Resource\Comment,
    JiraClient\Resource\FluentIssueCreate,
    JiraClient\Resource\Worklog;

/**
 * Description of Issue
 *
 * @author pbrasseur
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

            return AbstractResource::deserializeListValue('comment', 'comments', $result->getData(), $this->client);
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

    public function getWorklogs($issue)
    {
        $path = "/issue/{$issue}/worklog";

        try {
            $data = $this->client->callGet($path)->getData();
            return AbstractResource::deserializeListValue('worklog', 'worklogs', $data, $this->client);

        } catch (\Exception $e) {
            throw new JiraException("Failed to retrieve worklogs for issue '{$issue}'", $e);
        }
    }

    public function getWorklog($issue, $worklogId)
    {
        $path = "/issue/{$issue}/worklog/{$worklogId}";

        try {
            return new Worklog($this->client, $this->client->callGet($path)->getData());
        } catch (\Exception $e) {
            throw new JiraException("Failed to retrieve worklog '{$worklogId} for issue {$issue}'", $e);
        }
    }

    public function addWorklog($issue, $comment, \DateTime $started, $timeSpentInSeconds, $visibilityType = null, $visibilityName = null, $expand = false)
    {
        $path = "/issue/{$issue}/worklog" . ($expand ? '?expand' : '');

        $data = array(
            'comment' => $comment,
            'started' => $started->format('Y-m-d\TH:i:s.000O'),
            'timeSpentSeconds' => $timeSpentInSeconds,
        );

        if ($visibilityType !== null && $visibilityName !== null) {
            $data['visibility'] = array(
                'type' => $visibilityType,
                'value' => $visibilityName
            );
        }

        try {
            $result = $this->client->callPost($path, $data);

            return new Worklog($this->client, $result->getData());
        } catch (Exception $e) {
            throw new JiraException("Failed to add worklog", $e);
        }
    }

    public function updateWorklog($issue, $worklogId, $comment = null, $started = null, $timeSpentInSeconds = null, $visibilityType = null, $visibilityName = null, $expand = false)
    {
        $path = "/issue/{$issue}/worklog/{$worklogId}" . ($expand ? '?expand' : '');

        $data = array_filter(array(
            'comment' => $comment,
            'started' => ($started instanceof \DateTime) ? $started->format('Y-m-d\TH:i:s.000O') : null,
            'timeSpentSeconds' => $timeSpentInSeconds,
        ), function($i){
            return !is_null($i);
        });

        if ($visibilityType !== null && $visibilityName !== null) {
            $data['visibility'] = array(
                'type' => $visibilityType,
                'value' => $visibilityName
            );
        }

        try {
            $result = $this->client->callPut($path, $data);

            return new Worklog($this->client, $result->getData());
        } catch (Exception $e) {
            throw new JiraException("Failed to update worklog", $e);
        }
    }

    public function deleteWorklog($issue, $worklog)
    {
        $path = "/issue/{$issue}/worklog/{$worklog}";

        try {
            $this->client->callDelete($path);
        } catch (Exception $e) {
            throw new JiraException("Failed to delete worklog '{$worklog}' for issue '{$issue}'", $e);
        }
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

    /**
     * 
     * @param type $jql
     * @param type $includedFields
     * @param type $expandFields
     * @param type $maxResults
     * @param type $startAt
     * @return SearchIterator
     */
    public function search($jql, $includedFields = null, $expandFields = false, $fetchSize = 100)
    {
        return new SearchIterator($this->client, $jql, $includedFields, $expandFields, $fetchSize);
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
