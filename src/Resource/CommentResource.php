<?php

namespace JiraClient\Resource;

/**
 * Description of CommentResource
 *
 * @author rastor
 */
class CommentResource extends AbstractResource
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
     * @var \JiraClient\Resource\VisibilityResource
     */
    protected $visibility;

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

    /**
     * 
     * @return \JiraClient\Resource\VisibilityResource
     */
    public function getVisibility()
    {   
        return $this->visibility;
    }

    /**
     *
     * @param string $body
     *
     * @return CommentResource
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * 
     * @param \JiraClient\Resource\VisibilityResource $visibility
     * @return \JiraClient\Resource\CommentResource
     */
    public function setVisibility($visibility)
    {        
        $this->visibility = $visibility;
        
        return $this;
    }

    public function getObjectMappings()
    {
        return array(
            'author' => array(
                'result' => 'object',
                'className' => '\JiraClient\Resource\AuthorResource'
            ),
            'updateAuthor' => array(
                'result' => 'object',
                'className' => '\JiraClient\Resource\AuthorResource'
            ),
            'created' => array(
                'result' => 'object',
                'className' => '\DateTime'
            ),
            'updated' => array(
                'result' => 'object',
                'className' => '\DateTime'
            ),
            'visibility' => array(
                'result' => 'object',
                'className' => '\JiraClient\Resource\VisibilityResource'
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
