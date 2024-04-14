<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Playlist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button[type="submit"], button[type="button"] {
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-right: 10px;
        }
        button[type="submit"]:hover, button[type="button"]:hover {
            background-color: #45a049;
        }
        .back-button {
            background-color: #ccc;
        }
        .back-button:hover {
            background-color: #bfbfbf;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>New Playlist</h1>
        <?php if (isset($success)): ?>
            <p style="color: green;"><?= $success ?></p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <input type="text" name="playlist_name" placeholder="Enter playlist name" required>
            <button type="submit">Create Playlist</button>
            <button type="button" class="back-button" onclick="window.location.href='home.php'">Back to Home</button>
        </form>
    </div>
</body>
</html>
