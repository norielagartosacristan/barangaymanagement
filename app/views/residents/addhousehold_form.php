
<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\header.php'; ?>
<?php include 'D:/GrsDatabase/htdocs/barangaymanagement/app/config/db.php'; ?>


<div class="main">

<div class="household-wrapper">
<h1>Add Household</h1><br>
    <form method="POST" action="add_household.php">
        <label for="householdHead">Household Head (Resident ID):</label><br>
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

        <label for="number_of_members">Number of Members:</label><br><br>
        <input class="form-group" type="number" name="numberOfMembers" id="numberOfMembers" required>
        <br>
        <label for="number_of_members">Number of Members:</label><br><br>
        <input class="form-group" type="number" name="numberOfMembers" id="numberOfMembers" required>
        
        <button class="btn btn-info" type="submit">Add Household</button>
    </form>
</div>

<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\footer.php'; ?>