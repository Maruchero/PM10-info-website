<?php
require_once("../model/ModelRilevazioni.php");

class ViewRilevazioni {
  static function get_all() {
    $data = ModelRilevazioni::get_all();
    $json = json_encode($data);
    return $json;
  }

  static function get_by_city() {
    $data = ModelRilevazioni::get_by_city();
    $json = json_encode($data);
    return $json;
  }
}
