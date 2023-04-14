<?php
require_once("../view/ViewRilevazioni.php");

if (!isset($_GET["mode"])) die("Invalid access!");

switch ($_GET["mode"]) {
  case 'get_all':
    echo ViewRilevazioni::get_all();
    break;
}
