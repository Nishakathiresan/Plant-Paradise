<?php
session_start();
include 'db_connect.php';

$total = 0;
$items = [];

if (!empty($_SESSION['cart'])) {
    $ids = implode(',', $_SESSION['cart']);
    $sql = "SELECT * FROM plants WHERE id IN ($ids)";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
        $total += $row['price'];
    }
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($items)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $sql = "INSERT INTO orders (customer_name, email, address, total)
            VALUES ('$name', '$email', '$address', '$total')";

    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;
        $message = "✅ Order placed successfully! Your Order ID is #" . $order_id;
        $_SESSION['cart'] = []; // Clear cart after checkout
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout | Plant Paradise</title>
<style>
body {
  font-family: Arial, sans-serif;
  background: #f0f7f3;
  padding: 2rem;
}
h2 {
  text-align: center;
  color: #2e7d32;
}
form {
  background: white;
  padding: 1.5rem;
  border-radius: 12px;
  max-width: 500px;
  margin: 1rem auto;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
input, textarea {
  width: 100%;
  padding: 0.6rem;
  margin-bottom: 1rem;
  border-radius: 6px;
  border: 1px solid #ccc;
}
button {
  background: #43a047;
  color: white;
  border: none;
  padding: 0.6rem 1rem;
  border-radius: 5px;
  cursor: pointer;
}
button:hover {
  background: #2e7d32;
}
.total {
  text-align: center;
  font-weight: bold;
  color: #1b5e20;
}
.message {
  text-align: center;
  margin: 1rem 0;
  color: #1b5e20;
  font-weight: bold;
}
a {
  color: #2e7d32;
  text-decoration: none;
}
</style>
</head>
<body>

<h2>🪴 Checkout</h2>

<div class="message"><?php echo $message; ?></div>

<?php if (empty($items)) { ?>
  <p style="text-align:center;">Your cart is empty.</p>
  <p style="text-align:center;"><a href="index.php">← Back to Shop</a></p>
<?php } else { ?>
  <div class="total">Total: ₹<?php echo number_format($total, 2); ?></div>
  
  <form method="POST" action="">
    <label>Full Name:</label>
    <input type="text" name="name" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Address:</label>
    <textarea name="address" rows="3" required></textarea>

    <button type="submit">Place Order</button>
  </form>
  <p style="text-align:center;"><a href="cart.php">← Back to Cart</a></p>
<?php } ?>

</body>
</html>
