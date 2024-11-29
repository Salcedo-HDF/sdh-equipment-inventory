<?php
require_once('includes/load.php');
// Check user access level
page_require_level(2);

// Get the request ID and quantity from the form
$request_id = isset($_POST['request-id']) ? (int)$_POST['request-id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

// Fetch the corresponding request and item details
$request = find_by_id('requests', $request_id);
if (!$request) {
    // Handle error: Request not found
    $session->msg('d','Request not found.');
    redirect('requests.php');
}

// Fetch the related product details
$item_id = (int)$request['item_id'];
$item = find_by_id('products', $item_id);
if (!$item) {
    // Handle error: Item not found
    $session->msg('d', 'Item not found.');
    redirect('requests.php');
}

// Check if the requested quantity is available
if ($item['quantity'] < $quantity) {
    $session->msg('d', 'Insufficient quantity available for the request.');
    redirect('requests.php');
}

// Deduct the quantity from the product table
$new_quantity = $item['quantity'] - $quantity;
$sql = "UPDATE products SET quantity = '{$new_quantity}' WHERE id = '{$item_id}'";
if ($db->query($sql)) {
    // Update the request action to 'Approved'
    $sql_update_request = "UPDATE requests SET action = 'Approve' WHERE id = '{$request_id}'";
    if ($db->query($sql_update_request)) {

        // Log the approval in requests_log table
        $user_id = (int)$_SESSION['user_id']; // Get the logged-in user ID
        $user_query = "SELECT name FROM users WHERE id = '{$user_id}' LIMIT 1";
        $user_result = $db->query($user_query);
        $user_name = ($user_result && $db->num_rows($user_result) > 0) ? $db->fetch_assoc($user_result)['name'] : '';

        $date_approval = date("Y-m-d H:i:s");
        $log_sql = "INSERT INTO requests_log (item_id, action, request_by, quantity, date_request) 
                    VALUES ('{$item_id}', 'Approve', '{$user_name}', '{$quantity}', '{$date_approval}')";
        $db->query($log_sql);  // Execute the log insertion

        $session->msg('s', 'Request approved successfully.');
        redirect('requests.php');
    } else {
        // Handle error: Failed to update request action
        $session->msg('d', 'Failed to approve request.');
        redirect('requests.php');
    }
} else {
    // Handle error: Failed to update product quantity
    $session->msg('d', 'Failed to update product quantity.');
    redirect('requests.php');
}
?>
