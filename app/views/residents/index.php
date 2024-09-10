<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="\barangaymanagement\public\css\css\bootstrap.min.css">
</head>
<body>
    


<div class="container">
<!-- app/views/residents/index.php -->
<h1>Residents</h1>
<form method="get" action="index.php">
    <input type="text" name="search" placeholder="Search by name" value="<?php echo $_GET['search'] ?? ''; ?>">
    <input type="submit" value="Search">
</form>
<a href="index.php?action=create">Add New Resident</a>
<table class="table table-hover table-boredered table-stripped">
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Middle Name</th>
        <th>Gender</th>
        <th>Address</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $residents->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['last_name']; ?></td>
            <td><?php echo $row['middle_name']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td>
                <a href="index.php?action=edit&id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

</div>


</body>
</html>
