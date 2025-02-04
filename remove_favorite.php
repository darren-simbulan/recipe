<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to remove a favorite recipe.");
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


$sql = "DELETE FROM favorites WHERE user_id = ? AND recipe_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $recipe_id);

if ($stmt->execute()) {
    header("Location: favorites.php");
} else {
    die("Error removing favorite: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
