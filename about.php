<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
        .nav {
            background-color: #333;
            overflow: hidden;
            padding: 10px 0;
            text-align: center;
        }
        .nav a {
            display: inline-block;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
        }
        .nav a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>About Us</h1>
    </div>
    
    <div class="nav">
        <a href="welcome.php">Home</a>
        <a href="index.php">View Recipes</a>
        <a href="add_recipe.php">Add Recipe</a>
        <a href="favorites.php">Favorite Recipes</a>
        <a href="about.php">About Us</a>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
    
    <div class="container">
        <h2>Welcome to Recipe Management System</h2>
        <p>We are passionate about bringing food lovers together through the power of cooking and sharing delicious recipes.</p>
        <p>Our mission is to create a space where anyone, from home cooks to professional chefs, can share their recipes and find inspiration from others.</p>
        <p>Join our community and start sharing your favorite dishes today!</p>
    </div>
</body>
</html>
