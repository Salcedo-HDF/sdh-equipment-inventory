<?php
$page_title = 'Check In Item';
require_once('includes/load.php');

$all_categories = find_all('categories');
$all_photo = find_all('media');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect to login page or show a message
  header('Location: index.php'); // Change this to your login page URL
  exit();
}

$user_id = $_SESSION['user_id'];

// Query to get the user's name
$user_query = "SELECT name FROM users WHERE id = '{$user_id}' LIMIT 1";
$user_result = $db->query($user_query);
$user_name = ($user_result && $db->num_rows($user_result) > 0) ? $db->fetch_assoc($user_result)['name'] : '';

if (isset($_POST['check_in'])) {
    $i_name = remove_junk($db->escape($_POST['item-name']));
    $i_cat = remove_junk($db->escape($_POST['item-category']));
    $i_qty = remove_junk($db->escape($_POST['item-quantity']));
    $i_description = remove_junk($db->escape($_POST['item-description']));
    $i_status = remove_junk($db->escape($_POST['item-status']));
    $i_where_found = remove_junk($db->escape($_POST['where-found']));
    $i_checkin_date = remove_junk($db->escape($_POST['checkin-date']));
    $i_checkin_room = remove_junk($db->escape($_POST['checkin-room']));
    $i_checkin_location = remove_junk($db->escape($_POST['checkin-location']));
    $i_checkin_location_barcode = remove_junk($db->escape($_POST['checkin-location-barcode']));
    $i_comments = remove_junk($db->escape($_POST['comments']));
    $action = 'Check In';
    $date = make_date();

    if (is_null($_POST['item-photo']) || $_POST['item-photo'] === "") {
        $media_id = '0';
    } else {
        $media_id = remove_junk($db->escape($_POST['item-photo']));
    }

    // Insert into products table
    $query = "INSERT INTO products (name, quantity, description, status, where_found, checkin_by, checkin_date, checkin_room, checkin_location, checkin_location_barcode, comments, categorie_id, media_id, date, action) ";
    $query .= "VALUES ('{$i_name}', '{$i_qty}', '{$i_description}', '{$i_status}', '{$i_where_found}', '{$user_name}', '{$i_checkin_date}', '{$i_checkin_room}', '{$i_checkin_location}', '{$i_checkin_location_barcode}', '{$i_comments}', '{$i_cat}', '{$media_id}', '{$date}', '{$action}') ";
    $query .= "ON DUPLICATE KEY UPDATE name='{$i_name}'";

    if ($db->query($query)) {
        // Get the last inserted item_id
        $item_id = $db->insert_id();

        // Insert into logs table
        $log_query = "INSERT INTO logs (item_id, action, `user`, quantity, action_date) VALUES ('{$item_id}', '{$action}', '{$user_name}', '{$i_qty}', '{$date}')";
        if ($db->query($log_query)) {
            $session->msg('s', "Item added successfully.");
            redirect('item.php', false);
        } else {
            $session->msg('d', 'Item added, but failed to log action.');
            redirect('item.php', false);
        }

    } else {
        $error_message = $db->error;
        $session->msg('d', "Sorry failed to add! Error: {$error_message}");
        redirect('item.php', false);
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
                  <input type="text" class="form-control" name="item-name" placeholder="Item Name" required>
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-4">
                    <label for="item-category">Category</label>
                    <select class="form-control" name="item-category" required>
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
                    <label for="checkin-date">Check in Date</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-user"></i>
                      </span>
                      <input type="Date" class="form-control" name="checkin-date" placeholder="Checked In Date" required>
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

                <div class="col-md-4">
                  <label for="checkin-location-barcode">Check in Location Barcode</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                    <i class="glyphicon glyphicon-barcode"></i>
                    </span>
                    <input type="text" class="form-control" name="checkin-location-barcode" placeholder="Checked In Location Barcode">
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
                      <input type="text" class="form-control" name="checkin-item-barcode" placeholder="Checked In Location Barcode">
                    </div>
                  </div>

                  <div class="col-md-4">
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
