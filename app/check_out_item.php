<?php
$page_title = 'Check Out Items';
require_once('includes/load.php');

$all_products = find_all('products'); // Fetch all products
$all_employee = find_all('employee');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_query = "SELECT name FROM users WHERE id = '{$user_id}' LIMIT 1";
$user_result = $db->query($user_query);
$user_name = ($user_result && $db->num_rows($user_result) > 0) ? $db->fetch_assoc($user_result)['name'] : '';

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
                    <span>Check Out Items</span>
                </strong>
            </div>

            <div class="panel-body">
                <!-- Search Bar -->
                <div class="form-group">
                    <input type="text" class="form-control" id="search-items" placeholder="Search items...">
                </div>

                <!-- Scrollable Table -->
                <div style="max-height: 400px; overflow-y: auto; border: 1px solid #ddd;">
                    <table class="table table-bordered" id="items-table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Description</th>
                                <th>Stocks</th>
                                <th>Check-in Room</th>
                                <th>Check-in Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_products as $product): ?>
                                <tr class="item-row">
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo $product['description']; ?></td>
                                    <td><?php echo $product['quantity']; ?></td>
                                    <td><?php echo $product['checkin_room']; ?></td>
                                    <td><?php echo $product['checkin_location']; ?></td>
                                    <td>
                                        <button class="btn btn-success btn-sm add-item" 
                                            data-id="<?php echo $product['id']; ?>" 
                                            data-name="<?php echo $product['name']; ?>" 
                                            data-quantity="<?php echo $product['quantity']; ?>">
                                            Add
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Selected Items Table -->
            <div class="panel-footer">
                <h4>Selected Items</h4>
                <form method="post" action="checkOutItems.php">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="selected-items">
                            <!-- Selected items will be added dynamically here -->
                        </tbody>
                    </table>
                    
                    <!-- Check Out By -->
                    <div class="form-group">
                        <label for="checkout-by">Check Out By</label>
                        <select class="form-control" name="checkout-by" required>
                            <option value="">Select</option>
                            <?php foreach ($all_employee as $employee): ?>
                                <option value="<?php echo $employee['name']; ?>">
                                    <?php echo $employee['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" name="checkout" class="btn btn-primary">Check Out</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var selectedItems = {};

    // Add item to selected list
    document.querySelectorAll('.add-item').forEach(button => {
        button.addEventListener('click', function() {
            var itemId = this.getAttribute('data-id');
            var itemName = this.getAttribute('data-name');
            var stock = parseInt(this.getAttribute('data-quantity'));

            if (selectedItems[itemId]) {
                alert("Item is already added.");
                return;
            }

            var quantity = prompt(`Enter quantity for ${itemName} (Max: ${stock}):`, "1");
            if (quantity !== null) {
                quantity = parseInt(quantity);
                if (isNaN(quantity) || quantity < 1 || quantity > stock) {
                    alert("Not enough stock to check out the desired quantity.");
                    return;
                }

                selectedItems[itemId] = { name: itemName, quantity: quantity };

                var row = document.createElement('tr');
                row.innerHTML = `
                    <td>${itemName}</td>
                    <td>${quantity}</td>
                    <td><button class="btn btn-danger btn-sm remove-item" data-id="${itemId}">Remove</button></td>
                `;
                document.getElementById('selected-items').appendChild(row);

                var form = document.querySelector('form');
                form.innerHTML += `<input type="hidden" name="items[]" value="${itemId}-${quantity}">`;
            }
        });
    });

    // Remove item from selected list
    document.getElementById('selected-items').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-item')) {
            var itemId = event.target.getAttribute('data-id');
            delete selectedItems[itemId];
            event.target.closest('tr').remove();
        }
    });

    // Search functionality
    document.getElementById('search-items').addEventListener('keyup', function() {
        var searchValue = this.value.toLowerCase();
        document.querySelectorAll('.item-row').forEach(row => {
            var itemName = row.cells[0].textContent.toLowerCase();
            var description = row.cells[1].textContent.toLowerCase();
            if (itemName.includes(searchValue) || description.includes(searchValue)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
});
</script>

<?php include_once('layouts/footer.php'); ?>
