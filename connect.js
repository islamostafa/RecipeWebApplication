const mysql2 = require("mysql2");
const express = require("express");
const cors = require('cors');
const path = require('path');

const PORT = process.env.PORT || 3000;

// Create an instance of express
const app = express();

// Use CORS middleware
app.use(cors());

// Serve your static files
app.use(express.static(path.join(__dirname, '${directory_name}')));

// Set express to use json data formatting
app.use(express.json());

// Connection to local MySQL database
const connection = mysql2.createConnection({
    host: 'localhost',
    user: '<username>', // input mySQL username here
    password: '<password>', // input mySQL password here
    database: 'recipe_login' // input database name here
});

// Sets up a connection to the database and runs the app on localhost.
app.listen(PORT, () => {
    console.log(`SERVER : http://localhost:${PORT}`);
    connection.connect((err) => {
        if (err) {
            throw err;
        }
        console.log("Successfully connected to database");
    });
});

app.get('/search', (req, res) => {
    const { category } = req.query;

    if (category) {
        let query = `
            SELECT DISTINCT recipes.recipe_id
            FROM recipes 
            LEFT JOIN recipe_categories ON recipes.recipe_id = recipe_categories.recipe_id 
            WHERE recipe_categories.Category LIKE ?`;

        connection.query(query, ['%' + category + '%'], function (err, results) {
            if (err) throw err;

            const recipeIds = results.map(result => result.recipe_id);

            if (recipeIds.length > 0) {
                let detailedQuery = `
                    SELECT recipes.recipe_id, recipes.Name, recipes.Description, recipes.Prep_time, recipes.Cook_time, recipes.Rating,
                        GROUP_CONCAT(DISTINCT CONCAT(recipe_ingredients.Ingredient, ': ', recipe_ingredients.Quantity)) as Ingredients,
                        GROUP_CONCAT(DISTINCT recipe_categories.Category) as Categories,
                        recipe_steps.Step_number, recipe_steps.Description as Step_Description
                    FROM recipes 
                    LEFT JOIN recipe_ingredients ON recipes.recipe_id = recipe_ingredients.recipe_id 
                    LEFT JOIN recipe_categories ON recipes.recipe_id = recipe_categories.recipe_id 
                    LEFT JOIN recipe_steps ON recipes.recipe_id = recipe_steps.recipe_id 
                    WHERE recipes.recipe_id IN (?) 
                    GROUP BY recipes.recipe_id, recipes.Name, recipes.Description, recipes.Prep_time, recipes.Cook_time, recipes.Rating, recipe_steps.Step_number, recipe_steps.Description`;

                connection.query(detailedQuery, [recipeIds], function(err, detailedResults) {
                    if (err) throw err;
                    console.log(detailedResults);
                    res.json(detailedResults);
                });
            } else {
                res.json([]);
            }
        });
    } else {
        res.status(400).json({ error: "Bad request" });
    }
});

app.get('/getCategories', (req, res) => {
    let query = `
        SELECT DISTINCT Category
        FROM recipe_categories`;

    connection.query(query, function(err, results) {
        if (err) throw err;

        // Mapping the results to return an array of strings (categories) instead of an array of objects
        const categories = results.map(result => result.Category);
        res.json(categories);
    });
});
