<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    <style>
       
    </style>
</head>
<body>

    <div class="header">
        <h1>Recipe Management System</h1>
    </div>

    <div class="nav">
        <a href="welcome.php">Home</a>
        <a href="index.php">View Recipes</a>
        <a href="add_recipe.php">Add Recipe</a>
        <a href="favorites.php">Favorite Recipes</a>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="container">
        <h2>Add a New Recipe</h2>
        <form action="save_recipe.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Recipe Title" required><br>
    <input type="file" name="image" accept="image/*" required><br>
    <textarea name="ingredients" placeholder="Ingredients" required></textarea><br>
    <textarea name="instructions" placeholder="Instructions" required></textarea><br>
    <select name="category">
        <option value="Dessert">Dessert</option>
        <option value="Ulam">Ulam</option>
        <option value="Snacks">Snacks</option>
        <option value="Drinks">Drinks</option>
    </select><br>
    <button type="submit">Add Recipe</button>
</form>


    </div>

</body>
</html>
