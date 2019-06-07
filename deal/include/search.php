<?php

// require_once('connexion-bdd.php');

$key = $_GET['key'];
$array  =  array();

$con = mysqli_connect("localhost","admin","","deal");
$query = mysqli_query($con, "select * from annonce where titre LIKE '%{$key}%'");
// $query = mysqli_query($pdo, "select * from annonce where titre LIKE '%{$key}%'");

while ($row = mysqli_fetch_assoc($query)) {
  $array[] = $row['titre'];
}
echo json_encode($array);
mysqli_close($con);
// mysqli_close($pdo);
?>
