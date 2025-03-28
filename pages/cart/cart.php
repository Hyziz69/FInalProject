<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>

<div class="container">
    
    <h1>Your Cart</h1>

    <!-- Cart is Empty Message -->
    <p class="empty-message">Your cart is empty.</p>
    <a href="../../index.php" class="go-back">← Go Back</a>
    <!-- Cart Items -->

    <div class="items">
        <div class="item-card">
            <img src="product1.jpg" alt="Leather Jacket">
            <h3>Leather Jacket</h3>
            <p>$99.99 × 1</p>
            <p><strong>Total:</strong> $99.99</p>
            <button class="btn">Remove</button>
        </div>

        <div class="item-card">
            <img src="product2.jpg" alt="Casual Shirt">
            <h3>Casual Shirt</h3>
            <p>$49.99 × 2</p>
            <p><strong>Total:</strong> $99.98</p>
            <button class="btn">Remove</button>
        </div>

        <div class="item-card">
            <img src="product3.jpg" alt="Sneakers">
            <h3>Sneakers</h3>
            <p>$69.99 × 1</p>
            <p><strong>Total:</strong> $69.99</p>
            <button class="btn">Remove</button>
        </div>
    </div>

    <div class="clear-cart-div">
        <button class="btn" style="margin-top: 20px; display: block; text-align: center;">Clear Cart</button>
    </div>
</div>

</body>
</html>
