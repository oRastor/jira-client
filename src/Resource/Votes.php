<?php

namespace JiraClient\Resource;

/**
 * Description of Votes
 *
 * @author rastor
 */
class Votes extends AbstractResource
{

    /**
     *
     * @var string
     */
    protected $self;

    /**
     *
     * @var int
     */
    protected $votes;

    /**
     *
     * @var bool
     */
    protected $hasVoted;

    /**
     *
     * @return string
     */
    public function getSelf()
    {
        return $this->self;
    }

    /**
     *
     * @return int
     *
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     *
     * @return bool
     *
     */
    public function hasVoted()
    {
        return $this->hasVoted;
    }

    public function getObjectMappings()
    {
        return array(
            'self' => array(
                '_type' => 'string'
            ),
            'votes' => array(
                '_type' => 'integer'
            ),
            'hasVoted' => array(
                '_type' => 'boolean'
            )
        );
    }

}
