<?php
require_once(__DIR__ . "\\..\\connect.php");

class ModelStazioni {
  static function get_all() {
    require("../connect.php");
    $query = "SELECT * FROM Stazioni";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
  }
}
