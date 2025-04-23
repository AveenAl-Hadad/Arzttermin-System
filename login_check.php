<?php
session_start();
include "verbindung.php";

$email = $_POST['email'];
$pw = $_POST['passwort'];

$sql = "SELECT * FROM benutzer WHERE email='$email'";
$res = $conn->query($sql);

if ($res->num_rows > 0) {
  $row = $res->fetch_assoc();
  if (password_verify($pw, $row['passwort'])) {
    $_SESSION['userid'] = $row['id'];
    $_SESSION['rolle'] = $row['rolle'];
    header("Location: dashboard.php");
  } else {
    echo "Falsches Passwort";
  }
} else {
  echo "Benutzer nicht gefunden.";
}
?>
