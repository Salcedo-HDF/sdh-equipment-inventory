<?php
$page_title = 'All Items';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);

// Pagination variables
$items_per_page = 20;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

// Fetch total number of products or search results
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $count_result = count_search_items($search_query);  // Adjust counting function for search
    $total_items = $count_result['total'];
} else {
    $count_result = count_by_id('products');
    $total_items = $count_result['total'];
}

$total_pages = ceil($total_items / $items_per_page);

// Ensure that the current page is within the valid range
if ($current_page > $total_pages) {
    $current_page = $total_pages;
    $offset = ($current_page - 1) * $items_per_page;
}

// Fetch products with pagination
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $products = search_items($search_query);  // Make sure this query handles pagination correctly
} else {
    $products = join_product_table($items_per_page, $offset);  // Default query with pagination
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
                <div class="pull-right">
                    <a href="check_in.php" class="btn btn-primary">Check in New Item</a>
                </div>
                <form action="item.php" method="GET" class="form-inline pull-left">
                    <input type="text" name="search" class="form-control" placeholder="Search item...">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="item.php" class="btn btn-danger">Reset</a>
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
                                <th class="text-center"> Category </th>
                                <th class="text-center"> Number of Items </th>
                                <th class="text-center"> Description </th>
                                <th class="text-center"> Works/Don't Work </th>
                                <th class="text-center"> Where Found </th>
                                <th class="text-center"> Checkin By </th>
                                <th class="text-center"> Check in Date </th>
                                <th class="text-center"> Check in Room </th>
                                <th class="text-center"> Check in Location </th>
                                <th class="text-center"> Check in Location Barcode </th>
                                <th class="text-center"> Check in item Barcode </th>
                                <th class="text-center"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($_GET['search']) && !empty($search_query) && empty($products)): ?>
                                <tr>
                                    <td colspan="15" class="text-center btn-danger">Nothing Found</td>
                                </tr>
                            <?php elseif (empty($products)): ?>
                                <tr>
                                    <td colspan="15" class="text-center btn-danger">No Items</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td class="text-center"><?php echo count_id(); ?></td>
                                        <td>
                                            <?php if ($product['media_id'] === '0'): ?>
                                                <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                                            <?php else: ?>
                                                <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo remove_junk($product['name']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($product['categorie']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($product['quantity']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($product['description']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($product['status']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($product['where_found']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($product['checkin_by']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($product['checkin_date']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($product['checkin_room']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($product['checkin_location']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($product['checkin_location_barcode']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($product['checkin_item_barcode']); ?></td>
                                        <td class="text-center">
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
        <!-- Previous Page Button -->
        <?php if ($current_page > 1): ?>
            <li><a href="?page=<?php echo $current_page - 1; ?>">Previous</a></li>
        <?php else: ?>
            <li class="disabled"><span>Previous</span></li>
        <?php endif; ?>

        <!-- Page Numbers -->
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li <?php if ($i == $current_page) echo 'class="active"'; ?>>
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <!-- Next Page Button -->
        <?php if ($current_page < $total_pages): ?>
            <li><a href="?page=<?php echo $current_page + 1; ?>">Next</a></li>
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
</style>
