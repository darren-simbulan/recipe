<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to react.");
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
$recipe_id = $_POST['recipe_id'];
$reaction = $_POST['reaction'];


$sql_delete = "DELETE FROM reactions WHERE user_id = ? AND recipe_id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("ii", $user_id, $recipe_id);
$stmt_delete->execute();

$sql_insert = "INSERT INTO reactions (user_id, recipe_id, reaction_type) VALUES (?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("iis", $user_id, $recipe_id, $reaction);

if ($stmt_insert->execute()) {
    echo "Reaction added!";
} else {
    echo "Error adding reaction.";
}

$stmt_insert->close();
$conn->close();
?>
