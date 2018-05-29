# quick-rest-php
A lightweight rest framework for php. 

## Usage
create an index.php with the following contents

```php
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
```

## Learn More

Learn more at these links:
- [Documentation](https://github.com/s-bergin/quick-rest-php/wiki/API)



## Credits

- [Shane Bergin](https://github.com/s-bergin)

## License

Quick Rest PHP is licensed under the MIT license. See [License File](LICENSE.md) for more information.
