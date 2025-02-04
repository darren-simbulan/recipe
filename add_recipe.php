<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION["user_id"];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_recipe'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $date_added = date('Y-m-d H:i:s');

    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_path = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
        $image = $image_path;
    }

    $insert_sql = "INSERT INTO recipes (title, category, ingredients, instructions, image, user_id, date_added) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("sssssis", $title, $category, $ingredients, $instructions, $image, $user_id, $date_added);
    
    if ($insert_stmt->execute()) {
        $message = "Recipe added successfully!";
    } else {
        $message = "Error adding recipe.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }
        .header {
            background-color: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
        }
        .nav {
            background-color: #343a40;
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }
        .nav a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            transition: 0.3s;
        }
        .nav a:hover {
            background-color: #495057;
            border-radius: 5px;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        textarea {
            height: 100px;
            resize: none;
        }
        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            color: green;
            margin-bottom: 10px;
        }
        .btn-logout {
    background-color: #dc3545; 
    padding: 10px 15px;
    border-radius: 5px;
    color: white;
    text-align: center;
    transition: background-color 0.3s;
}

.btn-logout:hover {
    background-color: #c82333;
}

    </style>
</head>
<body>

    <div class="header">Recipe Management System</div>
    
    <div class="nav">
        <a href="welcome.php">Home</a>
        <a href="index.php">View Recipes</a>
        <a href="add_recipe.php">Add Recipe</a>
        <a href="favorites.php">Favorite Recipes</a>
        <a href="about.php">About Us</a>
       
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="container">
        <h2>Add New Recipe</h2>
        <?php if ($message): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Recipe Title</label>
                <input type="text" id="title" name="title" placeholder="Enter recipe title" required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="">Select a category</option>
                    <option value="Dessert">Dessert</option>
                    <option value="Ulam">Ulam</option>
                    <option value="Snacks">Snacks</option>
                    <option value="Drinks">Drinks</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ingredients">Ingredients</label>
                <textarea id="ingredients" name="ingredients" placeholder="List ingredients" required></textarea>
            </div>

            <div class="form-group">
                <label for="instructions">Instructions</label>
                <textarea id="instructions" name="instructions" placeholder="Write cooking instructions" required></textarea>
            </div>

            <div class="form-group">
                <label for="image">Recipe Image</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            <button type="submit" name="add_recipe">Add Recipe</button>
        </form>
    </div>

</body>
</html>

<?php
$conn->close();
?>
