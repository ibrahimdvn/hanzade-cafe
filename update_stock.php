<?php
include 'db_connect.php';

// Validate id from query string
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    http_response_code(400);
    die("Invalid product id.");
}
$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read sold quantity
    $sold_quantity = isset($_POST['sold_quantity']) ? (int)$_POST['sold_quantity'] : 0;

    if ($sold_quantity <= 0) {
        $error = "Sold quantity must be a positive number.";
    } else {
        // Atomic update: subtract only if current stock >= sold quantity
        $stmt = $conn->prepare("
            UPDATE products
            SET stock_quantity = stock_quantity - ?
            WHERE id = ? AND stock_quantity >= ?
        ");
        $stmt->bind_param("iii", $sold_quantity, $id, $sold_quantity);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            // Success: redirect back to list
            header("Location: index.php");
            exit;
        } else {
            // Either not enough stock or invalid id
            $error = "Not enough stock (or invalid product).";
        }
    }
}

// Fetch product name for header
$stmt = $conn->prepare("SELECT product_name, stock_quantity FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
if (!$product) {
    http_response_code(404);
    die("Product not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Update Stock - Hanzade Cafe</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
  body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; padding: 24px; }
  form { max-width: 420px; display: grid; gap: 12px; }
  input[type=number] { padding: 8px; }
  button { padding: 10px 12px; border: 1px solid #333; border-radius: 6px; cursor: pointer; }
  .error { color: #b00020; margin-bottom: 10px; }
</style>
</head>
<body>
  <h1>Reduce Stock — <?php echo htmlspecialchars($product['product_name']); ?></h1>
  <p>Current stock: <strong><?php echo (int)$product['stock_quantity']; ?></strong></p>

  <?php if (!empty($error)): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="post" novalidate>
    <label for="sold_quantity">Quantity Sold:</label>
    <input id="sold_quantity" name="sold_quantity" type="number" min="1" required />
    <button type="submit">Update</button>
  </form>

  <p><a href="index.php">← Back to Stock List</a></p>
</body>
</html>
