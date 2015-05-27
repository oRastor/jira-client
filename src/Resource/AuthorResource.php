<?php

namespace JiraClient\Resource;

/**
 * Description of AuthorResource
 *
 * @author rastor
 */
class AuthorResource extends AbstractResource
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
    public function getCreated()
    {
        return $this->created;
    }

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
    public function getRoleLevel()
    {
        return $this->roleLevel;
    }

    /**
     *
     * @return string
     */
    public function getUpdateAuthor()
    {
        return $this->updateAuthor;
    }

    /**
     *
     * @return string
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    public function getObjectMappings()
    {
        return array(
            'avatarUrls' => array(
                'result' => 'assoc'
            )
        );
    }

}
