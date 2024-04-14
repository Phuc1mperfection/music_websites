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