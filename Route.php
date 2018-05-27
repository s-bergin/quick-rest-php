<?php
namespace QuickRest;

class Route{

    /**
     * @var String $uri
     */
    private $uri; 

    /**
     * @var Function $callback
     */
    private $callback; 

    /**
     * @param String $uri
     */
    public function __construct($uri, $callback){
        $this->uri = $uri; 
        $this->callback = $callback; 
    }

    /**
     * @return String 
     */
    public function getUri(){
        return $this->uri; 
    }

    /**
     * @return Function 
     */
    public function getCallback(){
        return $this->callback; 
    }
}
?>