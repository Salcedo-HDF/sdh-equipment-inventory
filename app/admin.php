<?php
  $page_title = 'Admin Home Page';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>

<?php
 $c_categorie     = count_by_id('categories');
 $c_product       = count_by_id('products');
 $c_user          = count_by_id('users');
 $recent_products = find_recent_product_added(5);

// Fetch all products and sort them alphabetically by name
$all_products = find_all('products');
usort($all_products, function($a, $b) {
    return strcmp($a['name'], $b['name']);
});
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
            <i class="glyphicon glyphicon-tags"></i>
          </div>
          <div class="panel-value pull-right">
            <h2 class="margin-top"> <?php  echo $c_categorie['total']; ?> </h2>
            <p class="text-muted">Categories</p>
          </div>
        </div>
      </div>
    </a>

    <a href="item.php" style="color:black;">
      <div class="col-md-4">
        <div class="panel clearfix">
          <div class="panel-icon pull-left bg-blue2">
            <i class="glyphicon glyphicon-briefcase"></i>
          </div>
          <div class="panel-value pull-right">
            <h2 class="margin-top"> <?php  echo $c_product['total']; ?> </h2>
            <p class="text-muted">Items</p>
          </div>
        </div>
      </div>
    </a>
</div>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Recently Checked-In Items</span>
            </strong>
        </div>
        <div class="panel-body">
            <div class="list-group">
                <?php foreach ($recent_products as $recent_product): ?>
                    <a class="list-group-item clearfix" href="edit_item.php?id=<?php echo (int)$recent_product['id']; ?>">
                        <h4 class="list-group-item-heading">
                            <?php if ($recent_product['media_id'] === '0'): ?>
                                <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                            <?php else: ?>
                                <img class="img-avatar img-circle" src="uploads/products/<?php echo $recent_product['image']; ?>" alt="">
                            <?php endif; ?>
                            <?php echo remove_junk(first_character($recent_product['name'])); ?>
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

<!-- Stock Overview Table -->
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Stock Overview</span>
            </strong>
            <input type="text" id="searchInput" class="form-control pull-right" placeholder="Search Item..." style="width: 200px; margin-top: -5px;">
        </div>
        <div class="panel-body">
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-bordered" id="stockTable">
                    <thead>
                        <tr>
                            <th class="text-center" onclick="sortTable(0)">Item Name</th>
                            <th class="text-center">Description</th>
                            <th class="text-center" onclick="sortTable(2)">Stocks</th>
                            <th>Check-in Room</th>
                            <th>Check-in Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_products as $product): ?>
                            <tr>
                                <td><?php echo remove_junk($product['name']); ?></td>
                                <td><?php echo remove_junk($product['description']); ?></td>
                                <td class="text-center"><?php echo (int)$product['quantity']; ?></td>
                                <td><?php echo remove_junk($product['checkin_room']); ?></td>
                                <td><?php echo remove_junk($product['checkin_location']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>

<script>
// Search functionality
document.getElementById("searchInput").addEventListener("keyup", function() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("stockTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0]; // Search by Item Name
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
});

// Sort Table Function
function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("stockTable");
    switching = true;
    dir = "asc";

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];

            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }

        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}
</script>

<style>
  .pull-right {
    text-align: center;
  }
</style>
