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
            $rUri = $r->getUri();
            $routeUriElements = explode("/", trim($rUri, "/"));

            // check does the routeUriElements match the requestUriElements
            if($routeUriElements[0] == $requestUriElements[0] && 
                count($routeUriElements) == count($requestUriElements)){

                    if(count($routeUriElements) > 1){
                        for($i = 1; $i <= count($routeUriElements); $i++){
                            $tmpRouteUri = $routeUriElements[$i];
                            echo $tmpRouteUri[0];

                            
                        }
                    }else{
                        
                        $route = $r; 
                        break;
                    }
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

    /**
     * 
     * TODO - CLEAN UP THIS CODE AND MIGRATE FUNCTIONALITY TO REQUEST BUILDER 
     * 
     * ensure that the uri a user requests is a valid route 
     * 
     * @param RequestBuilder $requestBuilder
     * 
     * @return Route 
     */
    public function validateRequestedRoute(RequestBuilder $requestBuilder){
        $requestMethod = $requestBuilder->getRequestMethod();
        $routesPerRequestMethod = $this->getRoutesByRequestMethod($requestMethod);

        $uri = $requestBuilder->getRequestUri();
        $requestUriElements = $requestBuilder->getRequestedUriElements($uri);

        $route = NULL;

        // iterate through our routesPerRequestMethod and see if there is a matching uri 
        foreach($routesPerRequestMethod as $r){
            
            // get the uri elements for each $r
            $routeUri = $r->getUri();
            $routeUriElements = $requestBuilder->getRequestedUriElements($routeUri);

            // check does the routeUriElements match the requestUriElements
            if($routeUriElements[0] == $requestUriElements[0] && count($routeUriElements) == count($requestUriElements)){
                    
                // if the user passes some additional uri request params 
                if(count($requestUriElements) > 1){

                    for($i = 1; $i < count($routeUriElements); $i++){
                        $tmpRouteUri = $routeUriElements[$i];
                        $tmpRequestUri = $requestUriElements[$i];
                        
                        // check if it is deliminated value 
                        if($tmpRouteUri[0] == "{" && $tmpRouteUri[-1] == "}"){
                            // get the param key(name)
                            $paramKey = substr($tmpRouteUri, 1, -1);
                            
                            $requestBuilder->addToParams($paramKey, $tmpRequestUri);
                        }else{
                            if($tmpRouteUri !== $tmpRequestUri){
                                // TODO - Throw route not implemented error here instead 
                                break; 
                            }
                        }
                    }
                }

                $route = $r; 
                break; // break we have the matching  route 
            }else{
                // TODO - Throw route not implemented error here instead
            }
        }

        return $route;
    }

    /**
     * @param String $requestMethod
     * @return Array[Routes] 
     */
    private function getRoutesByRequestMethod($requestMethod){
        return $this->routes[$requestMethod];
    }
}
?>