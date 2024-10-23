<?php
  $page_title = 'Check In Item';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
?>
<?php
 if(isset($_POST['check_in'])){
   $req_fields = array('item-title','item-categorie','item-quantity','item-description','item-status','where-found','checkin-by','checkin-date','checkin-room','checkin-location','checkin-location-barcode','comments'  );
   validate_fields($req_fields);
   if(empty($errors)){
     $i_name  = remove_junk($db->escape($_POST['item-title']));
     $i_cat   = remove_junk($db->escape($_POST['item-categorie']));
     $i_qty   = remove_junk($db->escape($_POST['item-quantity']));
     if (is_null($_POST['item-photo']) || $_POST['item-photo'] === "") {
       $media_id = '0';
     } else {
       $media_id = remove_junk($db->escape($_POST['item-photo']));
     }
     $date    = make_date();
     $query  = "INSERT INTO products (";
     $query .=" name,quantity,buy_price,sale_price,categorie_id,media_id,date";
     $query .=") VALUES (";
     $query .=" '{$i_name}', '{$i_qty}', '{$i_buy}', '{$i_sale}', '{$i_cat}', '{$media_id}', '{$date}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE name='{$i_name}'";
     if($db->query($query)){
       $session->msg('s',"Item added ");
       redirect('check_in.php', false);
     } else {
       $session->msg('d',' Sorry failed to added!');
       redirect('item.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('check_in.php',false);
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
  <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Check In Item</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="check_in.php" class="clearfix">
              <div class="form-group">
              <label for="item-name">Item Name</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="item-title" placeholder="Item Name">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label for="item-category">Category</label>
                    <select class="form-control" name="item-categorie">
                      <option value="">Select Item Category</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label for="item-photo">Item Photo</label>
                    <select class="form-control" name="item-photo">
                      <option value="">Select Item Photo</option>
                    <?php  foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>">
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
                     <input type="number" class="form-control" name="item-quantity" placeholder="Item Quantity">
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
                     <textarea class="form-control" name="item-description" placeholder="Item Description" rows="3"></textarea>
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
                        <option value="Works">Works</option>
                        <option value="Don't Work">Don't Work</option>
                        <option value="N/A">N/A</option>
                        <option value="?">?</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="where-found">Where Found</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-map-marker"></i>
                      </span>
                      <input type="text" class="form-control" name="where-found" placeholder="Where Found?">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="checkin-by">Check in By</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-user"></i>
                      </span>
                      <input type="text" class="form-control" name="checkin-by" placeholder="Checked In By">
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
                    <input type="Date" class="form-control" name="checkin-date" placeholder="Checked In Date">
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="checkin-room">Check in Room</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                    <i class="glyphicon glyphicon-home"></i>
                    </span>
                    <input type="text" class="form-control" name="checkin-room" placeholder="Checked In Room">
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="checkin-location">Check in Location</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                    <i class="glyphicon glyphicon-map-marker"></i>
                    </span>
                    <input type="text" class="form-control" name="checkin-location" placeholder="Checked In Location">
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
                      <input type="text" class="form-control" name="checkin-location-barcode" placeholder="Checked In Location Barcode">
                    </div>
                  </div>

                  <div class="col-md-8">
                    <label for="comments">Comments</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-comment"></i>
                      </span>
                      <input type="text" class="form-control" name="comments" placeholder="Comments">
                    </div>
                  </div>

                </div>
              </div>

              <button type="submit" name="check_in" class="btn btn-danger">Add item</button>
              
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>

<!--
Category
Item
Picture
Number of Items
Description
Works/Don't Work
Where Found
Check in By
Check in Date
Check In Room
Check in Location
Check in Location Barcode

-->
