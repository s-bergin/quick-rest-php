<?php 
namespace QuickRest;

class RequestBuilder{

    /**
     * @var Array $param
     */
    private $param = [];

    /**
     * @var Array $query
     */ 
    private $query = NULL;

    public function __construct(){

    }

    /**
     * @param String $key
     * @param Value $value
     */
    public function addToParam($key, $value){
        $this->param[$key] = $value;
    }

    /**
     * @return Array
     */
    public function getParam(){
        return $this->param;
    }

    /**
     * @param Array $query 
     */
    public function setQuery($query = NULL){
        if(!$query){
            $query = $_SERVER['QUERY_STRING'];

            if($query !== ""){
                $query = $this->getQueryStringAsArray($query);
            }
        }
        
        if($query){
            $this->query = $query;
        }
    }

    /**
     * @return Array
     */
    public function getQuery(){
        return $this->query; 
    }

    /**
     * @param String $queryString
     * 
     * @return Array
     */
    private function getQueryStringAsArray($queryString){
        $query = explode("&", trim($queryString, "&"));
        
        $queryArray = []; 
        foreach($query as $q){
            $tmpArray = explode("=", trim($q, "="));
            $queryArray[$tmpArray[0]] = $tmpArray[1];
        }

        return $queryArray; 
    }

    /**
     * @return String 
     */
    public function getRequestMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return String
     */
    public function getRequestUri(){
        return $_SERVER["PATH_INFO"];
    }

    /**
     * get the request uri elements, this is the uri exploded to array with '/' differing index
     * @return Array
     */
    public function getRequestedUriElements($uri){
        return explode("/", trim($uri, "/"));
    }
}
?>