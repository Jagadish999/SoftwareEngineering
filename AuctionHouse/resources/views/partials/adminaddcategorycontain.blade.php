<div class="main-page-contains">
    <h1>Create a New Category</h1>

    <form id="categoryForm" method="POST" action="{{ route('create-category') }}">

        @csrf
        <div class="category-row">
            <label for="categoryName" class="category-label">Category Name:</label>
            <input type="text" id="categoryName" name="categoryName" class="category-input" placeholder="Enter Category Name" required="">
        </div>

        <!-- Default Property -->
        <div class="category-property">
            <input type="text" class="category-property-input" name="propertyNames[]" placeholder="Property Name" required="">
            <select class="category-property-select" name="datatypes[]" required="">
                <option value="number">Number</option>
                <option value="text">Text</option>
                <option value="largeText">Large Text</option>
            </select>
        </div>

        <div class="category-row">
            <button type="button" id="addProperty" class="add-button">Add</button>
        </div>

        <!--For Additional Property-->
        <div id="categoryProperties">

        </div>

        <input type="submit" value="Submit">

    </form>

</div>