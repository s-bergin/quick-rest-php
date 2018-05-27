<?php 
/**
 * Quick Rest PHP Framework 
 * 
 * @link
 * @copyright
 */

namespace QuickRest; 

include("Router.php");

class App{

    /**
     * @var Router $router 
     */
    private $router; 

    public function __construct(){
        $this->router = new Router(); 
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
     * 
     */
    public function run(){
        $route = $this->router->get();

        $route["CALLBACK"]();
    }
}
?>