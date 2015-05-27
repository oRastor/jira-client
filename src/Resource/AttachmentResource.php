<?php

namespace JiraClient\Resource;

/**
 * Description of AttachmentResource
 *
 * @author rastor
 */
class AttachmentResource extends AbstractResource
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
    protected $id;

    /**
     *
     * @var string
     */
    protected $filename;

    /**
     *
     * @var UserResource
     */
    protected $author;

    /**
     *
     * @var \DateTime
     */
    protected $created;

    /**
     *
     * @var int
     */
    protected $size;

    /**
     *
     * @var string
     */
    protected $mimeType;

    /**
     *
     * @var string
     */
    protected $content;

    /**
     *
     * @var string
     */
    protected $thumbnail;

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
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     *
     * @var UserResource
     */
    public function getAuthor()
    {
        return $this->getAuthor();
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
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
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
            'filename' => array(
                '_type' => 'string'
            ),
            'author' => array(
                '_type' => 'user'
            ),
            'created' => array(
                '_type' => 'string'
            ),
            'size' => array(
                '_type' => 'integer'
            ),
            'mimeType' => array(
                '_type' => 'string'
            ),
            'content' => array(
                '_type' => 'string'
            ),
            'thumbnail' => array(
                '_type' => 'string'
            )
        );
    }

}
