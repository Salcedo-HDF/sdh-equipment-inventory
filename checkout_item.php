<?php
require_once('includes/load.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = (int)$_POST['product-id'];
    $checkout_by = remove_junk($db->escape($_POST['checkout-by']));
    $checkout_date = remove_junk($db->escape($_POST['checkout-date']));
    $quantity = (int)$_POST['quantity'];
    $due_back_date = remove_junk($db->escape($_POST['due-back-date']));
    $comments = remove_junk($db->escape($_POST['comments']));

    // Insert into check_out table
    $query = "INSERT INTO check_out (item_id, checkout_by, checkout_date, quantity, due_back_date, comments)";
    $query .= " VALUES ('{$product_id}', '{$checkout_by}', '{$checkout_date}', '{$quantity}', '{$due_back_date}', '{$comments}')";

    if ($db->query($query)) {
        // Update the products table to reflect the "Check Out" action
        $update_query = "UPDATE products SET action = 'Check Out' WHERE id = '{$product_id}'";
        if ($db->query($update_query)) {
            $session->msg('s', "Item checked out successfully.");
            redirect('item.php');
        } else {
            $session->msg('d', 'Failed to check out item.');
            redirect('item.php');
        }
    } else {
        $session->msg('d', 'Failed to check out item.');
        redirect('item.php');
    }
}
?>
