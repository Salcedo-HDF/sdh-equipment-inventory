<?php
require_once('includes/load.php');

$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

date_default_timezone_set('Asia/Manila');

$date = date('Y-m-d H:i:s'); 
$action = "Log out";

if($user_id) {
  $query = "INSERT INTO inout_logs (user_id, date, action) VALUES ('$user_id', '$date', '$action')";
  $db->query($query); 
}

if(!$session->logout()) {
  redirect("index.php");
} else {
  redirect("index.php");
}
?>
