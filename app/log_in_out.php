<?php
$page_title = 'Users Logs';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);

// Pagination settings
$items_per_page = 2; // Number of items per page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page or default to 1

// Check if there's a search query
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $infos = search_user($search_query, $items_per_page, $current_page);
} else {
    $infos = user_table($items_per_page, $current_page);
}

// Count total users for pagination, passing search query if it exists
$total_users = count_total_users($search_query);
$total_pages = ceil($total_users / $items_per_page);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <form action="log_in_out.php" method="GET" class="form-inline pull-left">
                    <input type="text" name="search" class="form-control" placeholder="Search user...">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="log_in_out.php" class="btn btn-danger">Reset</a>
                </form>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">User Level</th>
                            <th class="text-center">Last Log In</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($_GET['search']) && !empty($search_query) && empty($infos)): ?>
                            <tr>
                                <td colspan="5" class="text-center btn-danger">Nothing Found</td>
                            </tr>
                        <?php elseif (empty($infos)): ?>
                            <tr>
                                <td colspan="5" class="text-center btn-danger">No User Found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($infos as $info): ?>
                                <tr>
                                    <td class="text-center"><?php echo count_id(); ?></td>
                                    <td>
                                        <img class="img-avatar img-circle" src="uploads/users/<?php echo $info['image']; ?>" alt="">
                                    </td>
                                    <td><?php echo remove_junk($info['name']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($info['user_level']); ?></td>
                                    <td class="text-center"><?php echo read_date($info['last_login']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Pagination Controls -->
<div class="pagination-controls text-center">
    <ul class="pagination">
        <!-- Previous Page Button -->
        <?php if ($current_page > 1): ?>
            <li>
                <a href="?page=<?php echo $current_page - 1; ?><?php if (!empty($search_query)) echo '&search=' . urlencode($search_query); ?>">Previous</a>
            </li>
        <?php else: ?>
            <li class="disabled"><span>Previous</span></li>
        <?php endif; ?>

        <!-- Page Numbers -->
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li <?php if ($i == $current_page) echo 'class="active"'; ?>>
                <a href="?page=<?php echo $i; ?><?php if (!empty($search_query)) echo '&search=' . urlencode($search_query); ?>">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php endfor; ?>

        <!-- Next Page Button -->
        <?php if ($current_page < $total_pages): ?>
            <li>
                <a href="?page=<?php echo $current_page + 1; ?><?php if (!empty($search_query)) echo '&search=' . urlencode($search_query); ?>">Next</a>
            </li>
        <?php else: ?>
            <li class="disabled"><span>Next</span></li>
        <?php endif; ?>
    </ul>
</div>

<?php include_once('layouts/footer.php'); ?>
