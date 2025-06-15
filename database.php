<?php

$url = "mysql://root:@127.0.0.1:3306/HienCoffee";

$fields = parse_url($url);

$conn = "mysql:";
$conn .= "host=" . $fields["host"];
$conn .= ";port=" . $fields["port"];
$conn .= ";dbname=" . ltrim($fields["path"], '/');

try {
  $db = new PDO($conn, $fields["user"], $fields["pass"]);
  $stmt = $db->query("SELECT VERSION()");
  echo $stmt->fetch()[0];
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}