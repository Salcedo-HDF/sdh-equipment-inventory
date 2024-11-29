<?php
require_once('includes/load.php');
// Check what level user has permission to view this page
page_require_level(3);

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = (int)$_POST['product-id'];
    $quantity = (int)$_POST['quantity'];
    $due_back_date = !empty($_POST['due-back-date']) ? remove_junk($db->escape($_POST['due-back-date'])) : NULL;
    $comments = remove_junk($db->escape($_POST['comments']));
    $user_id = (int)$_SESSION['user_id']; // Assuming user ID is stored in session

    // Query to get the user's name
    $user_query = "SELECT name FROM users WHERE id = '{$user_id}' LIMIT 1";
    $user_result = $db->query($user_query);
    $user_name = ($user_result && $db->num_rows($user_result) > 0) ? $db->fetch_assoc($user_result)['name'] : '';

    // Validate quantity
    $product = find_by_id('products', $product_id);
    if (!$product) {
        $session->msg("d", "Product not found!");
        redirect('items.php', false);
    }

    if ($quantity <= 0 || $quantity > $product['quantity']) {
        $session->msg("d", "Invalid quantity requested. Check available stock.");
        redirect('items.php', false);
    }

    // Prepare SQL to insert the request
    $date_request = date("Y-m-d H:i:s");
    $sql = "INSERT INTO requests (item_id, request_by, quantity, dueback_date, comments, date_request, action) 
        VALUES ('{$product_id}', '{$user_name}', '{$quantity}', " . ($due_back_date ? "'{$due_back_date}'" : "NULL") . ", '{$comments}', '{$date_request}', 'Request')";

    if ($db->query($sql)) {

        $session->msg("s", "Request submitted successfully!");
        redirect('items.php', false);
    } else {
        $session->msg("d", "Failed to submit request.");
        redirect('items.php', false);
    }
}
?>
