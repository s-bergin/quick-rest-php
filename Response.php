<?php 
namespace QuickRest;

class Response{

    /**
     * HTTP response status codes 
     * @var Array $statusCodes
     */
    private $statusCodes = [
        "GET" => 200, 
        "POST" => 201, 
        "PUT" => 200,
        "DELETE" => 200
    ];

    /**
     * @var String $requestMethod
     */
    private $requestMethod; 

    /**
     * HTTP Response status
     * @var INT $statusCode
     */
    private $statusCode;

    public function __construct($requestMethod){
        $this->requestMethod = $requestMethod; 
    }

    /**
     * Allow the user to set the HTTP response status 
     * 
     * @param INT $statusCode
     * 
     * @return Response $this 
     */
    public function statusCode($statusCode){
        $this->statusCode = $statusCode;

        // allow for fluent interface
        return $this;
    } 

    /**
     * Allow the user to return a json 
     * 
     * @param $data
     */
    public function json($data){
        $data = json_encode($data);

        $statusCode = $this->statusCode ? $this->statusCode : $this->statusCodes[$this->requestMethod];

        $this->sendReponse($statusCode, $data);
    }

    /**
     * @param INT $statusCode
     * @param String $data
     */
    private function sendReponse($statusCode, $data){
        http_response_code($statusCode);
        echo $data;
    }
}
?>