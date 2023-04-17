<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ARPAVGruppon";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database ARPAVGruppon creato con successo\n";
} else {
    echo "Errore nella creazione del database: " . $conn->error;
}

$conn->select_db($dbname);

$sql = "CREATE TABLE IF NOT EXISTS stazioni (
  codseqst CHAR(9) NOT NULL PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  localita VARCHAR(255) NOT NULL,
  comune VARCHAR(255) NOT NULL,
  provincia VARCHAR(255) NOT NULL,
  lat DOUBLE NOT NULL,
  lon DOUBLE NOT NULL
);";

if ($conn->query($sql) === TRUE) {
  echo "Tabella stazioni creata con successo\n";
} else {
  echo "Errore nella creazione della tabella: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS rilevazioni (
  codseqst CHAR(9) NOT NULL,
  data DATE NOT NULL,
  tipoInquinante VARCHAR(255) NOT NULL,
  valore DOUBLE NOT NULL,
  PRIMARY KEY (codseqst, data, tipoInquinante),
  FOREIGN KEY (codseqst) REFERENCES stazioni(codseqst)
);";

if ($conn->query($sql) === TRUE) {
    echo "Tabella rilevazioni creata con successo\n";
} else {
    echo "Errore nella creazione della tabella: " . $conn->error;
}

$file = fopen('csv/stats.csv', 'r');
fgetcsv($file);

while (($data = fgetcsv($file)) !== FALSE) {
  $nome = $data[0];
  $localita = $data[1];
  $comune = $data[2];
  $provincia = $data[3];
  $tipozona = $data[4];
  $codseqst = $data[7];
  $lat = $data[8];
  $lon = $data[9];

  $sql = "INSERT IGNORE INTO stazioni (codseqst, nome, localita, comune, provincia, lat, lon)
          VALUES (\"$codseqst\", \"$nome\", \"$localita\", \"$comune\", \"$provincia\", \"$lat\", \"$lon\")";

  if ($conn->query($sql) === TRUE) {
    $result= "Record inserito con successo\n";
  } else {
    echo "Errore nell'inserimento del record: " . $conn->error;
  }
}
fclose($file);

function rilevazioni($fname, $conn) {
  $file = fopen($fname, 'r');

  fgetcsv($file);

  $data = fgetcsv($file);

  $codseqst1 = $data[1];
  $codseqst2 = $data[2];
  $codseqst3 = $data[3];
  $codseqst4 = $data[4];
  $codseqst5 = $data[5];

  while (($data = fgetcsv($file)) !== FALSE) {
    $dateObj = DateTime::createFromFormat('d/m/Y', $data[0]);
    $data[0] = $dateObj->format('Y-m-d');
    
    for ($i = 0; $i < 5; $i++) {
      $tipoInquinante = "PM10";
      $valore = $data[$i+1];
    
      switch ($i) {
        case 0:
          $codseqst = $codseqst1;
          break;
        case 1:
          $codseqst = $codseqst2;
          break;
        case 2:
          $codseqst = $codseqst3;
          break;
        case 3:
          $codseqst = $codseqst4;
          break;
        case 4:
          $codseqst = $codseqst5;
          break;
      }
    
      $sql = "INSERT IGNORE INTO rilevazioni (codseqst, data, tipoInquinante, valore) VALUES 
              (\"$codseqst\", \"$data[0]\", \"$tipoInquinante\", \"$valore\")";

      if ($conn->query($sql) === TRUE) {
        $result=  "Record inserito con successo\n";
      } else {
        echo "Errore nell'inserimento del record: " . $conn->error;
      }
    }

    $tipoInquinante = "PM2,5";
    $valore = $data[6];

    $sql = "INSERT IGNORE INTO rilevazioni (codseqst, data, tipoInquinante, valore)
            VALUES (\"$codseqst5\", \"$data[0]\", \"$tipoInquinante\", \"$valore\")";

    if ($conn->query($sql) === TRUE) {
      $result=  "Record inserito con successo\n";
    } else {
      echo "Errore nell'inserimento del record: " . $conn->error;
    }
  }

  fclose($file);
}
$conn->close();

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
$conn->select_db($dbname);
rilevazioni('csv/PM10_centraline_daily_2019.csv', $conn);

$conn->close();

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
$conn->select_db($dbname);
rilevazioni('csv/PM10_centraline_daily_2020.csv', $conn);
$conn->select_db($dbname);

echo "Dati inseriti con successo!";
