<?php
include 'db_connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    // Upload image to "images" folder
    $target_dir = "images/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Insert into database
    $sql = "INSERT INTO plants (name, category, price, stock, description, image)
            VALUES ('$name', '$category', '$price', '$stock', '$description', '$image')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "🌱 New plant added successfully!";
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
<title>Add Plant | Plant Paradise</title>
<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f0f7f3;
  padding: 2rem;
}
h2 {
  color: #2e7d32;
}
form {
  background: white;
  padding: 1.5rem;
  border-radius: 12px;
  max-width: 400px;
  margin: auto;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
input, textarea, select {
  width: 100%;
  margin-bottom: 1rem;
  padding: 0.5rem;
  border-radius: 5px;
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
.message {
  text-align: center;
  margin-bottom: 1rem;
  color: #1b5e20;
  font-weight: bold;
}
</style>
</head>
<body>

<h2 style="text-align:center;">Add a New Plant 🌿</h2>

<div class="message"><?php echo $message; ?></div>

<form action="" method="POST" enctype="multipart/form-data">
  <label>Plant Name:</label>
  <input type="text" name="name" required>

  <label>Category:</label>
  <select name="category">
    <option>Indoor</option>
    <option>Outdoor</option>
    <option>Succulent</option>
    <option>Flowering</option>
  </select>

  <label>Price (₹):</label>
  <input type="number" step="0.01" name="price" required>

  <label>Stock:</label>
  <input type="number" name="stock" required>

  <label>Description:</label>
  <textarea name="description" rows="3"></textarea>

  <label>Image:</label>
  <input type="file" name="image" accept="image/*" required>

  <button type="submit">Add Plant</button>
</form>

</body>
</html>
