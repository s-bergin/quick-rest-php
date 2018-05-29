<?php 
namespace QuickRest;

class RouteNotImplementedException extends \Exception{
    public function __construct($message = "Requested route does not exist.", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
?>