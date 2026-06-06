<?php
session_start(); // Start session to store cart data
include 'db_connect.php';

// --- Initialize the cart if not set ---
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// --- Handle Add to Cart ---
if (isset($_GET['add_to_cart'])) {
    $plant_id = $_GET['add_to_cart'];
    if (!in_array($plant_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $plant_id;
    }
    header("Location: index.php"); // Prevent resubmission
    exit();
}

// --- Handle Search and Filter ---
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT * FROM plants WHERE 1";

if (!empty($search)) {
    $sql .= " AND name LIKE '%" . $conn->real_escape_string($search) . "%'";
}

if (!empty($category) && $category != 'All') {
    $sql .= " AND category='" . $conn->real_escape_string($category) . "'";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Plant Paradise</title>
<style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  background: #f3f8f3;
  color: #333;
}
header {
  background: #2e7d32;
  color: white;
  text-align: center;
  padding: 1rem 0;
}
h1 {
  margin: 0;
  font-size: 2rem;
}
nav {
  background: #e8f5e9;
  padding: 0.7rem;
  text-align: center;
}
nav a {
  color: #2e7d32;
  text-decoration: none;
  font-weight: bold;
  margin: 0 10px;
}
nav a:hover {
  text-decoration: underline;
}
.search-bar {
  text-align: center;
  margin: 1.5rem 0;
}
input[type="text"], select {
  padding: 0.6rem;
  width: 200px;
  border-radius: 6px;
  border: 1px solid #aaa;
  margin-right: 0.5rem;
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
.container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1rem;
  padding: 1rem 2rem;
}
.card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  overflow: hidden;
  transition: transform 0.3s;
}
.card:hover {
  transform: translateY(-5px);
}
.card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}
.card-content {
  padding: 1rem;
}
.card-content h3 {
  margin-top: 0;
  color: #2e7d32;
}
.price {
  color: #1b5e20;
  font-weight: bold;
  margin-top: 0.5rem;
}
footer {
  text-align: center;
  padding: 1rem;
  background: #e8f5e9;
  color: #2e7d32;
  font-weight: bold;
}
</style>
</head>
<body>

<header>
  <h1>🌿 Plant Paradise</h1>
  <p>Your one-stop shop for beautiful plants</p>
</header>

<nav>
  <a href="index.php">🏠 Home</a>
  <a href="add_plant.php">➕ Add Plant</a>
  <a href="cart.php">🛒 View Cart (<?php echo count($_SESSION['cart']); ?>)</a>
</nav>

<div class="search-bar">
  <form method="GET" action="">
    <input type="text" name="search" placeholder="Search by name..." value="<?php echo htmlspecialchars($search); ?>">
    <select name="category">
      <option>All</option>
      <option <?php if($category=="Indoor") echo "selected"; ?>>Indoor</option>
      <option <?php if($category=="Outdoor") echo "selected"; ?>>Outdoor</option>
      <option <?php if($category=="Succulent") echo "selected"; ?>>Succulent</option>
      <option <?php if($category=="Flowering") echo "selected"; ?>>Flowering</option>
    </select>
    <button type="submit">Search</button>
  </form>
</div>

<div class="container">
<?php
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "
    <div class='card'>
      <img src='images/{$row['image']}' alt='{$row['name']}'>
      <div class='card-content'>
        <h3>{$row['name']}</h3>
        <p>{$row['description']}</p>
        <p class='price'>₹{$row['price']}</p>
        <a href='?add_to_cart={$row['id']}'><button>Add to Cart</button></a>
      </div>
    </div>";
  }
} else {
  echo '<p style="text-align:center;width:100%;">No matching plants found.</p>';
}

$conn->close();
?>
</div>

<footer>
  🌱 Thanks for visiting Plant Paradise
</footer>

</body>
</html>
