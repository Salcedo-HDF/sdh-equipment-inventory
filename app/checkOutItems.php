<?php
require_once('includes/load.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['items'])) {
    date_default_timezone_set('Asia/Manila');

    $checkout_by = remove_junk($db->escape($_POST['checkout-by']));
    $checkout_date = date('Y-m-d H:i:s'); // Current date and time
    $items = $_POST['items']; // Array of "item_id-quantity"

    foreach ($items as $item) {
        list($product_id, $quantity) = explode('-', $item);
        $product_id = (int)$product_id;
        $quantity = (int)$quantity;

        // Fetch current stock
        $result = $db->query("SELECT quantity FROM products WHERE id = '{$product_id}'");
        if ($result && $db->num_rows($result) > 0) {
            $product = $db->fetch_assoc($result);
            $current_quantity = (int)$product['quantity'];

            if ($current_quantity >= $quantity) {
                $new_quantity = $current_quantity - $quantity;

                // Insert into check_out table
                $query = "INSERT INTO check_out (item_id, checkout_by, checkout_date, quantity) 
                          VALUES ('{$product_id}', '{$checkout_by}', '{$checkout_date}', '{$quantity}')";

                if ($db->query($query)) {
                    // Update product stock
                    $update_query = "UPDATE products SET quantity = '{$new_quantity}' WHERE id = '{$product_id}'";
                    if ($db->query($update_query)) {
                        // Log the checkout action
                        $log_query = "INSERT INTO logs (action, item_id, user, quantity, action_date) 
                                      VALUES ('Check Out', '{$product_id}', '{$checkout_by}', '{$quantity}', '{$checkout_date}')";
                        $db->query($log_query);
                    } else {
                        $session->msg('d', "Failed to update stock for item ID: {$product_id}");
                    }
                } else {
                    $session->msg('d', "Failed to checkout item ID: {$product_id}");
                }
            } else {
                $session->msg('d', "Not enough stock for item ID: {$product_id}");
            }
        } else {
            $session->msg('d', "Product ID {$product_id} not found.");
        }
    }

    $session->msg('s', "Items checked out successfully.");
    redirect('check_out.php');
}
?>
