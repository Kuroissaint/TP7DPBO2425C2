<div class="section">
    <h2>🎫 Voucher Management</h2>
    
    <?php
    // Show success messages
    if (isset($_GET['success'])) {
        $messages = [
            'voucher_added' => 'Voucher added successfully!',
            'voucher_updated' => 'Voucher updated successfully!',
            'voucher_deleted' => 'Voucher deleted successfully!'
        ];
        echo '<div class="alert success">✅ ' . $messages[$_GET['success']] . '</div>';
    }
    ?>
    
    <!-- Add Voucher Form -->
    <div class="crud-form">
        <h3>Add New Voucher</h3>
        <form method="POST" action="index.php">
            <div class="form-row">
                <input type="text" name="name" placeholder="Voucher Name" required>
                <input type="text" name="description" placeholder="Description" required>
                <input type="number" name="discount" placeholder="Discount %" min="0" max="100" required>
                <button type="submit" name="add_voucher" class="btn">Add Voucher</button>
            </div>
        </form>
    </div>

    <!-- Vouchers List -->
    <div class="table-container">
        <h3>Voucher List</h3>
        <table class="crud-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Discount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $vouchers = $voucher->getAllVouchers();
                if (count($vouchers) > 0) {
                    foreach ($vouchers as $v) {
                        echo "<tr>";
                        echo "<td>{$v['id']}</td>";
                        echo "<td>{$v['name']}</td>";
                        echo "<td>{$v['description']}</td>";
                        echo "<td>{$v['discount']}%</td>";
                        echo "<td class='actions'>";
                        echo "<a href='#' onclick='editVoucher({$v['id']}, \"{$v['name']}\", \"{$v['description']}\", {$v['discount']})' class='btn-edit'>Edit</a>";
                        echo "<a href='index.php?page=vouchers&delete_voucher={$v['id']}' class='btn-delete' onclick='return confirm(\"Delete this voucher?\")'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='no-data'>No vouchers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Voucher Modal -->
    <div id="editVoucherModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Edit Voucher</h3>
            <form method="POST" action="index.php">
                <input type="hidden" name="id" id="edit_voucher_id">
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" id="edit_voucher_name" required>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <input type="text" name="description" id="edit_voucher_desc" required>
                </div>
                <div class="form-group">
                    <label>Discount:</label>
                    <input type="number" name="discount" id="edit_voucher_discount" min="0" max="100" required>
                </div>
                <button type="submit" name="update_voucher" class="btn">Update Voucher</button>
            </form>
        </div>
    </div>
</div>

<script>
function editVoucher(id, name, description, discount) {
    document.getElementById('edit_voucher_id').value = id;
    document.getElementById('edit_voucher_name').value = name;
    document.getElementById('edit_voucher_desc').value = description;
    document.getElementById('edit_voucher_discount').value = discount;
    document.getElementById('editVoucherModal').style.display = 'block';
}

// Close modal
document.querySelectorAll('.close')[1].onclick = function() {
    document.getElementById('editVoucherModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('editVoucherModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>