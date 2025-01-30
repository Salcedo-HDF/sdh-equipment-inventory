<?php
$page_title = 'Admin Home Page';
require_once('includes/load.php');

// Check user level
page_require_level(1);

$c_categorie     = count_by_id('categories');
$c_product       = count_by_id('products');
$c_user          = count_by_id('users');
$recent_products = find_recent_product_added(5);

// Fetch all products with stock details
$all_products = find_all('products');
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
                    <h2 class="margin-top"><?php echo $c_user['total']; ?></h2>
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
                    <h2 class="margin-top"><?php echo $c_categorie['total']; ?></h2>
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
                    <h2 class="margin-top"><?php echo $c_product['total']; ?></h2>
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
                            <th>Item Name</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Stocks</th>
                            <th class="text-center">Check-in Room</th>
                            <th class="text-center">Check-in Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_products as $product): ?>
                            <tr>
                                <td><?php echo remove_junk($product['name']); ?></td>
                                <td><?php echo remove_junk($product['description']); ?></td>
                                <td><?php echo (int)$product['quantity']; ?></td>
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

<style>
/* Center-align numbers in panels */
.pull-right {
    text-align: center;
}

/* Scrollable Table */
.table-responsive {
    border: 1px solid #ddd;
}

/* Search Bar Styling */
#searchInput {
    float: right;
}
</style>

<script>
// Search functionality for Stock Table
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
</script>
