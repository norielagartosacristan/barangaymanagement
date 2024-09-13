<!-- app/views/residents/edit.php -->
<h1>Edit Resident</h1>
<form action="index.php?action=update&id=<?php echo $resident['id']; ?>" method="POST">
    First Name: <input type="text" name="first_name" value="<?php echo $resident['first_name']; ?>" required><br>
    Last Name: <input type="text" name="last_name" value="<?php echo $resident['last_name']; ?>" required><br>
    Middle Name: <input type="text" name="middle_name" value="<?php echo $resident['middle_name']; ?>"><br>
    Gender: 
    <select name="gender" required>
        <option value="Male" <?php if($resident['gender'] == 'Male') echo 'selected'; ?>>Male</option>
        <option value="Female" <?php if($resident['gender'] == 'Female') echo 'selected'; ?>>Female</option>
    </select><br>
    Address: <input type="text" name="address" value="<?php echo $resident['address']; ?>" required><br>
    <input type="submit" value="Update Resident">
</form>


<nav aria-label="Page navigation">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="index.php?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>