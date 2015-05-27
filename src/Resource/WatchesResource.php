<?php

namespace JiraClient\Resource;

/**
 * Description of WatchesResource
 *
 * @author rastor
 */
class WatchesResource extends AbstractResource
{

    /**
     *
     * @var string
     */
    protected $self;

    /**
     *
     * @var integer
     */
    protected $watchCount;

    /**
     *
     * @var boolean
     */
    protected $isWatching;

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
     * @return integer
     */
    public function getWatchCount()
    {
        return $this->watchCount;
    }

    /**
     *
     * @return string
     */
    public function getIsWatching()
    {
        return $this->isWatching;
    }

    public function getObjectMappings()
    {
        return array(
            'self' => array(
                '_type' => 'string'
            ),
            'watchCount' => array(
                '_type' => 'integer'
            ),
            'isWatching' => array(
                '_type' => 'boolean'
            )
        );
    }

}
