<?php
namespace QuickRest;

class Request{

    /**
     * @var Array $params
     */
    public $params;

    /**
     * @var Array $query 
     */
    public $query; 

    /**
     * @param Array $params
     * @param Array $query 
     */
    public function __construct($params, $query){
        $this->params = $params; 
        $this->query = $query; 
    }
}
?>