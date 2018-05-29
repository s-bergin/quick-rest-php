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
     * @var Array $body
     */
    public $body; 

    /**
     * @param Array $param
     * @param Array $query 
     */
    public function __construct($param, $query, $body){
        $this->param = $param; 
        $this->query = $query; 
        $this->body = $body; 
    }
}
?>