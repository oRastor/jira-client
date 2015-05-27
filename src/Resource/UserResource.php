<?php

namespace JiraClient\Resource;

/**
 * Description of UserResource
 *
 * @author rastor
 */
class UserResource extends AbstractResource
{

    /**
     *
     * @var string
     */
    protected $self;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $emailAddress;

    /**
     *
     * @var array
     */
    protected $avatarUrls;

    /**
     *
     * @var string
     */
    protected $displayName;

    /**
     *
     * @var string
     */
    protected $active;

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
     * @return string
     *
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @return string
     *
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     *
     * @return array
     */
    public function getAvatarsUrls()
    {
        return $this->avatarUrls;
    }

    /**
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     *
     * @return boolean
     *
     */
    public function getActive()
    {
        return $this->active;
    }

    public function getObjectMappings()
    {
        return array(
            'self' => array(
                '_type' => 'string'
            ),
            'name' => array(
                '_type' => 'string'
            ),
            'emailAddress' => array(
                '_type' => 'string'
            ),
            'avatarUrls' => array(
                '_type' => 'assoc'
            ),
            'displayName' => array(
                '_type' => 'string'
            ),
            'active' => array(
                '_type' => 'boolean'
            )
        );
    }

}
