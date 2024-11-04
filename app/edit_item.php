<?php
  $page_title = 'Edit product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$product = find_by_id('products',(int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
if(!$product){
  $session->msg("d","Missing product id.");
  redirect('product.php');
}
?>
<?php
 if(isset($_POST['product'])){
    $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price' );
    validate_fields($req_fields);

   if(empty($errors)){
       $p_name  = remove_junk($db->escape($_POST['product-title']));
       $p_cat   = (int)$_POST['product-categorie'];
       $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
       $p_buy   = remove_junk($db->escape($_POST['buying-price']));
       $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
       if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
         $media_id = '0';
       } else {
         $media_id = remove_junk($db->escape($_POST['product-photo']));
       }
       $query   = "UPDATE products SET";
       $query  .=" name ='{$p_name}', quantity ='{$p_qty}',";
       $query  .=" buy_price ='{$p_buy}', sale_price ='{$p_sale}', categorie_id ='{$p_cat}',media_id='{$media_id}'";
       $query  .=" WHERE id ='{$product['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Product updated ");
                 redirect('product.php', false);
               } else {
                 $session->msg('d',' Sorry failed to updated!');
                 redirect('edit_item.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_item.php?id='.$product['id'], false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Update Item</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
           <form method="post" action="edit_item.php?id=<?php echo (int)$product['id'] ?>">
              <div class="form-group">
                <label for="item-name">Item Name</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($product['name']);?>">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label for="item-category">Category</label>
                    <select class="form-control" name="product-categorie">
                    <option value=""> Select a categorie</option>
                   <?php  foreach ($all_categories as $cat): ?>
                     <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['categorie_id'] === $cat['id']): echo "selected"; endif; ?> >
                       <?php echo remove_junk($cat['name']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                  <div class="col-md-4">
                    <label for="item-photo">Item Photo</label>
                    <select class="form-control" name="product-photo">
                      <option value=""> No image</option>
                      <?php  foreach ($all_photo as $photo): ?>
                        <option value="<?php echo (int)$photo['id'];?>" <?php if($product['media_id'] === $photo['id']): echo "selected"; endif; ?> >
                          <?php echo $photo['file_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                  <label for="item-quantity">Number of Items</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-list"></i>
                     </span>
                     <input type="number" class="form-control" name="item-quantity" placeholder="Item Quantity" value="<?php echo remove_junk($product['quantity']); ?>">
                  </div>
                 </div>
      
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                <div class="col-md-12">
                  <label for="item-desription">Description</label>
                  <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-file"></i>
                     </span>
                     <textarea class="form-control" name="item-description" placeholder="Item Description" rows="3"><?php echo remove_junk($product['description']); ?></textarea>
                  </div>
                 </div>
               </div>
              </div>

              <div class="form-group">
                <div class="row">
                  
                  <div class="col-md-4">
                    <label for="item-status">Works/Don't Work</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-wrench"></i>
                      </span>
                      <select class="form-control" name="item-status">
                        <option value="">Select Status</option>
                        <option value="Works" <?php if($product['status'] === 'Works'): echo "selected"; endif; ?>>Works</option>
                        <option value="Don't Work" <?php if($product['status'] === "Don't Work"): echo "selected"; endif; ?>>Don't Work</option>
                        <option value="N/A" <?php if($product['status'] === 'N/A'): echo "selected"; endif; ?>>N/A</option>
                        <option value="?" <?php if($product['status'] === '?'): echo "selected"; endif; ?>>?</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="where-found">Where Found</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-map-marker"></i>
                      </span>
                      <input type="text" class="form-control" name="where-found" value="<?php echo remove_junk($product['where_found']); ?>" placeholder="Where Found?">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="checkin-by">Check in By</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-user"></i>
                      </span>
                      <input type="text" class="form-control" name="checkin-by" value="<?php echo remove_junk($product['checkin_by']); ?>" placeholder="Checked In By">
                    </div>
                  </div>

                </div>
              </div>

              <div class="form-group">
                <div class="row">

                <div class="col-md-4">
                  <label for="checkin-date">Check in Date</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                    <i class="glyphicon glyphicon-user"></i>
                    </span>
                    <input type="Date" class="form-control" name="checkin-date" value="<?php echo remove_junk($product['checkin_date']); ?>" placeholder="Checked In Date">
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="checkin-room">Check in Room</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                    <i class="glyphicon glyphicon-home"></i>
                    </span>
                    <input type="text" class="form-control" name="checkin-room" value="<?php echo remove_junk($product['checkin_room']); ?>" placeholder="Checked In Room">
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="checkin-location">Check in Location</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                    <i class="glyphicon glyphicon-map-marker"></i>
                    </span>
                    <input type="text" class="form-control" name="checkin-location" value="<?php echo remove_junk($product['checkin_location']); ?>" placeholder="Checked In Location">
                  </div>
                </div>

                </div>
              </div>

              <div class="form-group">
                <div class="row">

                  <div class="col-md-4">
                    <label for="checkin-location-barcode">Check in Location Barcode</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-barcode"></i>
                      </span>
                      <input type="text" class="form-control" name="checkin-location-barcode" value="<?php echo remove_junk($product['checkin_location_barcode']); ?>" placeholder="Checked In Location Barcode">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="checkin-item-barcode">Check in Item Barcode</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-barcode"></i>
                      </span>
                      <input type="text" class="form-control" name="checkin-item-barcode" value="<?php echo remove_junk($product['checkin_item_barcode']); ?>" placeholder="Checked In Location Barcode">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="comments">Comments</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-comment"></i>
                      </span>
                      <input type="text" class="form-control" name="comments" value="<?php echo remove_junk($product['comments']); ?>" placeholder="Comments">
                    </div>
                  </div>

                </div>
              </div>

              
              <button type="submit" name="product" class="btn btn-danger">Update</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
