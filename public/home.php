<?php
    session_start();
    include "../public/user/playlist_create.php";
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
            <a href="#"><img src="../public/assets/images/logo.jpg" alt="Logo" /></a>
        </div>
        <div class="navigation">
            <ul>
                <!-- <li><a href="#"><span class="fa fa-home"></span><span>Home</span></a></li> -->
                <li><a href="#" id="top_music_link"><span class="fa fas fa-book"></span><span>Top Music</span></a></li>
                <!-- <li><a href="#"><span class="fa fas fa-book"></span><span>Your Library</span></a></li> -->
                <li><a href="#" id="playlist_link"><span class="fa fas fa-plus-square"></span><span>Create Playlist</span></li>
                <li><a href="#" id="songs_link"><span class="fa fas fa-heart"></span><span>Liked Songs</span></a></li>
            </ul>
        </div>
    </div>

    <div class="main-container">
        <div class="topbar">
            <div class="search">
                <input type="text" placeholder="Tìm kiếm..." class="search-input">
                <button><span class="fa fa-search"></span></button>
            </div> 
            <div class="navbar">
                <!-- <li>
                        <a href="#">Download</a>
                    </li> -->
                <!-- <li class="divider">|</li> -->
                <div class="btn">
                <button type="button" onclick="location.href='sign_up.php';">Sign Up</button>
                <button type="button" onclick="location.href='login.php';">Login</button>
                </div>
            </div>
        </div>
        <div class="main-slider">
            <h2>Playlists</h2>
            <div class="list">
            <?php foreach ($user_playlists as $playlist): ?>
                <div class="item" onclick="loadSongsByPlaylist(<?php echo $playlist['pid']; ?>)">
                    <img src="<?php echo $playlist['playlist_image']; ?>" />
                    <h4><?php echo $playlist['playlist_name']; ?></h4>
                    <p>Description...</p>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <div class="main-slider">
            <h2>Album</h2>
            <div class="list">
            <?php foreach ($albums as $album): ?>
                <div class="item" onclick="loadSongsByAlbum(<?php echo $album['abid']; ?>)">
                    <img src="<?php echo $album['album_image']; ?>" />
                    <h4><?php echo $album['title']; ?></h4>
                    <p>Description...</p>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <div class="main-slider">
            <h2>Nghệ Sĩ</h2>
            <div class="list">
            <?php foreach ($artists as $artist): ?>
                <div class="item" onclick="loadSongsByArtist(<?php echo $artist['aid']; ?>)">
                    <img src="<?php echo $artist['artist_image']; ?>" />
                    <h4><?php echo $artist['artist_name']; ?></h4>
                    <p>Description...</p>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
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
                <ul>
                    <?php 
                        $songs = get_all_songs();
                        displaySongs($songs);?>
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
    <script  src="../public/assets/js/home.js">
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