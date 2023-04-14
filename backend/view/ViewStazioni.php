<?php
require_once("../model/ModelStazioni.php");

class ViewStazioni {
  static function get_all() {
    $data = ModelStazioni::get_all();
    $json = json_encode($data);
    return $json;
  }
}