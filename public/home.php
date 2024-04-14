<?php
    include "../public/user/functions.php";
    session_start();
    $uid = $_SESSION['uid'];
    $user_playlists = get_user_playlists($uid);
    $albums = get_albums();
    $artists = get_artists();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['playlist_name'])) {
        try {
            $playlistName = filter_var(trim($_POST['playlist_name']), FILTER_SANITIZE_STRING);
    
            if (!empty($playlistName)) {
                $values = [
                    'uid' => $_SESSION['uid'],
                    'playlist_name' => $playlistName,
                ];
    
                $query = "INSERT INTO playlist (" . implode(',', array_keys($values)) . ") VALUES (:" . implode(', :', array_keys($values)) . ")";
                $row_count = db_query_insert($query, $values);
    
                if ($row_count !== false && $row_count > 0) {
                    // Playlist created successfully
                    $success = 'Playlist created successfully!';
                } else {
                    // Failed to create playlist
                    $error = 'Failed to create playlist.';
                }
            } else {
                // Please provide a playlist name
                $error = 'Please provide a playlist name.';
            }
        } catch (PDOException $e) {
            // Handle database error
            $error = 'Database error: ' . $e->getMessage();
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
            <a href="#"><img src="../public/assets/images/logo.jpg" alt="Logo" /></a>
        </div>
        <div class="navigation">
            <ul>
                <!-- <li><a href="#"><span class="fa fa-home"></span><span>Home</span></a></li> -->
                <!-- dựa vào số lượng view nhưng do chưa có chưa hoạt động -->
                <li><a href="#" id="top_music_link"><span class="fa fas fa-book"></span><span>Top Music</span></a></li>
                <!-- <li><a href="#"><span class="fa fas fa-book"></span><span>Your Library</span></a></li> -->
                <li><a href="#" id="playlist_link"><span class="fa fas fa-plus-square"></span><span>Create Playlist</span></li>
                <!-- csdl chưa có lấy được uid truyền vào nên chưa lấy đc -->
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
                    <img src="../public/assets/images/hero.jpg" />
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
                Name song
                <div class="subtitle">Name Artist</div>
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
    <script>
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
        //đưa nhạc từ menusong vào preview
        function loadSong(title, artist, image, filePath) {
            document.getElementById('name_song').innerHTML = `
                ${title} <div class="subtitle">${artist}</div>`;
            document.querySelector('.preview img').src = image;
            document.querySelector('.container-audio audio').src = "../public/uploads/song/" + filePath;
        }
        //sự kiện click list nhạc theo album, playlist, artist.
        function loadSongsByPlaylist(pid) {
            loadSongs('playlist', pid);
        }
        function loadSongsByAlbum(abid) {
            loadSongs('album', abid);
        }
        function loadSongsByArtist(aid) {
            loadSongs('artist', aid);
        }
        document.getElementById('playlist_link').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link behavior (navigation)

            var playlistOverlay = document.getElementById('playlist-overlay');
            var playlistContainer = document.getElementById('playlist-container');

            // Load content from playlist.php
            fetch('../public/user/playlist.php')
                .then(response => response.text())
                .then(data => {
                    playlistContainer.innerHTML = data; // Set content to loaded data
                    playlistOverlay.style.display = 'block'; // Show playlist overlay
                })
                .catch(error => console.error('Error:', error));
        });
        document.addEventListener('click', function(event) {
            var playlistOverlay = document.getElementById('playlist-overlay');
            var playlistContainer = document.getElementById('playlist-container');

            if (event.target !== playlistOverlay && !playlistOverlay.contains(event.target)) {
                playlistOverlay.style.display = 'none'; // Hide playlist overlay
            }
        });
        document.querySelector('.playlist_button').addEventListener('click', function() {
            loadSongs('all', '');
        });
        document.getElementById('songs_link').addEventListener('click', function() {
            loadSongs('like', '<?php echo $uid; ?>');
        });
        document.getElementById('top_music_link').addEventListener('click', function() {
            loadSongs('top', '');
        });
        function loadSongs(option, id) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.querySelector('.menu-song ul').innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "load_songs.php?option=" + option + "&id=" + id, true);
            xhttp.send();
        }
    </script>
</body>
</html>