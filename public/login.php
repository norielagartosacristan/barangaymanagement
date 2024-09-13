<!-- app/views/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="\barangaymanagement\assets\css\css\bootstrap.min.css">
    <link rel="stylesheet" href="\barangaymanagement\public\css\main.css">
</head>
<body>

<section id="container">
    <div id="header">
        <h1>GRS BARANGAY MANAGEMENT SYSTEM</h1>
    </div>
<div id="main">
        
        <form method="POST" action="../app/controllers/AuthController.php">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div>
                <button class="btn btn-success" type="submit">Login</button>
            </div>
        </form>
    
</div>
</section>


   

<section id="footer">
    <div>
        <p>&copy;2024 Barangay Godofredo Reyes Sr. All rights reserved</p>
        <p>Developed by: nsacristan</p>
    </div>
</section>

</body>
</html>