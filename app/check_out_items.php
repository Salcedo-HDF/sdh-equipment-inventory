<?php
  $page_title = 'All Items';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);

   $items_per_page = 5;
  $current_page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Fetch total items or search results
  $search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
  $total_items = count_checkout($search_query);

  // Pagination calculation
  $total_pages = max(ceil($total_items / $items_per_page), 1);
  $current_page = min($current_page, $total_pages);

  // Fetch paginated products
  $products = join_checkout_table($items_per_page, $offset, $search_query);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <form action="check_out_items.php" method="GET" class="form-inline pull-left">
                    <input type="text" name="search" class="form-control" placeholder="Search item...">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="check_out_items.php" class="btn btn-danger">Reset</a>
                </form>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th class="text-center">Photo</th>
                                <th class="text-center">Item Name</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Number of Items</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Works/Don't Work</th>
                                <th class="text-center">Where Found</th>
                                <th class="text-center">Check Out By</th>
                                <th class="text-center">Check Out Date</th>
                                <th class="text-center">Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="15" class="text-center btn-danger">No items found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td class="text-center"><?php echo count_id();?></td>
                                        <td>
                                            <?php if($product['media_id'] === '0'): ?>
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
                                        <td class="text-center"><?php echo remove_junk($product['checkout_by']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($product['checkout_date']); ?></td>
                                        <td class="text-center"><?php echo remove_junk($product['comments']); ?></td>
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
</style>
