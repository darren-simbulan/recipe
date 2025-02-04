<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to save a recipe.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION["user_id"];
$title = $_POST['title'] ?? '';
$ingredients = $_POST['ingredients'] ?? '';
$instructions = $_POST['instructions'] ?? '';
$category = $_POST['category'] ?? '';

$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true); 
}

$image = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $fileName = time() . "_" . basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        $image = $targetFilePath;
    } else {
        die("Error: Image upload failed. Check folder permissions.");
    }
}

$sql = "INSERT INTO recipes (user_id, title, image, ingredients, instructions, category) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isssss", $user_id, $title, $image, $ingredients, $instructions, $category);

if ($stmt->execute()) {
    header("Location: index.php?success=true");
} else {
    die("Error saving recipe: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
