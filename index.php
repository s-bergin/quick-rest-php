<?php 

require("App.php");

$app = new QuickRest\App();

$app->get("/home", function($request){
   
});

$app->run();
?>