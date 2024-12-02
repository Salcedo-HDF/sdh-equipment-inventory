<?php include_once('includes/load.php'); ?>
<?php
$req_fields = array('username', 'password');
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

date_default_timezone_set('Asia/Manila');

if(empty($errors)) {
  $user_id = authenticate($username, $password);
  if($user_id) {
    // Create session with id
    $session->login($user_id);

    // Update Sign in time
    updateLastLogIn($user_id);

    // Log the action in 'inout_logs'
    $date = date('Y-m-d H:i:s'); // Get current date and time
    $action = "Log in";

    $query = "INSERT INTO inout_logs (user_id, date, action) VALUES ('$user_id', '$date', '$action')";
    if ($db->query($query)) {
      // Optional: Log entry successful
    } else {
      // Handle any potential error during logging
      $session->msg("d", "Error logging login action.");
    }

    // Redirect to the admin page with success message
    $session->msg("s", "Welcome to SDH Equipment Inventory System");
    redirect('admin.php', false);

  } else {
    // Incorrect username or password
    $session->msg("d", "Sorry, Username/Password incorrect.");
    redirect('index.php', false);
  }

} else {
  // Display validation errors
  $session->msg("d", $errors);
  redirect('index.php', false);
}
?>
