<?php
require_once('includes/load.php');

// Check user permission
page_require_level(2);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];

    // Fetch the last checked-out quantity for the specific product
    $result = $db->query("SELECT quantity FROM check_out WHERE item_id = '{$product_id}' ORDER BY checkout_date DESC LIMIT 1");
    
    if ($result && $db->num_rows($result) > 0) {
        $checkout_item = $db->fetch_assoc($result);
        $checkout_quantity = (int)$checkout_item['quantity'];

        // Fetch the current quantity of the product
        $product_result = $db->query("SELECT quantity FROM products WHERE id = '{$product_id}'");
        
        if ($product_result && $db->num_rows($product_result) > 0) {
            $product = $db->fetch_assoc($product_result);
            $current_quantity = (int)$product['quantity'];

            // Update the quantity in the products table
            $new_quantity = $current_quantity + $checkout_quantity;
            $update_query = "UPDATE products SET quantity = '{$new_quantity}' WHERE id = '{$product_id}'";

            if ($db->query($update_query)) {
                // Optionally, you can delete the checked-out entry after check-in
                $delete_checkout_query = "DELETE FROM check_out WHERE item_id = '{$product_id}'";
                $db->query($delete_checkout_query); // Uncomment this line if you want to delete the checked-out entry
                
                $session->msg('s', "Item checked in successfully.");
                redirect('checkout_items.php');
            } else {
                $session->msg('d', 'Failed to update product quantity.');
                redirect('checkout_items.php');
            }
        } else {
            $session->msg('d', 'Product not found.');
            redirect('checkout_items.php');
        }
    } else {
        $session->msg('d', 'No checked-out quantity found for this item.');
        redirect('checkout_items.php');
    }
} else {
    $session->msg('d', 'Invalid request.');
    redirect('checkout_items.php');
}
?>
