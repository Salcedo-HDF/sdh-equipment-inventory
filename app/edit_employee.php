<?php
  $page_title = 'Edit Employee';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$employee = find_by_id('employee',(int)$_GET['id']);
if(!$employee){
  $session->msg("d","Missing employee id.");
  redirect('employee.php');
}
?>
<?php
  if (isset($_POST['update_employee'])) {
    // Getting the values from the form submission
    $e_name = isset($_POST['employee-name']) ? remove_junk($db->escape($_POST['employee-name'])) : '';
    
    // Prepare the base query
    $query = "UPDATE employee SET name ='{$e_name}'";
    
    // Finish the query
    $query .= " WHERE id ='{$employee['id']}'";

    // Execute the query
    $result = $db->query($query);
    
    if ($result && $db->affected_rows() === 1) {
        $session->msg('s', "Employee updated");
        redirect('employee.php', false);
    } else {
        $session->msg('d', 'Sorry, failed to update!');
        redirect('edit_employee.php?id=' . $employee['id'], false);
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
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Update Employee</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
           <form method="post" action="edit_employee.php?id=<?php echo (int)$employee['id'] ?>">

              <div class="form-group">
                <label for="employee-name">Employee Full Name</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="employee-name" value="<?php echo remove_junk($employee['name']);?>">
               </div>
              </div>
              
              <button type="submit" name="update_employee" class="btn btn-danger">Update</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
