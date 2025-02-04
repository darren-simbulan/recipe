<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    die("Unauthorized access.");
}

$recipe_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM recipes WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $recipe_id, $user_id);
if ($stmt->execute()) {
    echo "<script>alert('Recipe deleted successfully!'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('Error deleting recipe.'); window.location.href='index.php';</script>";
}
    
$stmt->close();
$conn->close();
?>
