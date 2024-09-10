<!-- app/views/residents/add.php -->
<h1>Add Resident</h1>
<form action="index.php?action=store" method="POST">
    First Name: <input type="text" name="first_name" required><br>
    Last Name: <input type="text" name="last_name" required><br>
    Middle Name: <input type="text" name="middle_name"><br>
    Gender: 
    <select name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select><br>
    Address: <input type="text" name="address" required><br>
    <input type="submit" value="Add Resident">
</form>
