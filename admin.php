<?php
  $page_title = 'Admin Home Page';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
 $c_categorie     = count_by_id('categories');
 $c_product       = count_by_id('products');
 $c_sale          = count_by_id('sales');
 $c_user          = count_by_id('users');
 $products_sold   = find_higest_saleing_product('10');
 $recent_products = find_recent_product_added('5');
 $recent_sales    = find_recent_sale_added('5')
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-6">
     <?php echo display_msg($msg); ?>
   </div>
</div>
  <div class="row">
    <a href="users.php" style="color:black;">
      <div class="col-md-4">
        <div class="panel clearfix">
          <div class="panel-icon pull-left bg-secondary1">
            <i class="glyphicon glyphicon-user"></i>
          </div>
          <div class="panel-value pull-right">
            <h2 class="margin-top"> <?php  echo $c_user['total']; ?> </h2>
            <p class="text-muted">Users</p>
          </div>
        </div>
      </div>
	  </a>
	
    <a href="categorie.php" style="color:black;">
      <div class="col-md-4">
        <div class="panel clearfix">
          <div class="panel-icon pull-left bg-red">
            <i class="glyphicon glyphicon-th-large"></i>
          </div>
          <div class="panel-value pull-right">
            <h2 class="margin-top"> <?php  echo $c_categorie['total']; ?> </h2>
            <p class="text-muted">Categories</p>
          </div>
        </div>
      </div>
    </a>
	
    <a href="product.php" style="color:black;">
      <div class="col-md-4">
        <div class="panel clearfix">
          <div class="panel-icon pull-left bg-blue2">
            <i class="glyphicon glyphicon-shopping-cart"></i>
          </div>
          <div class="panel-value pull-right">
            <h2 class="margin-top"> <?php  echo $c_product['total']; ?> </h2>
            <p class="text-muted">Items</p>
          </div>
        </div>
      </div>
    </a>

</div>
  
  <div class="row">
   </div>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Recently Added Items</span>
        </strong>
      </div>
      <div class="panel-body">

        <div class="list-group">
      <?php foreach ($recent_products as  $recent_product): ?>
            <a class="list-group-item clearfix" href="edit_product.php?id=<?php echo    (int)$recent_product['id'];?>">
                <h4 class="list-group-item-heading">
                 <?php if($recent_product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $recent_product['image'];?>" alt="" />
                <?php endif;?>
                <?php echo remove_junk(first_character($recent_product['name']));?>
                </h4>
                <span class="list-group-item-text pull-right">
                <?php echo remove_junk(first_character($recent_product['categorie'])); ?>
              </span>
          </a>
      <?php endforeach; ?>
    </div>
  </div>
 </div>
</div>
 </div>
  <div class="row">

  </div>



<?php include_once('layouts/footer.php'); ?>

<style>
  .pull-right {
    text-align: center;
  }
</style>
