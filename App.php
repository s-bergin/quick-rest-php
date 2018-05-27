<?php 
/**
 * Quick Rest PHP Framework 
 * 
 * @link
 * @copyright
 */

namespace QuickRest; 

include("Router.php");
include("Request.php");
include("RequestBuilder.php");

class App{

    /**
     * @var Router $router 
     */
    private $router; 

    /**
     * @var Request $request
     */
    private $request;

    /**
     * @var RequestBuilder $requestBuilder
     */
    private $requestBuilder;

    /**
     * @var Response $response
     */
    private $response;
 
    public function __construct(){
        $this->router = new Router(); 
        $this->requestBuilder = new RequestBuilder();
    }

    /****************
     * Routing functionality 
     ****************/

    /**
     * GET 
     * 
     * @param String $uri - The URI pattern for initialised route
     * @param Function $callback - Functionality for specified route  
     */
    public function get($uri, $callback){
        $this->map(['GET'], $uri, $callback);
    }

    /**
     * MAP
     * 
     * map the initialised route to our router
     * 
     * @param Array $requestMethods
     * @param String $uri
     * @param Function $callback 
     */
    private function map($requestMethods, $uri, $callback){
        $this->router->add($requestMethods, $uri, $callback);
    }

    /*********
     * Run 
     *********/
    /**
     * run()
     * 
     * Handle the HTTP request
     * 
     */
    public function run(){
        $route = $this->router->get();

        $this->requestBuilder->build($route);

        $request = "";
        
        $callback = $route->getCallback();
        $callback($request);
    }
}
?>