<?php
/*
Mathew Boullier
Made to show our orders.
*/
$orders = pdo($pdo, 
    "SELECT * FROM orders WHERE USER_ID = ? ORDER BY CREATED_AT DESC", 
    [$_SESSION['user_id']]
)->fetchAll();
?>

<h2>Order History</h2>

<?php if (empty($orders)): ?>
    <p>You haven't placed any orders yet.</p>
<?php else: ?>
    <?php foreach ($orders as $order): ?>
        <?php
        $items = pdo($pdo,
            "SELECT oi.PRICE_CHARGED, s.NAME 
             FROM order_items oi 
             JOIN services s ON oi.SERVICE_ID = s.SERVICE_ID 
             WHERE oi.ORDER_ID = ?",
            [$order['ORDER_ID']]
        )->fetchAll();
        ?>

        <div class="order-card">
            <div class="order-header">
                <span>Order #<?= $order['ORDER_ID'] ?></span>
                <span><?= date('M j, Y', strtotime($order['CREATED_AT'])) ?></span>
                <span class="order-status"><?= ucfirst($order['ORDER_STATUS']) ?></span>
            </div>

            <ul class="order-items">
                <?php foreach ($items as $item): ?>
                    <li>
                        <?= htmlspecialchars($item['NAME']) ?>
                        <span>$<?= number_format($item['PRICE_CHARGED'], 2) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="order-total">
                Total: <strong>$<?= number_format($order['TOTAL'], 2) ?></strong>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>