<?php
require 'database.php';

if (!empty($_POST)) {

  $id = $_POST['id'];
  $temperature = $_POST['temperature'];
  $humidity = $_POST['humidity'];
  $moisture = $_POST['moisture'];
  $status_read_sensor_dht11 = $_POST['status_read_sensor_dht11'];
  $dt = ("datetime");

  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "UPDATE dht11 SET temperature = ?, humidity = ?,moisture = ?, status_read_sensor_dht11 = ?, datetime = ? WHERE id = ?";
  $q = $pdo->prepare($sql);
  $q->execute(array($temperature, $humidity ,$moisture , $status_read_sensor_dht11, $dt, $id));
  Database::disconnect();


  //........................................ Entering data into a table.
  $id_key;
  $board = $_POST['id'];
  $found_empty = false;

  $pdo = Database::connect();

  // Process to check if "id" is already in use.
  while ($found_empty == false) {
    $id_key = generate_string_id(10);

    $sql = 'SELECT * FROM dht11 WHERE id="' . $id_key . '"';
    $q = $pdo->prepare($sql);
    $q->execute();

    if (!$data = $q->fetch()) {

      $found_empty = true;
    }
  }


  //:::::::: The process of entering data into a table.
  //jhjfjhdfh
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "INSERT INTO dht11 (temperature,humidity,moisture,status_read_sensor_dht11) values(?,?,?,?)";
  $q = $pdo->prepare($sql);
  $q->execute(array($temperature, $humidity, $mouisture,  $status_read_sensor_dht11));
  //::::::::

  Database::disconnect();
  //........................................ 
}


//---------------------------------------- Function to create "id" based on numbers and characters.
function generate_string_id($strength = 16)
{
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $input_length = strlen($permitted_chars);
  $random_string = '';
  for ($i = 0; $i < $strength; $i++) {
    $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
    $random_string .= $random_character;
  }
  return $random_string;
}
//---------------------------------------- 
