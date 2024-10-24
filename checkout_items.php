<?php
  $page_title = 'All Items';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);

   // Check if there's a search query
  $search_query = '';
  if (isset($_GET['search'])) {
      $search_query = $_GET['search'];
      $products = search_checkout_items($search_query);
  } else {
      $products = join_checkout_table();
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
         <form action="checkout_items.php" method="GET" class="form-inline pull-left">
            <input type="text" name="search" class="form-control" placeholder="Search item...">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="checkout_items.php" class="btn btn-danger">Reset</a>
        </form>
        </div>
        <div class="panel-body">
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
                <th class="text-center"> Check Out By </th>
                <th class="text-center"> Chek Out Date </th>
                <th class="text-center"> Comments </th>
                <th class="text-center"> Actions </th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($products)): ?>
                  <tr>
                      <td colspan="15" class="text-center btn-danger">No items found</td>
                  </tr>
              <?php else: ?>
                <?php foreach ($products as $product):?>
                <tr>
                  <td class="text-center"><?php echo count_id();?></td>
                  <td>
                    <?php if($product['media_id'] === '0'): ?>
                      <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                    <?php else: ?>
                    <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                  <?php endif; ?>
                  </td>
                  <td> <?php echo remove_junk($product['name']); ?></td>
                  <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
                  <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
                  <td class="text-center"> <?php echo remove_junk($product['description']); ?></td>
                  <td class="text-center"> <?php echo remove_junk($product['status']); ?></td>
                  <td class="text-center"> <?php echo remove_junk($product['where_found']); ?></td>
                  <td class="text-center"> <?php echo remove_junk($product['checkout_by']); ?></td>
                  <td class="text-center"> <?php echo remove_junk($product['checkout_date']); ?></td>
                  <td class="text-center"> <?php echo remove_junk($product['comments']); ?></td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="edit_item.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-edit"></span>
                      </a>
                      <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-trash"></span>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
             <?php endif; ?>
            </tbody>
          </tabel>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
