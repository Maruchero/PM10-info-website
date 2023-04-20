<?php
require_once("../view/ViewRilevazioni.php");

if (!isset($_GET["mode"])) die("Missing parameter 'mode'");

switch ($_GET["mode"]) {
  case 'get_all':
    echo ViewRilevazioni::get_all();
    break;

    case 'get_city':
      echo ViewRilevazioni::get_city();
      break;
  
  case 'get_by_city':
    if (!isset($_GET["city"])) die("Missing parameter 'city'");
    $comune = $_GET["city"];
    echo ViewRilevazioni::get_by_city($comune);
    break;
}
