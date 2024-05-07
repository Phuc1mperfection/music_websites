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
            
            <h2>Album</h2>
            <div class="list">
                <?php foreach ($albums as $album) : ?>
                    <div class="item" onclick="loadSongsByAlbum(<?php echo $album['abid']; ?>)">
                        <img src="<?php echo $album['album_image']; ?>" />
                        <h4><?php echo $album['title']; ?></h4>
                        <p>Description...</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="main-slider">
            <h2>Artists</h2>
            <div class="list">
                <?php foreach ($artists as $artist) : ?>
                    <div class="item" onclick="loadSongsByArtist(<?php echo $artist['aid']; ?>)">
                        <img src="<?php echo $artist['artist_image']; ?>" />
                        <h4><?php echo $artist['artist_name']; ?></h4>
                        <p>Description...</p>
                        <button class="follow-button" data-following="<?php echo $artist['is_following'] ? 'true' : 'false'; ?>" 
                        data-artist-id="<?php echo $artist['aid']; ?>">                            <?php echo $artist['is_following'] ? '✔' : 'Follow'; ?>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- <button class="next-btn"><i class="bi bi-caret-right-fill"></i></button>
            <button class="prev-btn"><i class="bi bi-caret-left-fill"></i></button> -->
        </div>
    </div>

</body>

</html>