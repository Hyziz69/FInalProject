<?php
require_once '../../classes/ClothesManager.php';
$clothesManager = new ClothesManager($conn);
$womenClothes = $clothesManager->getClothesByGender('female');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Women's Collection - KAIRA</title>
  <link rel="stylesheet" href="clothes.css" />
</head>
<body>
  <main class="clothes-page">
    <a class="go-back" href="../../index.php">← Back to Home</a>
    <h1>Women's Collection</h1>
    <div class="clothes-grid">
      <?php foreach ($womenClothes as $item): ?>
        <div class="clothes-card">
          <img src="../../images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" />
          <h2><?= htmlspecialchars($item['name']) ?></h2>
          <p><?= htmlspecialchars($item['description']) ?></p>
          <span class="price">$<?= number_format($item['price'], 2) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </main>
</body>
</html>
