<!-- app/views/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="\barangaymanagement\assets\css\css\bootstrap.min.css">
    <link rel="stylesheet" href="\barangaymanagement\public\css\login.css">
</head>
<body>



<div class="wrapper-main">
    <div class="left-column">
        <div class="brgytitle">
            <h1>BARANGAY GODOFREDO REYES SR.</h1>
        </div>
        <div>
            <img src="\barangaymanagement\uploads\images\grslogo.jpg" alt="Barangay Logo" class="logo-left">
        </div>
    </div>
    <div class="login-form">
        <h1 class="logindiv">Login</h1>
    <form class="form-group" method="POST" action="../app/controllers/AuthController.php">
            <div>
                <label for="username">Username:</label>
                <input class="form-control" type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input class="form-control" type="password" name="password" id="password" required>
            </div><br>
            <div>
                <button class="btn btn-success" type="submit">Login</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>