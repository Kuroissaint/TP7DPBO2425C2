<div class="section">
    <h2>🧪 Product Management</h2>
    
    <?php
    // Show success messages
    if (isset($_GET['success'])) {
        $messages = [
            'product_added' => 'Product added successfully!',
            'product_updated' => 'Product updated successfully!',
            'product_deleted' => 'Product deleted successfully!'
        ];
        echo '<div class="alert success">✅ ' . $messages[$_GET['success']] . '</div>';
    }
    ?>
    
    <!-- Add Product Form -->
    <div class="crud-form">
        <h3>Add New Product</h3>
        <form method="POST" action="index.php">
            <div class="form-row">
                <input type="text" name="name" placeholder="Product Name" required>
                <input type="text" name="effect" placeholder="Effect" required>
                <input type="number" name="price" placeholder="Price" min="0" required>
                <input type="number" name="stock" placeholder="Stock" min="0" required>
                <button type="submit" name="add_product" class="btn">Add Product</button>
            </div>
        </form>
    </div>

    <!-- Products List -->
    <div class="table-container">
        <h3>Product List</h3>
        <table class="crud-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Effect</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $products = $product->getAllProducts();
                if (count($products) > 0) {
                    foreach ($products as $p) {
                        echo "<tr>";
                        echo "<td>{$p['id']}</td>";
                        echo "<td>{$p['name']}</td>";
                        echo "<td>{$p['effect']}</td>";
                        echo "<td>{$p['price']} Gold</td>";
                        echo "<td>{$p['stock']}</td>";
                        echo "<td class='actions'>";
                        echo "<a href='#' onclick='editProduct({$p['id']}, \"{$p['name']}\", \"{$p['effect']}\", {$p['price']}, {$p['stock']})' class='btn-edit'>Edit</a>";
                        echo "<a href='index.php?page=products&delete_product={$p['id']}' class='btn-delete' onclick='return confirm(\"Delete this product?\")'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='no-data'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Product Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Edit Product</h3>
            <form method="POST" action="index.php">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" id="edit_name" required>
                </div>
                <div class="form-group">
                    <label>Effect:</label>
                    <input type="text" name="effect" id="edit_effect" required>
                </div>
                <div class="form-group">
                    <label>Price:</label>
                    <input type="number" name="price" id="edit_price" min="0" required>
                </div>
                <div class="form-group">
                    <label>Stock:</label>
                    <input type="number" name="stock" id="edit_stock" min="0" required>
                </div>
                <button type="submit" name="update_product" class="btn">Update Product</button>
            </form>
        </div>
    </div>
</div>

<script>
function editProduct(id, name, effect, price, stock) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_effect').value = effect;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_stock').value = stock;
    document.getElementById('editModal').style.display = 'block';
}

// Close modal
document.querySelector('.close').onclick = function() {
    document.getElementById('editModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>