<?php

namespace JiraClient\Resource;

/**
 * Description of a Worklog
 *
 * @author pbrasseur
 */
class Worklog extends AbstractResource
{

    /**
     *
     * @var string
     */
    protected $self;

    /**
     *
     * @var \JiraClient\Resource\AuthorResource
     */
    protected $author;

    /**
     *
     * @var \JiraClient\Resource\AuthorResource
     */
    protected $updateAuthor;

    /**
     *
     * @var \DateTime
     */
    protected $updated;

    /**
     *
     * @var \DateTime
     */
    protected $started;

    /**
     *
     * @var string
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $issueId;

    /**
     *
     * @var string
     */
    protected $comment;

    /**
     *
     * @var string
     */
    protected $timeSpent;

    /**
     *
     * @var string
     */
    protected $timeSpentSeconds;


    public function getObjectMappings()
    {
        return array(
            'self' => array(
                '_type' => 'string'
            ),
            'author' => array(
                '_type' => 'user'
            ),
            'updateAuthor' => array(
                '_type' => 'user'
            ),
            'updated' => array(
                '_type' => 'date'
            ),
            'started' => array(
                '_type' => 'date'
            ),
            'id' => array(
                '_type' => 'integer'
            ),
            'issueId' => array(
                '_type' => 'integer'
            ),
            'comment' => array(
                '_type' => 'string'
            ),
            'timeSpent' => array(
                '_type' => 'string'
            ),
            'timeSpentSeconds' => array(
                '_type' => 'integer'
            ),
        );
    }

    /**
     * @return string
     */
    public function getSelf()
    {
        return $this->self;
    }

    /**
     * @return AuthorResource
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return AuthorResource
     */
    public function getUpdateAuthor()
    {
        return $this->updateAuthor;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return \DateTime
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIssueId()
    {
        return $this->issueId;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getTimeSpent()
    {
        return $this->timeSpent;
    }

    /**
     * @return string
     */
    public function getTimeSpentSeconds()
    {
        return $this->timeSpentSeconds;
    }


    public function getSaveData()
    {
        $data = array(
            'comment' => $this->comment
        );

        if (isset($this->visibility)) {
            $data['visibility'] = $this->getVisibility()->getSaveData();
        }

        return $data;
    }

}
