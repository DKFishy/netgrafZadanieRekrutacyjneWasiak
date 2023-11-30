<!-- resources/views/api/create.blade.php -->

<form action="{{ route('pets.store') }}" method="POST">
    @csrf

    <!-- pole tekstowe akpcetują tylko litery alfabetu, spacje, apostrofy, litery specjalne  -->
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s']+" required placeholder="Pet name">
    <label for="category">Category name:</label>
    <input type="text" id="category" name="category" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s']+" placeholder="Category name">
    
    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="available">Available</option>
        <option value="pending">Pending</option>
        <option value="sold">Sold</option>
    </select>

    <br>

    <button type="submit">Save Changes</button>
</form>