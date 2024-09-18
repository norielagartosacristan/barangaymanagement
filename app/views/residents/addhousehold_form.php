
<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\header.php'; ?>


<div class="main">
<?php include 'D:/GrsDatabase/htdocs/barangaymanagement/app/config/db.php'; ?>



    <h1>Add Family</h1>
    <form method="POST" action="add_household.php">
        <label for="householdHead">Household Head (Resident ID):</label>
        <select name="householdHead" id="householdHead" required>
            <!-- Populate this dropdown with Resident IDs from the residents table -->
            <?php
            $query = "SELECT ResidentID, CONCAT(LastName, ' ',FirstName) AS Name FROM residents";
            $result = $db->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['ResidentID']}'>{$row['Name']}</option>";
            }
            ?>
        </select>
        <br>

        <label for="number_of_members">Number of Members:</label>
        <input type="number" name="numberOfMembers" id="numberOfMembers" required>
        <br>

        <button type="submit">Add Household</button>
    </form>



<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\footer.php'; ?>