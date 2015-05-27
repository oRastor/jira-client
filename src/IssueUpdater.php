<?php

namespace JiraClient;

/**
 * Description of IssueUpdater
 *
 * @author rastor
 */
class IssueUpdater
{

    private $tasks = array();

    public function addFieldTask($fieldName, $operation, $data)
    {
        $this->tasks[$fieldName][] = array(
            $operation => $data
        );

        return $this;
    }

    public function clear($fieldName)
    {
        unset($this->tasks[$fieldName]);
    }

    public function clearAll()
    {
        $this->tasks = array();
    }

    public function getSaveData()
    {
        return array(
            'update' => $this->tasks
        );
    }

}
