<?php

/**
 * Created by PhpStorm.
 * User: petar
 * Date: 27.3.2017
 * Time: 14:55
 */
class pagination
{
    public $currentPage;
    public $perPage;
    public $count;

    public function __construct($page = 1, $totalCount, $perPage = 10)
    {
        $this->currentPage = (int)$page;
        $this->perPage = (int)$perPage;
        $this->count = (int)$totalCount;
    }

    public function totalPages(){
        return ceil($this->count / $this->perPage);
    }

    public function offset() {
        return ($this->currentPage - 1) * $this->perPage;
    }
    public function previousPage() {
        return $this->currentPage - 1;
    }
    public function nextPage() {
        return $this->currentPage + 1;
    }

    public function hasPreviousPage() {
        return($this->previousPage() < 1 ) ? false : true;
    }


    public function hasNextPage() {
        return($this->nextPage() > (int)$this->totalPages() ) ? false : true;
    }
}