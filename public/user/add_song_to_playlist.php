<?php
include 'functions.php';

function add_song_to_playlist($playlist_id, $song_id)
{
    $query = "INSERT INTO user_playlists (pid, sid) VALUES (?, ?)";
    return db_query($query, array($playlist_id, $song_id));
}

$playlistId = $_POST['playlist_id'];
$songId = $_POST['song_id'];

$result = add_song_to_playlist($playlistId, $songId);

if ($result) {
    $_SESSION['success'] = "Song hnnnnnwas successfully added to the playlist.";
} else {
    $_SESSION['error'] = 'There was an error adding the song to the playlist.';
}
// Redirect back to the page where the request came from
?>
