<?php 

require("App.php");

$app = new QuickRest\App();

$app->get("/home/{ID}", function($request, $response){
    
});

$app->post("/home", function($request, $response){
    
});

$app->put("/home", function($request, $response){
    
});

$app->delete('/home', function($request, $response){
    
});

$app->run();
?>