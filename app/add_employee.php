<?php
$page_title = 'Check In Item';
require_once('includes/load.php');


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect to login page or show a message
  header('Location: index.php'); // Change this to your login page URL
  exit();
}

if (isset($_POST['add_employee'])) {
    $e_name = remove_junk($db->escape($_POST['item-name']));

    // Insert into products table
    $query = "INSERT INTO products (name, quantity, description, status, where_found, checkin_by, checkin_date, checkin_room, checkin_location, checkin_location_barcode, comments, categorie_id, media_id, date, action) ";
    $query .= "VALUES ('{$i_name}', '{$i_qty}', '{$i_description}', '{$i_status}', '{$i_where_found}', '{$user_name}', {$i_checkin_date}, '{$i_checkin_room}', '{$i_checkin_location}', '{$i_checkin_location_barcode}', '{$i_comments}', '{$i_cat}', '{$media_id}', '{$date}', '{$action}') ";

    if ($db->query($query)) {
        // Get the last inserted item_id
        $item_id = $db->insert_id();

        // Insert into logs table
        $log_query = "INSERT INTO logs (item_id, action, `user`, quantity, action_date) VALUES ('{$item_id}', '{$action}', '{$user_name}', '{$i_qty}', '{$date}')";
        if ($db->query($log_query)) {
            $session->msg('s', "Item added successfully.");
            redirect('item.php', false);
        } else {
            $session->msg('d', 'Item added, but failed to log action.');
            redirect('item.php', false);
        }

    } else {
        $error_message = $db->error;
        $session->msg('d', "Sorry failed to add! Error: {$error_message}");
        redirect('item.php', false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add Employee</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_employee.php" class="clearfix">
              <div class="form-group">
              <label for="item-name">Employee Full Name</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="item-name" placeholder="Employee Full Name" required>
               </div>
              </div>

              <button type="submit" name="add_employee" class="btn btn-danger">Add item</button>
              
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
