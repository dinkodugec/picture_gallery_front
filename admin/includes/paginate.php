<?php

class Paginate
{
    public $current_page;
    public $items_per_page;
    public $items_total_count;


    public function __construct($current_page=1, $items_per_page=4, $items_total_count=0)
    {
            $this->page = (int)$current_page;
            $this->items_per_page = (int)$items_per_page;
            $this->items_total_count = (int)$items_total_count;
    }

    
    public function next()
    {
      return $this->current_page +1;
    }

   
    public function previous()
    {
      return $this->current_page -1;
    }


    public function page_total()
    {
      return ceil($this->items_total_count/$this->items_per_page);
    }
}