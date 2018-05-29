<?php
namespace QuickRest;

include("Route.php");
include("RouteNotImplementedException.php");

class Router{

    /**
     * Our routes store 
     * @var Array $routes
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
     * ensure that the uri a user requests is a valid route 
     * 
     * @param RequestBuilder $requestBuilder
     * 
     * @throws RouteNotImplementedException 
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
            $uriElementsMatch = $this->checkRouteUriMatchesRequestUri($routeUriElements, $requestUriElements);
            if($uriElementsMatch){
                    
                // if the user passes some additional uri request params 
                $requestUriContainsParameters = $this->checkRequestUriContainsParameters($requestUriElements);
                if($requestUriContainsParameters){

                    for($i = 1; $i < count($routeUriElements); $i++){
                        $tmpRouteUriElement = $routeUriElements[$i];
                        $tmpRequestUriElement = $requestUriElements[$i];
                        
                        // check if uri element is a parameter
                        $routeUriElementIsParameter = $this->checkIfUriElementIsParameter($tmpRouteUriElement);
                        
                        if($routeUriElementIsParameter){
                            // get the param key(name)
                            $paramKey = $this->getParameterKeyFromUriElement($tmpRouteUriElement);
                            
                            $requestBuilder->addToParam($paramKey, $tmpRequestUriElement);
                        }else{
                            if($tmpRouteUriElement !== $tmpRequestUriElement){ 
                                throw new RouteNotImplementedException();
                            }
                        }
                    }
                }

                $route = $r; 
                break; // break we have the matching  route 
            }else{
                throw new RouteNotImplementedException();
            }
        }

        // ensure exception if route doesnt exist 
        if(!$route){
            throw new RouteNotImplementedException();
        }

        return $route;
    }

    /**
     * @param Array[String] $routeUriElements
     * @param Array[String] $requestUriElements
     * 
     * @return BOOL
     */
    private function checkRouteUriMatchesRequestUri($routeUriElements, $requestUriElements){
        if($routeUriElements[0] == $requestUriElements[0] && 
            count($routeUriElements) == count($requestUriElements)){
                return TRUE;
        }
        
        return FALSE;
    }

    /**
     * @param Array $requestUriElements
     * 
     * @return BOOL
     */
    private function checkRequestUriContainsParameters($requestUriElements){
        if(count($requestUriElements) > 1){
            return TRUE;
        }

        return FALSE;
    }

    /**
     * check if a uri element is a parameter, parameters are determined by being 
     * enclosed by '{}'
     * 
     * @param String $uriElement
     * 
     * @return Bool
     */
    private function checkIfUriElementIsParameter($uriElement){
        if($uriElement[0] == "{" && $uriElement[-1] == "}"){
            return TRUE;
        }

        return FALSE;
    }

    /**
     * get the paramater key(name) from a uri element
     * 
     * @param String $uriElement
     * 
     * @return String 
     */
    private function getParameterKeyFromUriElement($uriElement){
        // parameters will be enclosed by {}
        return substr($uriElement, 1, -1);
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