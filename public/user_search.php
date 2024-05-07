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
    <link rel="stylesheet" href="../public/assets/css/preview.css">
    <title>Document</title>
</head>

<body>
    <div class="main-container" id="main-container">

        <div class="section-title">Search for: <?= $_GET['find'] ?></div>

        <section class="content">

        <div class="main-slider">
        <?php
$title = $_GET['find'] ?? null;
$rows = [];

if (!empty($title)) {
    $title = "%$title%";
    $query = "SELECT * FROM songs WHERE LOWER(title) LIKE LOWER(:title) ORDER BY views DESC LIMIT 24";
    $rows = db_query($query, ['title' => $title]);

    if (empty($rows)) {
        echo '<pre>';
        var_dump($query);
        echo '</pre>';
    }
}
?>
<div class="list">
<?php
if (!empty($rows)) {
    foreach ($rows as $row) {
        echo '<img src="' . $row['image'] . '" alt="' . $row['title'] . '">';
        echo '<h2>' . $row['title'] . '</h2>';
        echo '<p>Artist ID: ' . $row['artist_id'] . '</p>';
        echo '<p>Views: ' . $row['views'] . '</p>';
    }
} else {
    echo '<div class="m-2">No songs found</div>';
}
?></div>
        </div>
        </section>
        <!-- <div class="main-slider">
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
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        </div> -->


</body>

</html>