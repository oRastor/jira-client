<?php

namespace JiraClient\Resource;

use JiraClient\JiraClient;

/**
 * Description of SearchIterator
 *
 * @author rastor
 */
class SearchIterator implements \Iterator
{

    private $total = 0;
    private $position = 0;
    private $client;
    private $jql;
    private $includedFields = null;
    private $expandFields = false;
    private $fetchSize = 0;
    private $fetchedFrom = null;
    private $fetchedData;

    public function __construct(JiraClient $client, $jql, $includedFields = null, $expandFields = false, $fetchSize = 100)
    {
        $this->client = $client;
        $this->jql = $jql;
        $this->includedFields = $includedFields;
        $this->expandFields = $expandFields;
        $this->fetchSize = $fetchSize;
    }

    public function current()
    {
        return $this->fetchedData[$this->position % $this->fetchSize];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function rewind()
    {
        $this->position = 0;
        $this->fetchedFrom = null;
    }

    public function valid()
    {
        if ($this->position > $this->total) {
            return false;
        }

        if ($this->fetchedFrom === null || ($this->position >= $this->fetchedFrom + $this->fetchSize)) {
            $this->fetchData();
        }

        return isset($this->fetchedData[$this->position % $this->fetchSize]);
    }

    private function fetchData()
    {
        $resultList = $this->client->issue()->search($this->jql, $this->includedFields, $this->expandFields, $this->fetchSize, $this->position);
        $this->fetchedData = $resultList->getList();
        $this->fetchedFrom = $this->position;
        $this->total = $resultList->getTotal();
    }

    public function total()
    {
        return $this->total;
    }

}
