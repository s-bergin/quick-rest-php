<?php
namespace QuickRest;

class Request{

    /**
     * @var Array $param
     */
    public $param;

    /**
     * @var Array $query 
     */
    public $query; 

    /**
     * @param Array $param
     * @param Array $query 
     */
    public function __construct($param, $query){
        $this->param = $param; 
        $this->query = $query; 
    }
}
?>