<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration & File Upload</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        <form action="/backend/reg.php" method="POST">
            <input type="text" name="name" placeholder="First Name" required>
            <input type="text" name="surname" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="date" name="dob" required>
            <button type="submit" name="register">Register</button>
        </form>

        <h2>File Upload</h2>
        <form action="/backend/upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <button type="submit">Upload</button>
        </form>

        <h2>Files</h2>
        <form action="/backend/take.php" method="GET">
            <button type="submit">Downloaded Files</button>
        </form>
    </div>
</body>
</html>
