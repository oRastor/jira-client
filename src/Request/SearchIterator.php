<?php

namespace JiraClient\Request;

use JiraClient\JiraClient;

/**
 * Description of SearchIterator
 *
 * @author pbrasseur
 */
class SearchIterator implements \Iterator {

    private $total = 0;
    private $position = 0;
    private $client;
    private $jql;
    private $includedFields = null;
    private $expandFields = false;
    private $fetchSize = 0;
    private $fetchedFrom = null;
    private $fetchedData;

    public function __construct(JiraClient $client, $jql, $includedFields = null, $expandFields = false, $fetchSize = 100) {
        $this->client = $client;
        $this->jql = $jql;
        $this->includedFields = $includedFields;
        $this->expandFields = $expandFields;
        $this->fetchSize = $fetchSize;
        $this->fetchData();
    }

    public function current() {
        $data = $this->fetchedData[$this->position % $this->fetchSize];

        return new Issue($this->client, $data);
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function rewind() {
        $this->position = 0;
        $this->fetchedFrom = null;
    }

    public function valid() {
        if ($this->position > $this->total) {
            return false;
        }

        if ($this->fetchedFrom === null || ($this->position >= $this->fetchedFrom + $this->fetchSize)) {
            $this->fetchData();
        }

        return isset($this->fetchedData[$this->position % $this->fetchSize]);
    }

    private function makeRequest() {
        $params = array(
            'jql' => $this->jql,
            'maxResults' => $this->fetchSize,
            'startAt' => $this->position
        );

        if ($this->includedFields !== null) {
            $params['fields'] = $this->includedFields;
        }

        if ($this->expandFields) {
            $params['expand'] = '';
        }

        $path = "/search?" . http_build_query($params);

        return $this->client->callGet($path)->getData();
    }

    private function fetchData() {
        $result = $this->makeRequest();

        $this->fetchedData = $result['issues'];
        $this->fetchedFrom = $this->position;
        $this->total = $result['total'];
    }

    public function getTotal() { 
        return $this->total;
    }

}
