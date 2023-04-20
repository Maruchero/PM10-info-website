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
    $query1 = "SELECT DISTINCT S.nome
              FROM Stazioni AS S, Rilevazioni AS R
              WHERE S.codseqst=R.codseqst AND tipoInquinante='PM10'";
    $result1 = mysqli_query($conn, $query1);
    $data1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);

    $query2 = "SELECT DISTINCT CONCAT(S.nome, ' PM2,5') AS nome
              FROM Stazioni AS S, Rilevazioni AS R
              WHERE S.codseqst=R.codseqst AND tipoInquinante='PM2,5'";
    $result2 = mysqli_query($conn, $query2);
    $data2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);


    $data = array_merge($data1, $data2);
    $data = array_unique($data, SORT_REGULAR);


    return $data;
  }

  static function get_by_city($comune) {
    global $conn;
    if (strpos($comune, 'PM2,5') !== false) {
      $query = "SELECT R.codseqst, R.data, R.tipoInquinante, R.valore
              FROM Stazioni AS S, Rilevazioni AS R
              WHERE S.codseqst=R.codseqst and R.tipoInquinante='PM2,5' AND S.nome='$comune'";
    } else {
      $query = "SELECT R.codseqst, R.data, R.tipoInquinante, R.valore
              FROM Stazioni AS S, Rilevazioni AS R
              WHERE S.codseqst=R.codseqst and R.tipoInquinante='PM10' AND S.nome='$comune'";
    }
    
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
  }

  static function get_higher_avg() {
    global $conn;
    $query1 = "SELECT S.nome, COUNT(*) AS count
              FROM Rilevazioni R,stazioni S
              WHERE R.codseqst = S.codseqst AND R.tipoInquinante='PM10' AND R.valore > (
                  SELECT AVG(R2.valore)
                  FROM Rilevazioni as R2
                  WHERE R.tipoInquinante='PM10'
              )
              GROUP BY S.nome";
    $result1 = mysqli_query($conn, $query1);
    $data1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);

    $query2 = "SELECT CONCAT(S.nome, ' PM2,5') AS nome, COUNT(*) AS count
              FROM Rilevazioni R,stazioni S
              WHERE R.codseqst = S.codseqst AND R.tipoInquinante='PM2,5' AND R.valore > (
                  SELECT AVG(R2.valore)
                  FROM Rilevazioni as R2
                  WHERE R.tipoInquinante='PM2,5'
              )
              GROUP BY S.nome";
    $result2 = mysqli_query($conn, $query2);
    $data2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);

    $data = array_merge($data1, $data2);
    $data = array_unique($data, SORT_REGULAR);

    return $data;
  }
}
