<?php
session_start();
include 'db_connect.php';

// Remove an item
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    if (($key = array_search($id, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }
    header("Location: cart.php");
    exit();
}

// Fetch items in the cart
$items = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', $_SESSION['cart']);
    $sql = "SELECT * FROM plants WHERE id IN ($ids)";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
        $total += $row['price'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Your Cart | Plant Paradise</title>
<style>
body {
  font-family: Arial, sans-serif;
  background: #f0f7f3;
  padding: 2rem;
}
h2 {
  color: #2e7d32;
  text-align: center;
}
.cart-item {
  background: white;
  border-radius: 10px;
  padding: 1rem;
  margin: 1rem auto;
  max-width: 500px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
button {
  background: #e53935;
  color: white;
  border: none;
  padding: 0.4rem 0.8rem;
  border-radius: 5px;
  cursor: pointer;
}
button:hover {
  background: #b71c1c;
}
.total {
  text-align: center;
  font-weight: bold;
  color: #1b5e20;
  margin-top: 1.5rem;
}
a {
  color: #2e7d32;
  text-decoration: none;
}
</style>
</head>
<body>

<h2>🛒 Your Shopping Cart</h2>

<?php if (empty($items)) { ?>
  <p style="text-align:center;">Your cart is empty!</p>
  <p style="text-align:center;"><a href="index.php">← Continue Shopping</a></p>
<?php } else { ?>
  <?php foreach ($items as $item) { ?>
    <div class="cart-item">
      <span><?php echo $item['name']; ?> (₹<?php echo $item['price']; ?>)</span>
      <a href="?remove=<?php echo $item['id']; ?>"><button>Remove</button></a>
    </div>
  <?php } ?>
  <div class="total">Total: ₹<?php echo number_format($total, 2); ?></div>
  <p style="text-align:center;"><a href="index.php">← Continue Shopping</a></p>
<?php } ?>
<p style="text-align:center;">
  <a href="checkout.php"><button style='background:#43a047;'>Proceed to Checkout</button></a>
</p>


</body>
</html>
