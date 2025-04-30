<?php
require_once('includes/load.php');
// Check what level user has permission to view this page
page_require_level(2);

if (isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    $product = find_by_id('products', $product_id);
    
    if (!$product) {
        $session->msg("d", "Missing Item ID.");
        redirect('item.php');
    }

    // Instead of deleting, update the action column to 'Deleted'
    $sql = "UPDATE products SET action = 'Deleted' WHERE id = '{$product_id}'";
    $result = $db->query($sql);

    if ($result) {
        $session->mgit sg("s", "Item marked as deleted.");
    } else {
        $session->msg("d", "Failed to mark item as deleted.");
    }
    redirect('item.php');
} else {
    $session->msg("d", "Missing Item ID.");
    redirect('item.php');
}
?>
