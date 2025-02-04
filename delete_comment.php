<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to delete comments.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if (isset($_POST['comment_id'])) {
    $comment_id = $_POST['comment_id'];
    $user_id = $_SESSION['user_id'];

   
    $sql_check = "SELECT * FROM comments WHERE id = ? AND user_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $comment_id, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
       
        $sql_delete = "DELETE FROM comments WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $comment_id);
        
        if ($stmt_delete->execute()) {
            echo "<script>alert('Comment deleted successfully!'); window.location.href='welcome.php';</script>";
        } else {
            echo "<script>alert('Error deleting comment.'); window.location.href='welcome.php';</script>";
        }
        
        $stmt_delete->close();
    } else {
        echo "<script>alert('Error: You can only delete your own comments.'); window.location.href='welcome.php';</script>";
    }

    $stmt_check->close();
}

$conn->close();
?>
