 <?php
  error_reporting(-1);

  include('./flight/Flight.php');
  include('./scripts/db.php');

  Flight::set('flight.views.path', 'views');

  //$body = Flight::request()->getBody();
  $query = Flight::request()->query;
  $body = Flight::request()->data;



  Flight::route('POST /user/@name/@id', function($name, $id) {
    global $body, $jsonBody;

    print_r($jsonBody->good);
    echo "hello, $name ($id)!";
  });

  Flight::route('GET|POST /debug', function($route) {

    global $body, $query;
    Flight::json(array('methods'=>$route->methods, 'params' => $route->params,'body' => $body, 'query' => $query));
    // Array of HTTP methods matched against
    $route->methods;

    // Array of named parameters
    $route->params;

    // Matching regular expression
    $route->regex;

    // Contains the contents of any '*' used in the URL pattern
    $route->splat;
  }, true);

  Flight::before('start', function(&$params, &$output){
      // Do something
  });

  Flight::after('start', function(&$params, &$output){
      // Do something
  });

  Flight::route('GET /categories', function() {
    global $body, $jsonBody;
    $labs = array(array("name"=>"Cool Lab", "color"=>"#09f"), array("name"=>"Cool Lab", "color"=>"#09f"), array("name"=>"Cool Lab", "color"=>"#09f"), array("name"=>"Cool Lab", "color"=>"#09f"));
    echo(json_encode($labs));
  });

  Flight::route('GET /*',function() {
    global $stylesArray, $scriptsArray;
    Flight::render('home', array(
      'stylesArray' => $stylesArray,
      'scriptsArray' => $scriptsArray)
    );
  });
  Flight::start();
?>