<?php
$page_title = 'Users Logs';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);

// Check if there's a search query
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $infos = search_user($search_query);
} else {
    $infos = user_table();
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
                            <th class="text-center"> Image</th>
                            <th class="text-center"> Name </th>
                            <th class="text-center"> User Level </th>
                            <th class="text-center"> Last Log In </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($_GET['search']) && !empty($search_query) && empty($infos)): ?>
                            <tr>
                                <td colspan="15" class="text-center btn-danger">Nothing Found</td>
                            </tr>
                        <?php elseif (empty($infos)): ?>
                            <tr>
                                <td colspan="15" class="text-center btn-danger">No User Found</td>
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
                                    <td class="text-center"><?php echo remove_junk($info['last_login']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
