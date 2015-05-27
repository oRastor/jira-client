<?php

namespace JiraClient\Request;

use JiraClient\JiraClient,
    JiraClient\Resource\IssueResource,
    JiraClient\Resource\CommentResource,
    JiraClient\Resource\IssueFieldsResource;

/**
 * Description of CommentsRequest
 *
 * @author rastor
 */
class IssueRequest
{

    public function addComment($issue, CommentResource $comment, $expand = false)
    {
        $path = '/issue/' . $issue . '/comment' . ($expand ? '?expand' : '');

        $response = $this->client->call(self::METHOD_POST, $path, $comment->getSaveData());

        $result = $response->getData();

        return $result;
    }

    /**
     * 
     * @param string $issue id or key of issue
     * @param boolean $expand if true provides body rendered in HTML
     * 
     * @return CommentResource resource
     */
    public function getComment($issue, $id, $expand = false)
    {
        $path = '/issue/' . $issue . '/comment/' . $id . ($expand ? '?expand' : '');

        $response = $this->client->call(self::METHOD_GET, $path);

        $result = $response->getData();

        return new CommentResource($result);
    }

    /**
     * 
     * @param string $issue id or key of issue
     * @param boolean $expand if true provides body rendered in HTML
     * @todo Add possibility to set visibility option
     */
    public function updateComment($issue, $id, CommentResource $comment, $expand = false)
    {
        $path = '/issue/' . $issue . '/comment/' . $id . ($expand ? '?expand' : '');

        $response = $this->client->call(self::METHOD_PUT, $path, $comment->getSaveData());

        $result = $response->getData();

        return new CommentResource($result);
    }

    /**
     * 
     * @param string $issue id or key of issue
     */
    public function deleteComment($issue, $id)
    {
        $path = '/issue/' . $issue . '/comment/' . $id;

        $response = $this->client->call(self::METHOD_DELETE, $path);

        $result = $response->getData();

        return $result;
    }

    /**
     * 
     * @param string $issue id or key of issue
     * @param boolean $expand if true provides body rendered in HTML
     */
    public function getComments($issue, $expand = false)
    {
        $path = '/issue/' . $issue . '/comment' . ($expand ? '?expand' : '');

        $response = $this->client->call(self::METHOD_GET, $path);

        $result = $response->getData();

        $result->comments = CommentResource::buildList($result->comments);

        return $result;
    }

    public static function getIssue(JiraClient $client, $issue, $fields = '*all', $expand = false)
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

    public function updateIssue($issue, IssueFieldsResource $fields, $expand = false)
    {
        $path = '/issue/' . $issue . '?fields=' . $fields . ($expand ? '?expand' : '');

        $response = $this->client->call(self::METHOD_GET, $path);

        $result = $response->getData();

        return new IssueResource($result);
    }

    /**
     * 
     * @param string $issue id or key of issue
     * @param $deleteSubtasks string a String of true or false indicating that any subtasks should also be deleted. If the issue has no subtasks this parameter is ignored. If the issue has subtasks and this parameter is missing or false, then the issue will not be deleted and an error will be returned.
     */
    public function deleteIssue($issue, $deleteSubtasks = null)
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

}
