<?php
$page_title = 'All Employee';
require_once('includes/load.php');
// Check user access level
page_require_level(2);

// Pagination variables
$items_per_page = 20;
$current_page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

// Fetch total items or search results
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$total_items = count_items($search_query);

// Pagination calculation
$total_pages = max(ceil($total_items / $items_per_page), 1);
$current_page = min($current_page, $total_pages);

// Define the number of pages to display at a time
$pages_per_set = 10;

// Calculate the current set of pages
$current_set = ceil($current_page / $pages_per_set);

// Calculate the start and end pages for the current set
$start_page = ($current_set - 1) * $pages_per_set + 1;
$end_page = min($start_page + $pages_per_set - 1, $total_pages);

// Fetch paginated products
$products = get_paginated_products($items_per_page, $offset, $search_query);

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
                <div class="pull-right">
                    <a href="check_in.php" class="btn btn-primary">Check in New Item</a>
                </div>
                <form action="employee.php" method="GET" class="form-inline pull-left">
                    <input type="text" name="search" class="form-control" placeholder="Search item..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="employee.php" class="btn btn-danger">Reset</a>
                </form>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;"> # </th>
                                <th class="text-center"> Employee Name </th>
                                <th class="text-center" style="width: 120px;"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($_GET['search']) && !empty($search_query) && empty($products)): ?>
                                <tr>
                                    <td colspan="15" class="text-center btn-danger">Nothing Found</td>
                                </tr>
                            <?php elseif (empty($products)): ?>
                                <tr>
                                    <td colspan="15" class="text-center btn-danger">No Employee</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($products as $index => $product): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $offset + $index + 1; ?></td>
                                        <td><?php echo remove_junk($product['name']); ?></td><td class="text-center">
                                            <div class="btn-group">
                                                <a href="edit_item.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                                <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
                                                    <span class="glyphicon glyphicon-trash"></span>
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

        <!-- Previous Set Button -->
        <?php if ($current_set > 1): ?>
            <li>
                <a href="?page=<?php echo $start_page - $pages_per_set . (isset($search_query) ? "&search=" . urlencode($search_query) : ""); ?>">
                    &laquo;
                </a>
            </li>
        <?php else: ?>
            <li class="disabled">
                <span>&laquo;</span>
            </li>
        <?php endif; ?>

        <!-- Previous Button -->
        <?php if ($current_page > 1): ?>
            <li>
                <a href="?page=<?php echo $current_page - 1 . (isset($search_query) ? "&search=" . urlencode($search_query) : ""); ?>">
                    Previous
                </a>
            </li>
        <?php else: ?>
            <li class="disabled">
                <span>Previous</span>
            </li>
        <?php endif; ?>

        <!-- Individual Page Numbers -->
        <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
            <li <?php if ($i == $current_page) echo 'class="active"'; ?>>
            <a href="?page=<?php echo $i; ?><?php if (!empty($search_query)) echo '&search=' . urlencode($search_query); ?>">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php endfor; ?>

        <!-- Next Button -->
        <?php if ($current_page < $total_pages): ?>
            <li>
                <a href="?page=<?php echo $current_page + 1 . (isset($search_query) ? "&search=" . urlencode($search_query) : ""); ?>">
                    Next
                </a>
            </li>
        <?php else: ?>
            <li class="disabled">
                <span>Next</span>
            </li>
        <?php endif; ?>

        <!-- Next Set Button -->
        <?php if ($end_page < $total_pages): ?>
            <li>
                <a href="?page=<?php echo $start_page + $pages_per_set . (isset($search_query) ? "&search=" . urlencode($search_query) : ""); ?>">
                     &raquo;
                </a>
            </li>
        <?php else: ?>
            <li class="disabled">
                <span>&raquo;</span>
            </li>
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
