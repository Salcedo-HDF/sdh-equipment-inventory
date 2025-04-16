<?php
  $page_title = 'Edit item';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$item = find_by_id('products',(int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
if(!$item){
  $session->msg("d","Missing item id.");
  redirect('item.php');
}
?>
<?php
  if (isset($_POST['item'])) {
    // Getting the values from the form submission
    $p_name = isset($_POST['item-title']) ? remove_junk($db->escape($_POST['item-title'])) : '';
    $p_cat = isset($_POST['item-categorie']) ? (int)$_POST['item-categorie'] : null;
    $p_qty = isset($_POST['item-quantity']) ? remove_junk($db->escape($_POST['item-quantity'])) : null;
    $p_description = isset($_POST['item-description']) ? remove_junk($db->escape($_POST['item-description'])) : null;
    $i_status = isset($_POST['item-status']) ? remove_junk($db->escape($_POST['item-status'])) : null;
    $i_where_found = isset($_POST['where-found']) ? remove_junk($db->escape($_POST['where-found'])) : null;
    $i_checkin_date = !empty($_POST['checkin-date']) ? "'" . remove_junk($db->escape($_POST['checkin-date'])) . "'" : "NULL";
    $i_checkin_room = isset($_POST['checkin-room']) ? remove_junk($db->escape($_POST['checkin-room'])) : null;
    $i_checkin_location = isset($_POST['checkin-location']) ? remove_junk($db->escape($_POST['checkin-location'])) : null;
    $i_checkin_location_barcode = isset($_POST['checkin-location-barcode']) ? remove_junk($db->escape($_POST['checkin-location-barcode'])) : null;
    $i_comments = isset($_POST['comments']) ? remove_junk($db->escape($_POST['comments'])) : null;
    $i_checkin_item_barcode = isset($_POST['checkin-item-barcode']) ? remove_junk($db->escape($_POST['checkin-item-barcode'])) : null;
    
    // Prepare the base query
    $query = "UPDATE products SET name ='{$p_name}'";

    // Append fields if they are not null
    if (!is_null($p_qty)) {
        $query .= ", quantity ='{$p_qty}'";
    }
    if (!is_null($p_description)) {
        $query .= ", description ='{$p_description}'";
    }
    if (!is_null($p_cat)) {
        $query .= ", categorie_id ='{$p_cat}'";
    }
    if (!is_null($i_status)) {
        $query .= ", status ='{$i_status}'";
    }
    
    if (!is_null($i_where_found)) {
        $query .= ", where_found ='{$i_where_found}'";
    }
    
    if (!is_null($i_checkin_date)) {
        $query .= ", checkin_date ={$i_checkin_date}";
    }
    
    if (!is_null($i_checkin_room)) {
        $query .= ", checkin_room ='{$i_checkin_room}'";
    }
    
    if (!is_null($i_checkin_location)) {
        $query .= ", checkin_location ='{$i_checkin_location}'";
    }
    
    if (!is_null($i_checkin_location_barcode)) {
        $query .= ", checkin_location_barcode ='{$i_checkin_location_barcode}'";
    }
    
    if (!is_null($i_comments)) {
        $query .= ", comments ='{$i_comments}'";
    }
    
    if (!is_null($i_checkin_item_barcode)) {
        $query .= ", checkin_item_barcode ='{$i_checkin_item_barcode}'";
    }
    
    // Media ID handling
    $media_id = (is_null($_POST['item-photo']) || $_POST['item-photo'] === "") ? '0' : remove_junk($db->escape($_POST['item-photo']));
    $query .= ", media_id='{$media_id}'";
    
    // Finish the query
    $query .= " WHERE id ='{$item['id']}'";

    // Execute the query
    $result = $db->query($query);
    
    if ($result && $db->affected_rows() === 1) {
        $session->msg('s', "Item updated");
        redirect('item.php', false);
    } else {
        $session->msg('d', 'Sorry, failed to update!');
        redirect('edit_item.php?id=' . $item['id'], false);
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
           <form method="post" action="edit_item.php?id=<?php echo (int)$item['id'] ?>">
              <div class="form-group">
                <label for="item-name">Item Name</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="item-title" value="<?php echo remove_junk($item['name']);?>">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label for="item-category">Category</label>
                    <select class="form-control" name="item-categorie">
                    <option value=""> Select a categorie</option>
                   <?php  foreach ($all_categories as $cat): ?>
                     <option value="<?php echo (int)$cat['id']; ?>" <?php if($item['categorie_id'] === $cat['id']): echo "selected"; endif; ?> >
                       <?php echo remove_junk($cat['name']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                  <div class="col-md-4">
                    <label for="item-photo">Item Photo</label>
                    <select class="form-control" name="item-photo">
                      <option value=""> No image</option>
                      <?php  foreach ($all_photo as $photo): ?>
                        <option value="<?php echo (int)$photo['id'];?>" <?php if($item['media_id'] === $photo['id']): echo "selected"; endif; ?> >
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
                     <input type="number" class="form-control" name="item-quantity" placeholder="Item Quantity" value="<?php echo remove_junk($item['quantity']); ?>">
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
                     <textarea class="form-control" name="item-description" placeholder="Item Description" rows="3"><?php echo remove_junk($item['description']); ?></textarea>
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
                        <option value="Works" <?php if($item['status'] === 'Works'): echo "selected"; endif; ?>>Works</option>
                        <option value="Don't Work" <?php if($item['status'] === "Don't Work"): echo "selected"; endif; ?>>Don't Work</option>
                        <option value="N/A" <?php if($item['status'] === 'N/A'): echo "selected"; endif; ?>>N/A</option>
                        <option value="?" <?php if($item['status'] === '?'): echo "selected"; endif; ?>>?</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="where-found">Where Found</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-map-marker"></i>
                      </span>
                      <select class="form-control" name="where-found">
                        <option value="">Select Where Found</option>
                        <option value="Old Storage Next to Isolation Room" <?php if($item['where_found'] === 'Old Storage Next to Isolation Room'): echo "selected"; endif; ?>>Old Storage Next to Isolation Room</option>
                        <option value="Business Office" <?php if($item['where_found'] === "Business Office"): echo "selected"; endif; ?>>Business Office</option>
                        <option value="Chief of Hospital Office" <?php if($item['where_found'] === 'Chief of Hospital Office'): echo "selected"; endif; ?>>Chief of Hospital Office</option>
                        <option value="Emergency Room" <?php if($item['where_found'] === 'Emergency Room'): echo "selected"; endif; ?>>Emergency Room</option>
                        <option value="Parcel Delivered" <?php if($item['where_found'] === 'Parcel Delivered'): echo "selected"; endif; ?>>Parcel Delivered</option>
                        <option value="OPD" <?php if($item['where_found'] === 'OPD'): echo "selected"; endif; ?>>OPD</option>
                        <option value="Records Section" <?php if($item['where_found'] === 'Records Section'): echo "selected"; endif; ?>>Records Section</option>
                        <option value="2nd Floor" <?php if($item['where_found'] === '2nd Floor'): echo "selected"; endif; ?>>2nd Floor</option>
                        <option value="N/A" <?php if($item['where_found'] === 'N/A'): echo "selected"; endif; ?>>N/A</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="checkin-date">Check in Date</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-user"></i>
                      </span>
                      <input type="Date" class="form-control" name="checkin-date" value="<?php echo remove_junk($item['checkin_date']); ?>" placeholder="Checked In Date">
                    </div>
                  </div>

                </div>
              </div>

              <div class="form-group">
                <div class="row">

                <div class="col-md-4">
                  <label for="checkin-room">Check in Room</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                    <i class="glyphicon glyphicon-home"></i>
                    </span>
                    <select class="form-control" name="checkin-room">
                      <option value="">Select Check in Room</option>
                      <option value="Outside Storage" <?php if($item['checkin_room'] === 'Outside Storage'): echo "selected"; endif; ?>>Outside Storage</option>
                      <option value="Inside Storage" <?php if($item['checkin_room'] === "Business Office"): echo "selected"; endif; ?>>Business Office</option>
                      <option value="Chapel" <?php if($item['checkin_room'] === 'Chapel'): echo "selected"; endif; ?>>Chapel</option>
                      <option value="N/A" <?php if($item['checkin_room'] === 'N/A'): echo "selected"; endif; ?>>N/A</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="checkin-location">Check in Location</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                    <i class="glyphicon glyphicon-map-marker"></i>
                    </span>
                    <input type="text" class="form-control" name="checkin-location" value="<?php echo remove_junk($item['checkin_location']); ?>" placeholder="Checked In Location">
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="checkin-location-barcode">Check in Location Barcode</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                    <i class="glyphicon glyphicon-barcode"></i>
                    </span>
                    <input type="text" class="form-control" name="checkin-location-barcode" value="<?php echo remove_junk($item['checkin_location_barcode']); ?>" placeholder="Checked In Location Barcode">
                  </div>
                </div>

                </div>
              </div>

              <div class="form-group">
                <div class="row">

                  <div class="col-md-4">
                    <label for="checkin-item-barcode">Check in Item Barcode</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-barcode"></i>
                      </span>
                      <input type="text" class="form-control" name="checkin-item-barcode" value="<?php echo remove_junk($item['checkin_item_barcode']); ?>" placeholder="Checked In Location Barcode">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label for="comments">Comments</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-comment"></i>
                      </span>
                      <input type="text" class="form-control" name="comments" value="<?php echo remove_junk($item['comments']); ?>" placeholder="Comments">
                    </div>
                  </div>

                </div>
              </div>

              
              <button type="submit" name="item" class="btn btn-danger">Update</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
