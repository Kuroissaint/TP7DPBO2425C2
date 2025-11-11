<div class="dashboard">
    <h2>Market Overview</h2>
    
    <div class="stats">
        <div class="stat-card">
            <h3>Total Products</h3>
            <p><?php echo count($product->getAllProducts()); ?></p>
        </div>
        
        <div class="stat-card">
            <h3>Available Vouchers</h3>
            <p><?php echo count($voucher->getAllVouchers()); ?></p>
        </div>
        
        <div class="stat-card">
            <h3>Total Transactions</h3>
            <p><?php echo count($transaction->getAllTransactions()); ?></p>
        </div>
    </div>
    
    <div class="quick-actions">
        <h3>Quick Actions</h3>
        <div class="action-buttons">
            <a href="?page=transactions" class="btn">Make Purchase</a>
            <a href="?page=products" class="btn">View Products</a>
            <a href="?page=vouchers" class="btn">View Vouchers</a>
        </div>
    </div>
</div>