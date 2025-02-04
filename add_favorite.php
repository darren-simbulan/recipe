<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to save a favorite recipe.");
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
$recipe_id = $_POST['recipe_id'] ?? '';

if (!$recipe_id) {
    die("Error: No recipe selected.");
}

$sql_check = "SELECT * FROM favorites WHERE user_id = ? AND recipe_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $user_id, $recipe_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "<script>alert('This recipe is already in your favorites.'); window.location.href='index.php';</script>";
    exit();
}

$sql = "INSERT INTO favorites (user_id, recipe_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $recipe_id);

if ($stmt->execute()) {
    echo "<script>alert('Recipe added to your favorites!'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('Error saving favorite: " . $stmt->error . "'); window.location.href='index.php';</script>";
}

$stmt->close();
$conn->close();
?>
