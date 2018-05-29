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
include("Response.php");

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
        
        $route = $this->router->validateRequestedRoute($this->requestBuilder);
        
        // serve request object
        $this->requestBuilder->setQuery();
        $requestParams = $this->requestBuilder->getParam();
        $requestQuery = $this->requestBuilder->getQuery();
        $this->request = new Request($requestParams, $requestQuery);

        // server response object 
        $requestMethod = $this->requestBuilder->getRequestMethod();
        $this->response = new Response($requestMethod);

        $callback = $route->getCallback();
        $callback($this->request, $this->response);
    }
}
?>