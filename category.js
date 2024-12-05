// Populate category select options
const categorySelect = document.getElementById('categorySelect');
fetch('/getCategories') // new endpoint which returns all categories
  .then(response => response.json())
  .then(data => {
    data.forEach(category => {
      const option = document.createElement('option');
      option.value = category;
      option.text = category;
      categorySelect.appendChild(option);
    });
  });

document.getElementById('recipeForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the form from submitting normally
  const keyword = document.getElementById('categorySelect').value;
  searchRecipes(keyword, 'category');
});

async function searchRecipes(keyword, type) {
  let results;
  try {
    const response = await fetch(`/search?${type}=${keyword}`);
    results = await response.json();
  } catch (error) {
    console.error('An error occurred:', error);
    return;
  }

  displayResults(results);
}

function displayResults(results) {
    const recipeContainer = document.getElementById('recipeContainer'); 
    recipeContainer.innerHTML = ''; // Clear previous search results
  
    // Checking if there are results and displaying them, otherwise show 'No recipes found'.
    if (results.length > 0) {
      // Sorting results by recipe ID then by step number.
      results.sort((a, b) => a.recipe_id - b.recipe_id || a.Step_number - b.Step_number);
  
      // Grouping results by recipe ID.
      let groupedResults = results.reduce((acc, curr) => {
        if(!acc[curr.recipe_id]) {
          acc[curr.recipe_id] = {
            Name: curr.Name,
            Description: curr.Description,
            Prep_time: curr.Prep_time,
            Cook_time: curr.Cook_time,
            Rating: curr.Rating,
            Ingredients: curr.Ingredients,
            Categories: curr.Categories,
            Steps: []
          };
        }
        acc[curr.recipe_id].Steps.push(`${curr.Step_number}. ${curr.Step_Description}`);
        return acc;
      }, {});
  
      // Converting the object back to an array of recipes and sorting it by recipe name.
      let finalResults = Object.values(groupedResults).sort((a, b) => a.Name.localeCompare(b.Name));
  
      finalResults.forEach(recipe => {
        const recipeElement = document.createElement('div'); // Creating new div for each recipe.
        // Adding the details of the recipe to the div.
        recipeElement.innerHTML = `
          <h2>${recipe.Name}</h2>
          <h3>Categories</h3>
          <p>${recipe.Categories}</p>
          <h3>Description</h3>
          <p>${recipe.Description}</p>
          <h3>Preparation Time</h3>
          <p>${recipe.Prep_time}</p>
          <h3>Cooking Time</h3>
          <p>${recipe.Cook_time}</p>
          <h3>Rating</h3>
          <p>${recipe.Rating}</p>
          <h3>Ingredients</h3>
          <p>${recipe.Ingredients.split(',').join('<br/>')}</p>
          <h3>Steps</h3>
          <p>${recipe.Steps.join('<br/>')}</p>
          <hr>
         `;
        recipeContainer.appendChild(recipeElement); // Adding the div to the recipeContainer.
      });
    } else {
      recipeContainer.innerText = 'No recipes found.';
    }
  }  

function updateSearchInput(value) {  // This function is used to toggle the visibility of the search input and category select based on the search type selected by the user.
    const searchInput = document.getElementById('searchInput');
    const categorySelect = document.getElementById('categorySelect');
    if (value === 'category') {
        // If the selected search type is 'category', hide the search input and show the category select.
        searchInput.style.display = 'none';
        categorySelect.style.display = '';
    } else {
        // If the selected search type is not 'category', show the search input and hide the category select.
        searchInput.style.display = '';
        categorySelect.style.display = 'none';
    }
}
// Initially calling the function to set the visibility of the search input and category select based on the initially selected search type.
updateSearchInput(document.getElementById('searchType').value);
