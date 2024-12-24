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
    $e_name = remove_junk($db->escape($_POST['employee-name']));

    $query = "INSERT INTO employee (name) ";
    $query .= "VALUES ('{$e_name}') ";
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
              <label for="employee-name">Employee Full Name</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="employee-name" placeholder="Employee Full Name" required>
               </div>
              </div>

              <button type="submit" name="add_employee" class="btn btn-danger">Add Employee</button>
              
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
