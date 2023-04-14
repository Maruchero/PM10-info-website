<?php
require_once("../view/ViewStazioni.php");

if (!isset($_GET["mode"])) die("Invalid access!");

switch ($_GET["mode"]) {
  case 'get_all':
    echo ViewStazioni::get_all();
    break;
}
