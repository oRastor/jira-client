<?php

namespace JiraClient\Resource;

use JiraClient\Resource\Issue,
    JiraClient\Exception\JiraException;

/**
 * Description of FluentIssueTransition
 * 
 * @todo Add posibility to update fields
 *
 * @author rastor
 */
class FluentIssueTransition
{

    /**
     *
     * @var Issue
     */
    private $issue;

    public function __construct(Issue $issue)
    {
        $this->issue = $issue;
    }

    public function execute($transitionId, $includedFields = null)
    {
        $client = $this->issue->getClient();

        $transitions = $client->issue()->getTransitions($this->issue->getKey(), $transitionId);

        if (!count($transitions)) {
            throw new JiraException("Bad transition id");
        }

        $data['transition'] = array('id' => $transitionId);

        try {
            $this->issue->getClient()->callPost('/issue/' . $this->issue->getKey() . '/transitions', $data)->getData();
        } catch (Exception $e) {
            throw new JiraException("Failed to update issue", $e);
        }

        return $this->issue->getClient()
                        ->issue()
                        ->get($this->issue->getKey(), $includedFields);
    }

    public function field($name, $value)
    {
        $this->fields[$name] = $value;

        return $this;
    }

}
