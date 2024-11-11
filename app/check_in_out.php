<?php
$page_title = 'Check In & Check Out Logs';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);

// Check if there's a search query
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $logs = search_logs($search_query);
} else {
    $logs = join_logs_table();
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <form action="check_in_out.php" method="GET" class="form-inline pull-left">
                    <input type="text" name="search" class="form-control" placeholder="Search logs...">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="check_in_out.php" class="btn btn-danger">Reset</a>
                </form>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th class="text-center"> Photo</th>
                            <th class="text-center"> Item Name </th>
                            <th class="text-center"> User </th>
                            <th class="text-center"> Quantity </th>
                            <th class="text-center"> Date Action </th>
                            <th class="text-center"> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($_GET['search']) && !empty($search_query) && empty($logs)): ?>
                            <tr>
                                <td colspan="15" class="text-center btn-danger">Nothing Found</td>
                            </tr>
                        <?php elseif (empty($logs)): ?>
                            <tr>
                                <td colspan="15" class="text-center btn-danger">No Logs</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td class="text-center"><?php echo count_id(); ?></td>
                                    <td>
                                        <?php if ($log['media_id'] === '0'): ?>
                                            <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                                        <?php else: ?>
                                            <img class="img-avatar img-circle" src="uploads/products/<?php echo $log['image']; ?>" alt="">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo remove_junk($log['name']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($log['user']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($log['quantity']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($log['action_date']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($log['action']); ?></td>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
