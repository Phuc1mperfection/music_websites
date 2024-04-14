<?php 
session_start();
include_once "../public/user/playlist_create.php";
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    include($page . ".php");
} else {
    if (isset($_SESSION['uid'])) {
        include_once '../public/user/user_header.php';
    } else {
        include_once '../public/user/header.php';
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../public/assets/css/style1.css">
    <link rel="stylesheet" href="../public/assets/css//preview.css">
    <title>Music Website</title>
    <style>
        .playlist-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: none;
        }

        .playlist-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 340px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <a href="http://localhost:84/music_websites/public/home.php"><img src="../public/assets/images/logo.jpg" alt="Logo" /></a>
        </div>
        <div class="navigation">
            <ul>
                <li><a href="home.php?page=home1"><span class="fa fa-home"></span><span>Home</span></a></li>
                <li><a href="#" id="top_music_link"><span class="fa fas fa-fire"></span><span>Top Music</span></a></li>

                <li><a href="#" id="playlist_link"><span class="fa fas fa-plus-square"></span><span>Create Playlist</span></li>
                <li><a href="#" id="songs_link"><span class="fa fas fa-heart"></span><span>Liked Songs</span></a></li>

                <li><a href="home.php?page=library"><span class="fa fas fa-book"></span>Your Library</a></li>
            </ul>
        </div>
    </div>
    
   
    <div class="main-container" id="main-container">

       
       
        <div class="menu-side">
            <div class="menu-buttons">
                <div class="button">
                    <button class="playlist_button">Track_Listening</button>
                </div>
                <div class="button">
                    <button class="recent_button">History_Recently</button>
                </div>
            </div>
            <div class="menu-song">
                <div class="title">

                </div>
                <ul>
                    <?php
                    $songs = get_all_songs();
                    displaySongs($songs); ?>
                </ul>
            </div>
        </div>
        <div class="preview">
            <img src="" alt="image-song">
            <h2 id="name_song">
                Names_song
                <div class="subtitle">Name_Artist</div>
            </h2>
            <div class="icon">
                <i class="bi bi-skip-start-fill" id="previous_button"></i>
                <i class="bi bi-skip-end-fill" id="next_button"></i>
            </div>
            <div class="container-audio">
                <audio controls  loop>
                    <source src="../public/uploads/song/0.mp3" type="audio/ogg">
                </audio>
            </div>
        </div>
    </div>
    <div class="playlist-overlay" id="playlist-overlay">
        <div class="playlist-container" id="playlist-container">
            <!-- Playlist content will be loaded here -->
        </div>
    </div>
    <script src="https://kit.fontawesome.com/23cecef777.js" crossorigin="anonymous"></script>
    <script src="../public/assets/js/home.js">
        //chuyển nhạc
        var currentSongIndex = 0;
        var songs = <?php echo json_encode($songs); ?>;

        function nextSong() {
            currentSongIndex = (currentSongIndex + 1) % songs.length;
            var nextSong = songs[currentSongIndex];
            loadSong(nextSong.title, nextSong.artist_name, nextSong.song_image, nextSong.file_path);
        }

        function previousSong() {
            currentSongIndex = (currentSongIndex - 1 + songs.length) % songs.length;
            var previousSong = songs[currentSongIndex];
            loadSong(previousSong.title, previousSong.artist_name, previousSong.song_image, previousSong.file_path);
        }
        document.getElementById('previous_button').addEventListener('click', previousSong);
        document.getElementById('next_button').addEventListener('click', nextSong);
    </script>
</body>

</html>