<?php

if (isset($_SESSION['uid'])) {
    include_once '../public/user/user_header.php';
} else {
    include_once '../public/user/header.php';
}
if (isset($_SESSION['success'])) {
    echo "<p style='color: green;'>{$_SESSION['success']}</p>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<p style='color: red;'>{$_SESSION['error']}</p>";
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../public/assets/css/style1.css">
    <link rel="stylesheet" href="../public/assets/css/preview.css">
    <title>Document</title>
</head>

<body>

    <div class="main-container" id="main-container">
        <div class="main-slider">

            <h2>Your Playlists</h2>
            <button id="add-button" class="playlist-btn"><i class="fas fa-plus fa-3x "></i></button>
            <button id="delete-button" class="playlist-btn"><i class="fas fa-minus fa-3x "></i></button>

            <div class="list">
                <?php
                if (isset($_SESSION['uid'])) {
                    if (is_array($user_playlists)) {
                        foreach ($user_playlists as $playlist) : ?>
                            <div class="item" ondrop="drop(event)" ondragover="event.preventDefault()" onclick="loadSongsByPlaylist(<?php echo $playlist['pid']; ?>)" id='<?php echo $playlist['pid']; ?>'>
                                <img src="<?php echo $playlist['playlist_image']; ?>" />
                                <h4><?php echo $playlist['playlist_name']; ?></h4>
                                <p>Description...</p>
                                <?php
                                $songs = get_songs_by_playlist($playlist['pid']);
                                if ($songs) {
                                    echo "<p>" . count($songs) . " song(s)</p>";
                                } else {
                                    echo "<p>Playlist is empty.</p>";
                                }
                                ?>
                            </div>
                <?php endforeach;
                    } else {
                        echo "<p style='color:#fff;margin-top:10px; font-style:italic; font-size:15px'>No playlists available.</p>";
                    }
                } else {
                    echo "<p style='color:#fff;margin-top:10px; font-style:italic; font-size:15px' >You need to log in to see your playlists.</p>";
                }
                ?>
            </div>
        </div>

        <style>
            .form-container {
                background-color: rgba(255, 255, 255, 0.2);
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                color: #fff;
                width: 300px;
                margin-left: 100px;
                text-align: center;
            }

            .playlist-btn {
                margin: 10px 0px 20px 40px;
                background-color: transparent;
                border: none;
                border-radius: 1rem;
                color: #fff;
                cursor: pointer;

            }

            .playlist-btn:hover {
                background-color: #1679AB;
                transition: all 2s;
            }

            input[type="text"],
            input[type="file"] {
                width: calc(100% - 20px);
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 1rem;
                background: rgba(255, 255, 255, 0.2);
                border: 0;
                backdrop-filter: blur(10px) saturate;
            }

            button.submit {
                padding: 10px 20px;
                background-color: #1679AB;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                transition: background-color 0.3s;
                margin-right: 10px;
            }

            button.submit:hover {
                background-color: #141E46;
            }
        </style>
        </head>
        <div class="form-container" id="form-container-add" style="display: none;">
            <h1>Create New Playlist</h1>
            <?php if (isset($error)) : ?>
                <p style="color: red;"><?= $error ?></p>
            <?php endif; ?>
            <?php if (isset($_SESSION['success'])) : ?>
                <p style="color: green;"><?= $success ?></p>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])) : ?>
                <p style="color: red;"><?= $error ?></p>
            <?php endif; ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="playlist_name" placeholder="Enter playlist name" required>
                <input type="text" name="playlist_image" id="playlist_image" placeholder="Enter playlist image" required>
                <input type="file" name="file_image" id="file_image" accept="image/*" onchange="updateImageName()">
                <button type="submit" class="submit">Submit</button>
                <button type="button" class="submit" onclick="cancelAndRedirect()">Cancel</button>
            </form>
        </div>
        <div class="form-container" id="form-container-delete" style="display: none;">
            <h1>Delete Playlist</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                <?php if (!empty($user_playlists)) : ?>
                    <select name="playlist">
                        <?php foreach ($user_playlists as $playlist) : ?>
                            <option value="<?php echo $playlist['pid']; ?>">
                                <?php echo $playlist['playlist_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select><br>
                <?php endif; ?>
                </select>
                <button type="submit" class="submit">Submit</button>
                <button type="button" class="submit" onclick="cancelAndRedirect1()">Cancel</button>
            </form>
        </div>
    </div>
</body>
<script>
    document.getElementById('add-button').addEventListener('click', function() {
        document.getElementById('form-container-add').style.display = 'block';
    });
    document.getElementById('delete-button').addEventListener('click', function() {
        document.getElementById('form-container-delete').style.display = 'block';
    });

    function cancelAndRedirect() {
        document.getElementById("form-container-add").style.display = "none";
    }

    function cancelAndRedirect1() {
        document.getElementById("form-container-delete").style.display = "none";
    }
</script>

</html>
<?php
unset($_SESSION['error']);
unset($_SESSION['success']);
?>