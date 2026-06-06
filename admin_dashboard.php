<?php
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard | Plant Paradise</title>
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
table {
  border-collapse: collapse;
  width: 100%;
  background: white;
  margin-top: 1rem;
  border-radius: 10px;
  overflow: hidden;
}
th, td {
  padding: 0.8rem;
  text-align: left;
  border-bottom: 1px solid #ddd;
}
th {
  background: #2e7d32;
  color: white;
}
tr:hover {
  background: #f1f8f1;
}
a {
  color: #2e7d32;
  text-decoration: none;
}
a:hover {
  text-decoration: underline;
}
nav {
  text-align: center;
  margin-bottom: 1rem;
}
nav a {
  margin: 0 10px;
  font-weight: bold;
}
</style>
</head>
<body>

<h2>🌿 Admin Dashboard</h2>

<nav>
  <a href="manage_plants.php">Manage Plants</a> |
  <a href="admin_dashboard.php">View Orders</a> |
  <a href="index.php">Back to Shop</a>
</nav>

<h3>🧾 Customer Orders</h3>

<table>
<tr>
  <th>ID</th>
  <th>Customer Name</th>
  <th>Email</th>
  <th>Address</th>
  <th>Total (₹)</th>
  <th>Order Date</th>
</tr>

<?php
$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>
      <td>{$row['id']}</td>
      <td>{$row['customer_name']}</td>
      <td>{$row['email']}</td>
      <td>{$row['address']}</td>
      <td>{$row['total']}</td>
      <td>{$row['order_date']}</td>
    </tr>";
  }
} else {
  echo "<tr><td colspan='6' style='text-align:center;'>No orders yet.</td></tr>";
}

$conn->close();
?>
</table>

</body>
</html>
