<?php 
    require_once '../classes/Cart.php';

    $cart = new Cart();
    $items = $cart->getItems();
    $total = $cart->getTotal();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="cart.css?v=<?= time() ?>">
</head>
<div class="container">
    <a href="../index.php" class="go-back">← Go Back</a>
    <h1>Your Cart</h1>

    <?php if (empty($items)): ?>
        <p class="empty-message">Your cart is empty.</p>
    <?php else: ?>
        <div class="items">
            <?php foreach ($items as $item): ?>
                <div class="item-card">
                    <h3><?= htmlspecialchars($item->name) ?></h3>
                    <p>$<?= $item->price ?> × <?= $item->quantity ?></p>
                    <p><strong>Total:</strong> $<?= $item->getTotalPrice() ?></p>

                    <form method="POST" action="cart-manage/remove-from-cart.php">
                        <input type="hidden" name="id" value="<?= $item->id ?>">
                        <button class="btn" type="submit">Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="clear-cart-div">
            <form method="POST" action="cart-manage/clear-cart.php">
                <button type="submit" class="btn" style="margin-top: 20px;">Clear Cart</button>
            </form>
        </div>

        <div class="cart-total">
            <h3>Cart Total: $<?= $total ?></h3>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
