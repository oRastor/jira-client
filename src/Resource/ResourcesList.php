<?php

namespace JiraClient\Resource;

/**
 * Description of ResourcesList
 *
 * @author rastor
 */
class ResourcesList
{

    /**
     *
     * @var int
     */
    protected $start;

    /**
     *
     * @var int
     */
    protected $max;

    /**
     *
     * @var int
     */
    protected $total;

    /**
     *
     * @var array
     */
    protected $list = array();

    public function __construct($start, $max, $total, $list = array())
    {
        $this->start = $start;
        $this->max = $max;
        $this->total = $total;
        $this->list = $list;
    }

    /**
     * 
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * 
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * 
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * 
     * @return array
     */
    public function getList()
    {
        return $this->list;
    }

}
