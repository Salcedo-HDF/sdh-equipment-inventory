<?php
  require_once('includes/load.php');
  page_require_level(2);
?>
<?php
  $product = find_by_id('employee',(int)$_GET['id']);
  if(!$product){
    $session->msg("d","Missing Employee id.");
    redirect('employee.php');
  }
?>
<?php
  $delete_id = delete_by_id('employee',(int)$product['id']);
  if($delete_id){
      $session->msg("s","Employee deleted.");
      redirect('employee.php');
  } else {
      $session->msg("d","Employee deletion failed.");
      redirect('employee.php');
  }
?>
