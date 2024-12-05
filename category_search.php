<?php
session_start();

// Function to establish a database connection
function connectToDatabase()
{
    $host = 'localhost';
    $dbname = 'recipe_login';
    $db_username = 'root';
    $db_password = 'root';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_username, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Connection failed: " . $e->getMessage();
        die();
    }
}

if (isset($_GET['category']) && $_GET['category'] != '') {
    $pdo = connectToDatabase();
    $category = $_GET['category'];

    echo "<h2>Recipe(s) in the " . htmlspecialchars($category) . " category </h2><hr>";

    $recipe_sql = "SELECT recipe_id FROM recipe_categories WHERE Category = :category";
    $recipe_stmt = $pdo->prepare($recipe_sql);
    $recipe_stmt->bindParam(":category", $category, PDO::PARAM_STR);
    $recipe_stmt->execute();

    $recipe_result = $recipe_stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($recipe_result) {
        foreach ($recipe_result as $row) {
            echo "Recipe ID: " . $row["recipe_id"] . "<br>";

            // Fetch category details
            $category_sql = "SELECT Category FROM recipe_categories WHERE recipe_id = :recipe_id";
            $category_stmt = $pdo->prepare($category_sql);
            $category_stmt->bindParam(":recipe_id", $row["recipe_id"], PDO::PARAM_INT);
            $category_stmt->execute();

            $category_result = $category_stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($category_result) {
                echo "Categories: ";
                $categories = array();
                foreach ($category_result as $category_row) {
                    $categories[] = $category_row['Category'];
                }
                echo implode(", ", $categories); // use implode to join with a comma and space
                echo "<br>";
            } else {
                echo "No categories found for this recipe id.<br><br>";
            }

            // Fetch recipe name, description, prep_time, cook_time and rating
            $details_sql = "SELECT * FROM recipes WHERE recipe_id = :recipe_id";
            $details_stmt = $pdo->prepare($details_sql);
            $details_stmt->bindParam(":recipe_id", $row["recipe_id"], PDO::PARAM_INT);
            $details_stmt->execute();

            $details_result = $details_stmt->fetch(PDO::FETCH_ASSOC);
            if ($details_result) {
                foreach ($details_result as $column_name => $column_value) {
                    if ($column_name != 'recipe_id') {
                        if ($column_name == 'Name') {
                            echo "<h3>" . $column_value . "</h3>";
                        } else {
                            echo $column_name . ": " . $column_value . "<br>";
                        }
                    }
                }
            } else {
                echo "No details found for this recipe id.<br>";
            }

            // Fetch recipe ingredients
            $ingredient_sql = "SELECT * FROM recipe_ingredients WHERE recipe_id = :recipe_id";
            $ingredient_stmt = $pdo->prepare($ingredient_sql);
            $ingredient_stmt->bindParam(":recipe_id", $row["recipe_id"], PDO::PARAM_INT);
            $ingredient_stmt->execute();

            $ingredient_result = $ingredient_stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($ingredient_result) {
                echo "<h4>Ingredients:</h4>";
                foreach ($ingredient_result as $ingredient_row) {
                    unset($ingredient_row['recipe_id']); // remove recipe_id
                    echo implode(", ", $ingredient_row) . "<br>";
                }
            } else {
                echo "No ingredients found for this recipe id.<br>";
            }

            // Fetch recipe steps
            $step_sql = "SELECT * FROM recipe_steps WHERE recipe_id = :recipe_id";
            $step_stmt = $pdo->prepare($step_sql);
            $step_stmt->bindParam(":recipe_id", $row["recipe_id"], PDO::PARAM_INT);
            $step_stmt->execute();

            $step_result = $step_stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($step_result) {
                echo "<h4>Steps:</h4>";
                foreach ($step_result as $step_row) {
                    unset($step_row['recipe_id']); // remove recipe_id
                    echo implode(", ", $step_row) . "<br>";
                }
            } else {
                echo "No steps found for this recipe id.<br>";
            }

            echo "<br><hr>";
        }
    } else {
        echo "No recipes found for this category.";
    }
}
echo '<button onclick="goBack()">Go Back</button>';

// Include a script to handle the button click
?>
<script>
function goBack() {
    window.location.href = window.location.origin + '/recipe_webapp-main/';
}
</script>