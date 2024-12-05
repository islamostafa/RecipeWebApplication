<?php
//MySQL database connection details
$host = "localhost";
$database_name = "recipe_login";
$db_username = "root";
$db_password = "";

//Creates an object for the MySQL connection
$sql_object = new mysqli($host, $db_username, $db_password, $database_name);

//Checks for a database connection error. Throws an error if it can't connect
if ($sql_object->connect_errno) {
    die("Error when connecting: " . $sql_object->connect_error);
}

// Function to check if a recipe is saved for a user
function isRecipeSaved($userId, $recipeId) {
    global $sql_object;

    // Prepare and execute a query to check if the recipe is saved for the user
    $sql = "SELECT * FROM saved_recipes WHERE user_id = '$userId' AND recipe_id = '$recipeId'";
    $result = $sql_object->query($sql);

    // If the query returns any rows, it means the recipe is saved for the user
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

// Function to check if a recipe rating is saved for a user
function isRatingSaved($userId, $recipeId) {
    global $sql_object;

    // Prepare and execute a query to check if the recipe is saved for the user
    $sql = "SELECT * FROM ratings WHERE user = '$userId' AND recipe_id = '$recipeId'";
    $result = $sql_object->query($sql);

    // If the query returns any rows, it means the rating is saved for the user
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

return $sql_object;
