<div class="section">
    <h2>🛒 Make a Purchase</h2>
    <form method="POST" action="index.php" class="purchase-form">
        <input type="hidden" name="purchase" value="1">
        
        <div class="form-group">
            <label for="product_id">Select Product:</label>
            <select name="product_id" id="product_id" required>
                <option value="">-- Choose Potion --</option>
                <?php
                $products = $product->getAllProducts();
                foreach ($products as $p) {
                    $disabled = $p['stock'] <= 0 ? 'disabled' : '';
                    echo "<option value='{$p['id']}' {$disabled}>{$p['name']} - {$p['price']} Gold (Stock: {$p['stock']})</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" value="1" required>
        </div>
        
        <div class="form-group">
            <label for="voucher_id">Select Voucher:</label>
            <select name="voucher_id" id="voucher_id" required>
                <option value="">-- Choose Voucher --</option>
                <?php
                $vouchers = $voucher->getAllVouchers();
                foreach ($vouchers as $v) {
                    echo "<option value='{$v['id']}'>{$v['name']} - {$v['discount']}% Discount</option>";
                }
                ?>
            </select>
        </div>
        
        <button type="submit" class="btn">Purchase Now</button>
    </form>
</div>

<div class="section">
    <h2>📊 Transaction History</h2>
    
    <?php
    // Show success/error message
    if (isset($_GET['success'])) {
        echo '<div class="alert success">🎉 Purchase successful!</div>';
    } elseif (isset($_GET['error'])) {
        echo '<div class="alert error">❌ Purchase failed! Check product stock.</div>';
    }
    ?>

    <!-- Sorting Options untuk Transactions -->
    <div class="sorting-options">
        <div class="sort-buttons">
            <a href="?page=transactions&sort=desc" class="btn-sort <?php echo (!isset($_GET['sort']) || $_GET['sort'] == 'desc') ? 'active' : ''; ?>">Newest First</a>
            <a href="?page=transactions&sort=asc" class="btn-sort <?php echo isset($_GET['sort']) && $_GET['sort'] == 'asc' ? 'active' : ''; ?>">Oldest First</a>
        </div>
    </div>
    
    <!-- Transactions Table -->
    <div class="table-container">
        <table class="crud-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date & Time</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Voucher</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Determine sorting for transactions
                $sortOrder = isset($_GET['sort']) && $_GET['sort'] == 'asc' ? 'ASC' : 'DESC';
                
                // Get transactions dengan sorting menggunakan method baru
                $transactions = $transaction->getTransactionsWithSort($sortOrder);

                if (count($transactions) > 0) {
                    foreach ($transactions as $t) {
                        $formattedDateTime = $transaction->formatDateTime($t['buying_date']);
                        $formattedDate = $transaction->formatDateOnly($t['buying_date']);
                        $formattedTime = $transaction->formatTimeOnly($t['buying_date']);
                        
                        echo "<tr>";
                        echo "<td>{$t['id']}</td>";
                        echo "<td>";
                        echo "<div><strong>{$formattedDate}</strong></div>";
                        echo "<div style='font-size: 0.85em; color: #666;'>🕒 {$formattedTime}</div>";
                        echo "</td>";
                        echo "<td>{$t['product_name']}</td>";
                        echo "<td>{$t['quantity']}</td>";
                        echo "<td>{$t['voucher_name']}</td>";
                        echo "<td><strong class='price'>{$t['total_price']} Gold</strong></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='no-data'>📝 No transactions yet. Make your first purchase above!</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>