<?php
include 'db_connect.php';

// Delete a plant
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM plants WHERE id=$id");
    header("Location: manage_plants.php");
    exit();
}

$result = $conn->query("SELECT * FROM plants");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Plants | Admin Panel</title>
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
  border-bottom: 1px solid #ddd;
}
th {
  background: #2e7d32;
  color: white;
}
tr:hover {
  background: #f1f8f1;
}
a, button {
  color: white;
  text-decoration: none;
  background: #43a047;
  padding: 5px 10px;
  border-radius: 5px;
}
button {
  border: none;
  cursor: pointer;
}
.delete {
  background: #e53935;
}
.delete:hover {
  background: #b71c1c;
}
.edit:hover {
  background: #1b5e20;
}
nav {
  text-align: center;
  margin-bottom: 1rem;
}
nav a {
  margin: 0 10px;
  font-weight: bold;
  color: #2e7d32;
}
</style>
</head>
<body>

<h2>🪴 Manage Plants</h2>

<nav>
  <a href="admin_dashboard.php">View Orders</a> |
  <a href="add_plant.php">Add New Plant</a> |
  <a href="index.php">Back to Shop</a>
</nav>

<table>
<tr>
  <th>ID</th>
  <th>Name</th>
  <th>Category</th>
  <th>Price (₹)</th>
  <th>Stock</th>
  <th>Actions</th>
</tr>

<?php
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>
      <td>{$row['id']}</td>
      <td>{$row['name']}</td>
      <td>{$row['category']}</td>
      <td>{$row['price']}</td>
      <td>{$row['stock']}</td>
      <td>
        <a href='edit_plant.php?id={$row['id']}' class='edit'>Edit</a>
        <a href='?delete={$row['id']}' class='delete' onclick='return confirm(\"Delete this plant?\")'>Delete</a>
      </td>
    </tr>";
  }
} else {
  echo "<tr><td colspan='6' style='text-align:center;'>No plants found.</td></tr>";
}
$conn->close();
?>
</table>

</body>
</html>
