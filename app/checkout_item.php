<?php
require_once('includes/load.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = (int)$_POST['product-id'];
    $checkout_by = remove_junk($db->escape($_POST['checkout-by']));
    $checkout_date = remove_junk($db->escape($_POST['checkout-date']));
    $quantity = (int)$_POST['quantity'];
    $due_back_date = !empty($_POST['due-back-date']) ? "'" . remove_junk($db->escape($_POST['due-back-date'])) . "'" : "NULL";
    $comments = remove_junk($db->escape($_POST['comments']));

    date_default_timezone_set('Asia/Manila');

    // Combine the date from the form with the current time
    $checkout_datetime = $checkout_date . ' ' . date('H:i:s'); // Current time added

    // Fetch the current quantity of the product from the products table
    $result = $db->query("SELECT quantity FROM products WHERE id = '{$product_id}'");
    if ($result && $db->num_rows($result) > 0) {
        $product = $db->fetch_assoc($result);
        $current_quantity = (int)$product['quantity'];

        // Check if there is enough stock to check out the desired quantity
        if ($current_quantity >= $quantity) {
            // Calculate the new quantity after checkout
            $new_quantity = $current_quantity - $quantity;

            // Insert into the check_out table
            $query = "INSERT INTO check_out (item_id, checkout_by, checkout_date, quantity, due_back_date, comments) 
                    VALUES ('{$product_id}', '{$checkout_by}', '{$checkout_datetime}', '{$quantity}', {$due_back_date}, '{$comments}')";
            
            if ($db->query($query)) {
                // Update the quantity in the products table
                $update_quantity_query = "UPDATE products SET quantity = '{$new_quantity}' WHERE id = '{$product_id}'";
                
                if ($db->query($update_quantity_query)) {
                    // Log the checkout action in the logs table
                    $log_query = "INSERT INTO logs (action, item_id, user, quantity, action_date) 
                                  VALUES ('Check Out', '{$product_id}', '{$checkout_by}', '{$quantity}', '{$checkout_datetime}')";
                    
                    if ($db->query($log_query)) {
                        $session->msg('s', "Item checked out successfully.");
                    } else {
                        $session->msg('d', 'Failed to log the checkout action.');
                    }
                    
                    redirect('check_out.php');
                } else {
                    $session->msg('d', 'Failed to update product quantity.');
                    redirect('check_out.php');
                }
            } else {
                $session->msg('d', 'Failed to check out item.');
                redirect('check_out.php');
            }
        } else {
            // Not enough stock
            $session->msg('d', 'Not enough stock to check out the desired quantity.');
            redirect('check_out.php');
        }
    } else {
        $session->msg('d', 'Product not found.');
        redirect('check_out.php');
    }
}

?>
