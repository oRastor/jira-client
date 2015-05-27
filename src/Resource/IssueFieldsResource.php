<?php

namespace JiraClient\Resource;

/**
 * Description of IssueFieldsResource
 *
 * @author rastor
 */
class IssueFieldsResource extends AbstractResource
{

    /**
     *
     * @var \JiraClient\Resource\AuthorResource
     */
    protected $reporter;
    
    /**
     *
     * @var string
     */
    protected $description;
    
    /**
     * 
     * @return \JiraClient\Resource\AuthorResource
     */
    public function getReporter() {
        return $this->reporter;
    }
    
    /**
     * 
     * @return string
     */
    public function getDescription() {
        return $this->string;
    }
    
    public function getObjectMappings()
    {
        return array(
            'reporter' => array(
                'result' => 'object',
                'className' => '\JiraClient\Resource\AuthorResource'
            )
        );
    }

}
