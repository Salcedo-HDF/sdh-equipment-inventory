<?php
$page_title = 'All Request';
require_once('includes/load.php');
// Check user access level
page_require_level(2);

// Pagination variables
$items_per_page = 2;
$current_page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

// Fetch total items or search results
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$total_items = count_request($search_query);

// Pagination calculation
$total_pages = max(ceil($total_items / $items_per_page), 1);
$current_page = min($current_page, $total_pages);

// Fetch paginated request
$requests = join_request($items_per_page, $offset, $search_query);

// Ensure at least one page exists
$total_pages = max(ceil($total_items / $items_per_page), 1);
$current_page = min($current_page, $total_pages);
$offset = ($current_page - 1) * $items_per_page;

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <form action="requests.php" method="GET" class="form-inline pull-left">
                    <input type="text" name="search" class="form-control" placeholder="Search item..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="requests.php" class="btn btn-danger">Reset</a>
                </form>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th class="text-center"> Photo</th>
                                <th class="text-center"> Item Name </th>
                                <th class="text-center"> Request By </th>
                                <th class="text-center"> Quantitty </th>
                                <th class="text-center"> Due Back Date </th>
                                <th class="text-center"> Comments </th>
                                <th class="text-center"> Date Request </th>
                                <th class="text-center"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($_GET['search']) && !empty($search_query) && empty($requests)): ?>
                                <tr>
                                    <td colspan="15" class="text-center btn-danger">Nothing Found</td>
                                </tr>
                            <?php elseif (empty($requests)): ?>
                                <tr>
                                    <td colspan="15" class="text-center btn-danger">No Items</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($requests as $index => $request): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $offset + $index + 1; ?></td>
                                        <td>
                                            <?php if ($request['media_id'] === '0'): ?>
                                                <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                                            <?php else: ?>
                                                <img class="img-avatar img-circle" src="uploads/products/<?php echo $request['image']; ?>" alt="">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo remove_junk($request['name']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($request['request_by']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($request['quantity']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($request['dueback_date']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($request['comments']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($request['date_request']); ?></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="approve_item.php?id=<?php echo (int)$request['id'];?>" class="btn btn-info btn-xs" title="Approve" data-toggle="tooltip">
                                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pagination Controls -->
<div class="pagination-controls text-center">
    <ul class="pagination">
        <?php if ($current_page > 1): ?>
            <li><a href="?page=<?php echo $current_page - 1 . (isset($search_query) ? "&search=" . urlencode($search_query) : ""); ?>">Previous</a></li>
        <?php else: ?>
            <li class="disabled"><span>Previous</span></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li <?php if ($i == $current_page) echo 'class="active"'; ?>>
                <a href="?page=<?php echo $i . (isset($search_query) ? "&search=" . urlencode($search_query) : ""); ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
            <li><a href="?page=<?php echo $current_page + 1 . (isset($search_query) ? "&search=" . urlencode($search_query) : ""); ?>">Next</a></li>
        <?php else: ?>
            <li class="disabled"><span>Next</span></li>
        <?php endif; ?>
    </ul>
</div>

<?php include_once('layouts/footer.php'); ?>

<style>
    .table-responsive {
        max-height: 75vh; 
        overflow-y: auto;
    }

    .table-bordered thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa; 
        z-index: 2; 
        border-bottom: 2px solid #dee2e6;
    }
    th:first-child {
        position: sticky;
        left: 0;
        background-color: #f8f9fa;
        z-index: 3;
    }

</style>
