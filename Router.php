<?php
namespace QuickRest;

include("Route.php");

class Router{

    /**
     * Our routes store 
     * @var array $routes
     */
    private $routes = [
        "GET"=>[], 
        "POST"=>[],
        "PUT"=>[],
        "DELETE"=>[]
    ]; 

    public function __construct(){

    }

    /**
     * add()
     * 
     * add a route to our routes store 
     * 
     * @param Array $requestMethods
     * @param String $uri 
     * @param Function $callback
     */
    public function add($requestMethods, $uri, $callback){
        
        // iterate through the provided request methods and add the uri and callback to router 
        foreach($requestMethods as $r){
            $route = new Route($uri, $callback);

            $this->routes[$r][] = $route; 
        }
    }

    /**
     * search()
     * 
     * search our routes to check if requested route exists 
     * 
     * @param String $requestMethod
     * @param String $uri
     * 
     * @return Route 
     */
    private function search($requestMethod, $uri){
        $routesPerRequestMethod = $this->routes[$requestMethod];

        // get our request uri elements, these will be used to check does requested uri exist
        $requestUriElements = explode("/", $uri);

        $route = NULL; 

        // iterate through our routesPerRequestMethod and see if there is a matching uri 
        foreach($routesPerRequestMethod as $r){
            
            // get the uri elements for each $r
            $routeUriElements = explode("/", $r->getUri());

            // check does the routeUriElements match the requestUriElements
            if($routeUriElements[1] == $requestUriElements[1] && 
                count($routeUriElements) == count($requestUriElements)){
                
                    $route = $r; 
                    break;
            }
        }

        return $route; 
    }


    /**
     * get()
     * 
     * get a route from our routes store 
     * 
     */
    public function get(){
        
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['PATH_INFO'];

        return $this->search($requestMethod, $uri);
    }
}
?>