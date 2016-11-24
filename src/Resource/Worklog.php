<?php

namespace JiraClient\Resource;

/**
 * Description of a Worklog
 *
 * @author rastor
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
