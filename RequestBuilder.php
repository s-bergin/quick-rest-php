<?php 
namespace QuickRest;

class RequestBuilder{

    public $test; 

    /**
     * @var Array $params
     */
    private $params = [];

    /**
     * @var Array $query
     */ 
    private $query;

    public function __construct(){

    }

    /**
     * @param String $key
     * @param Value $value
     */
    public function addToParams($key, $value){
        $this->params[$key] = $value;
    }

    /**
     * @return Array
     */
    public function getParams(){
        return $this->params;
    }

    /**
     * build() , build our params and query vars
     * 
     * @param Route $route
     */
    public function build(Route $route){
        $this->buildParams($route);
    }

    /**
     * buildParams()
     * 
     * @param Route $route
     */
    public function buildParams(Route $route){
        $requestedUri = $_SERVER["PATH_INFO"];
        $requestUriArray = explode("/", trim($requestedUri, "/"));

        $routeUri = $route->getUri();
        $routeUriArray = explode("/", trim($routeUri, "/"));

        $tmpParamsObj = [];

        // if data exists in uri past base uri, take each index from the route uri and match it to value in request uri
        if(count($routeUriArray) > 1){     
            for($i = 1; $i <= count($routeUriArray); $i++){

            }
        }

        $this->params = $tmpParamsObj;
    }

    public function buildQuery(){

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
        return $_SERVER['PATH_INFO'];
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