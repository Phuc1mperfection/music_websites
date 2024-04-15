
<?php
    if (isset($_SESSION['uid'])) {
        include_once '../public/user/user_header.php';
    } else {
        include_once '../public/user/header.php';
    }

?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../public/assets/css/style1.css">
        <link rel="stylesheet" href="../public/assets/css//preview.css">
    <title>Document</title>
</head>

<body>
<div class="main-container" id="main-container">
<div class="main-slider">
            <h2>Your Playlists</h2>
            <div class="list">
            <?php
    if (isset($_SESSION['uid'])) {
        if (is_array($user_playlists)) {
            foreach ($user_playlists as $playlist) : ?>
                <div class="item" onclick="loadSongsByPlaylist(<?php echo $playlist['pid']; ?>)">
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
            echo "<p>No playlists available.</p>";
        }
    } else {
        echo "<p>You need to log in to see your playlists.</p>";
    }
    ?>
            </div>
        </div>
</body>
<script>

</script>
</html>