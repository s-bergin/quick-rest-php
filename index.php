<?php 

require("App.php");

$app = new QuickRest\App();

$app->get("/home/{ID}", function($request, $response){

});

$app->run();
?>