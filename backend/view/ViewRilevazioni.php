<?php
require_once("../model/ModelRilevazioni.php");

class ViewRilevazioni {
  static function get_all() {
    $data = ModelRilevazioni::get_all();
    $json = json_encode($data);
    return $json;
  }

  static function get_by_city($provincia) {
    $data = ModelRilevazioni::get_by_city($provincia);
    $json = json_encode($data);
    return $json;
  }
}
