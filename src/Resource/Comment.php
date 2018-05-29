<?php

namespace JiraClient\Resource;

/**
 * Description of Comment
 *
 * @author pbrasseur
 */
class Comment extends AbstractResource
{

    /**
     *
     * @var \JiraClient\Resource\AuthorResource
     */
    protected $author;

    /**
     *
     * @var string
     */
    protected $body;

    /**
     *
     * @var \DateTime
     */
    protected $created;

    /**
     *
     * @var string
     */
    protected $id;

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
     * @var string
     */
    protected $self;

    /**
     *
     * @return \JiraClient\Resource\AuthorResource
     *
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     *
     * @return string
     *
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     *
     * @return \DateTime
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
     * @return \JiraClient\Resource\AuthorResource
     */
    public function getUpdateAuthor()
    {
        return $this->updateAuthor;
    }

    /**
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     *
     * @return string
     */
    public function getSelf()
    {
        return $this->self;
    }

    public function getObjectMappings()
    {
        return array(
            'self' => array(
                '_type' => 'string'
            ),
            'id' => array(
                '_type' => 'integer'
            ),
            'author' => array(
                '_type' => 'user'
            ),
            'body' => array(
                '_type' => 'string'
            ),
            'updateAuthor' => array(
                '_type' => 'user'
            ),
            'created' => array(
                '_type' => 'date'
            ),
            'updated' => array(
                '_type' => 'date'
            )
        );
    }

    public function getSaveData()
    {
        $data = array(
            'body' => $this->body
        );

        if (isset($this->visibility)) {
            $data['visibility'] = $this->getVisibility()->getSaveData();
        }

        return $data;
    }

}
