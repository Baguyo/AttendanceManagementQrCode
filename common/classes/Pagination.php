<?php 

    class Pagination{

        public $page;
        public $per_page_item;
        public $all_items_count;

        public function __construct($page=1, $per_page_item=2, $all_items_count=0 )
        {
            $this->page = (int)$page;
            $this->per_page_item = (int)$per_page_item;
            $this->all_items_count = (int)$all_items_count;
        }

        public function next(){
            return $this->page + 1;
        }

        public function previous(){
            return $this->page - 1;
        }

        public function page_total(){
            return ceil($this->all_items_count / $this->per_page_item);
        }
        
        public function has_previous(){
            return $this->previous() >= 1 ? true : false;
        }
        
        public function has_next(){
            return $this->next() <= $this->page_total() ? true : false;
        }

        public function offset(){
            return ($this->page - 1) * $this->per_page_item;
        }


    }//END OF PAGINATINO CLASS


?>