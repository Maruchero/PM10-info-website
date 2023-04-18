<?php
require_once("../connect.php");

class ModelRilevazioni {
  static function get_all() {
    global $conn;
    $query = "SELECT * FROM Rilevazioni";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
  }

  static function get_by_city() {
    global $conn;
    $provincia = $_GET["city"];
    $query = "SELECT codseqst FROM Stazioni WHERE provincia='$provincia'";
    $result = mysqli_query($conn, $query);
    $codseqst_array = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $codseqst = $row['codseqst'];
        array_push($codseqst_array, $codseqst);
    }

    $query = "SELECT * FROM Rilevazioni WHERE codseqst IN ('" . implode("','", $codseqst_array) . "')";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
  }
}
