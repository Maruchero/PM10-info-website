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

  static function get_city() {
    global $conn;
    $query = "SELECT DISTINCT S.nome
              FROM Stazioni AS S, Rilevazioni AS R
              WHERE S.codseqst=R.codseqst";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
  }

  static function get_by_city($comune) {
    global $conn;
    $query = "SELECT R.codseqst, R.data, R.tipoInquinante, R.valore
              FROM Stazioni AS S, Rilevazioni AS R
              WHERE S.codseqst=R.codseqst AND S.nome='$comune'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
  }
}
