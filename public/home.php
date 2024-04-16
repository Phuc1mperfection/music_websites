<?php
    include "../public/user/playlist_create.php";
    // include "../public/user/follow_handler.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../public/assets/css/style1.css">
    <link rel="stylesheet" href="../public/assets/css/preview.css">
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
            <button class="prev-btn"><i class="bi bi-caret-left-fill"></i></button>
            <button class="next-btn"><i class="bi bi-caret-right-fill"></i></button>
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
            <button class="prev-btn"><i class="bi bi-caret-left-fill"></i></button>
            <button class="next-btn"><i class="bi bi-caret-right-fill"></i></button>
        </div>
        <div class="main-slider">
            <h2>Nghệ Sĩ</h2>
            <div class="list">
            <?php foreach ($artists as $artist): ?>
                <div class="item" onclick="loadSongsByArtist(<?php echo $artist['aid']; ?>)">
                    <img src="<?php echo $artist['artist_image']; ?>" />
                    <h4><?php echo $artist['artist_name']; ?></h4>
                    <p>Description...</p>
                    <button class="follow-button" data-following="<?php echo $artist['is_following'] ? 'true' : 'false'; ?>" data-artist-id="<?php echo $artist['aid']; ?>">
                        <?php echo $artist['is_following'] ? '✔' : 'Follow'; ?>
                    </button>
                </div>
            <?php endforeach; ?>
            </div>
            <button class="prev-btn"><i class="bi bi-caret-left-fill"></i></button>
            <button class="next-btn"><i class="bi bi-caret-right-fill"></i></button>
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
                        $songs = [];
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
        <div class="playlist-container" id="playlist-container"></div>
    </div>
    <script src="https://kit.fontawesome.com/23cecef777.js" crossorigin="anonymous"></script>
    <script>
        function nextSong(songs) {
            var currentSongIndex = 0;
            return function() {
                currentSongIndex = (currentSongIndex + 1) % songs.length;
                var nextSong = songs[currentSongIndex];
                loadSong(nextSong.title, nextSong.artist_name, nextSong.song_image, nextSong.file_path);
            }
        }
        function previousSong(songs) {
            var currentSongIndex = 0;
            return function() {
                currentSongIndex = (currentSongIndex - 1 + songs.length) % songs.length;
                var previousSong = songs[currentSongIndex];
                loadSong(previousSong.title, previousSong.artist_name, previousSong.song_image, previousSong.file_path);
            }
        }
        document.getElementById('previous_button').addEventListener('click', previousSong(<?php echo json_encode($songs); ?>));
        document.getElementById('next_button').addEventListener('click', nextSong(<?php echo json_encode($songs); ?>));
        function loadSong(title, artist, image, filePath) {
            document.getElementById('name_song').innerHTML = `
                ${title} <div class="subtitle">${artist}</div>`;
            document.querySelector('.preview img').src = image;
            document.querySelector('.container-audio audio').src = "../public/uploads/song/" + filePath;
        }
        function loadSongsByPlaylist(pid) {
            loadSongs('playlist', pid);
        }
        function loadSongsByAlbum(abid) {
            loadSongs('album', abid);
        }
        function loadSongsByArtist(aid) {
            loadSongs('artist', aid);
        }
        function updateImageName() {
            var filename = document.getElementById('file_image').files[0].name;
            document.getElementById('playlist_image').value = filename;
        }
        function cancelAndRedirect() {
            window.location.href = 'home.php';
        }
        document.getElementById('playlist_link').addEventListener('click', function(event) {
            event.preventDefault();
            var playlistOverlay = document.getElementById('playlist-overlay');
            var playlistContainer = document.getElementById('playlist-container');
            fetch('../public/user/playlist.php')
                .then(response => response.text())
                .then(data => {
                    playlistContainer.innerHTML = data;
                    playlistOverlay.style.display = 'block';
                })
                .catch(error => console.error('Error:', error));
        });
        document.addEventListener('click', function(event) {
            var playlistOverlay = document.getElementById('playlist-overlay');
            var playlistContainer = document.getElementById('playlist-container');

            if (event.target !== playlistOverlay && !playlistOverlay.contains(event.target)) {
                playlistOverlay.style.display = 'none';
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
        document.addEventListener('DOMContentLoaded', function() {
            const sliders = document.querySelectorAll('.main-slider');
            sliders.forEach(slider => {
                const list = slider.querySelector('.list');
                const prevBtn = slider.querySelector('.prev-btn');
                const nextBtn = slider.querySelector('.next-btn');
                let scrollPosition = 0;
                const checkScroll = () => {
                    if (list.scrollWidth > list.clientWidth) {
                        nextBtn.style.display = 'block';
                    } else {
                        nextBtn.style.display = 'none';
                    }
                };
                prevBtn.addEventListener('click', () => {
                    scrollPosition -= 200;
                    if (scrollPosition < 0) {
                        scrollPosition = 0;
                    }
                    list.style.transform = `translateX(-${scrollPosition}px)`;
                    nextBtn.style.display = 'block';
                    prevBtn.style.display = scrollPosition === 0 ? 'none' : 'block';
                });
                nextBtn.addEventListener('click', () => {
                    scrollPosition += 200;
                    const maxScroll = list.scrollWidth - list.clientWidth;
                    if (scrollPosition > maxScroll) {
                        scrollPosition = maxScroll;
                    }
                    list.style.transform = `translateX(-${scrollPosition}px)`;
                    prevBtn.style.display = 'block';
                    nextBtn.style.display = scrollPosition === maxScroll ? 'none' : 'block';
                });
                checkScroll();
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.follow-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const aid = this.dataset.artistId;
                    const isFollowing = this.dataset.following === 'true';
                    const action = isFollowing ? 'unfollow' : 'follow';

                    fetch('../public/user/follow_handler.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `action=${action}&aid=${aid}&uid=<?php echo $uid; ?>`
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.text(); // Change to text() for plain text response
                        } else {
                            throw new Error('Something went wrong on API server!');
                        }
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        alert(data); // Display the text response
                        if (data.includes('successfully')) {
                            // Update button text and data attribute
                            this.innerText = isFollowing ? 'Follow' : '✔';
                            this.dataset.following = isFollowing ? 'false' : 'true';
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
                });
            });
        });
    </script>
</body>
</html>