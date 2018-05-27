<?php 
namespace QuickRest;

class RequestBuilder{

    public function __construct(){

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

        if(count($routeUriArray) > 1){     
            for($i = 1; $i <= count($routeUriArray); $i++){
                
            }
        }
    }

    public function buildQuery(){

    }
}
?>