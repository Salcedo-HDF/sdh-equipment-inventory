<?php
require_once('includes/load.php');
// Check user access level
page_require_level(2);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request_id'])) {
    $request_id = (int)$_POST['request_id'];
    
    if ($request_id > 0) {
        $sql = "UPDATE requests SET action = 'Disapprove' WHERE id = '{$request_id}'";
        if ($db->query($sql)) {
            $session->msg("s", "Request has been disapproved.");
        } else {
            $session->msg("d", "Failed to disapprove the request.");
        }
    } else {
        $session->msg("d", "Invalid request ID.");
    }
}

redirect('requests.php');
?>
