<?php
define("ROOT", "http://localhost:84/music_websites/public");
define("DBDRIVER", "mysql");
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "music_website_db");
function db_connect()
{
	$string = DBDRIVER.":hostname=".DBHOST.";dbname=".DBNAME;
	$con = new PDO($string, DBUSER, DBPASS);

	return $con;
}

function db_query($query, $data = array())
{
	$con = db_connect();

	$stm = $con->prepare($query);
	if($stm)
	{
		$check = $stm->execute($data);
		if($check){
			$result = $stm->fetchAll(PDO::FETCH_ASSOC);

			if(is_array($result) && count($result) > 0)
			{
				return $result;
			}
		}
	}
	return false;
}

function db_query_one($query, $data = array())
{
	$con = db_connect();

	$stm = $con->prepare($query);
	if($stm)
	{
		$check = $stm->execute($data);
		if($check){
			$result = $stm->fetchAll(PDO::FETCH_ASSOC);

			if(is_array($result) && count($result) > 0)
			{
				return $result[0];
			}
		}
	}
	return false;
}
function db_query_insert($query, $data = array()) //insert db
{
    $con = db_connect();
    $stm = $con->prepare($query);
    if($stm)
    {
        $check = $stm->execute($data);
        if($check){
            return $stm->rowCount();
        }
    }
    return false;
}
function db_query_delete($query, $data = array())
{
    $con = db_connect();
    $stm = $con->prepare($query);
    if($stm)
    {
        $check = $stm->execute($data);
        return $check;
    }
    return false;
}
function get_user_playlists($uid) {
    $query = "SELECT pid, playlist.playlist_name, playlist.playlist_image
			FROM users
			JOIN playlist ON users.id = playlist.uid
			WHERE uid = ?";
    return db_query($query, array($uid));
}

function get_albums() {
	$query = "SELECT albums.abid, albums.title, albums.album_image
			FROM albums
			WHERE albums.status = 1
			GROUP BY albums.abid";
	return db_query($query);
}

function get_artists() {
	$query = "SELECT id AS aid, name AS artist_name, image AS artist_image
			FROM artists";
	return db_query($query);
}
function is_following($uid, $aid) {
    $query = "SELECT id FROM follow WHERE uid = :uid AND aid = :aid";
    $data = array(':uid' => $uid, ':aid' => $aid);
    $result = db_query($query, $data);
    return $result ? true : false;
}
function get_artists_with_follow_status($uid) {
    $artists = get_artists();
    foreach ($artists as $key => $artist) {
        $artists[$key]['is_following'] = is_following($uid, $artist['aid']);
    }
    return $artists;
}

function get_songs_by_playlist($pid) {
	$query = "SELECT songs.id AS sid, songs.title, artists.name AS artist_name, songs.image AS song_image, songs.file AS file_path
			FROM songs
			INNER JOIN user_playlists ON songs.id = user_playlists.sid
			INNER JOIN artists ON songs.artist_id = artists.id
			WHERE user_playlists.pid = ?";
	return db_query($query, array($pid));
}

function get_songs_by_album($abid) {
	$query = "SELECT songs.id AS sid, songs.title, artists.name AS artist_name, songs.image AS song_image, songs.file AS file_path
			FROM songs
			INNER JOIN albums ON songs.id = albums.sid
			INNER JOIN artists ON songs.artist_id = artists.id
			WHERE albums.abid = ?";
	return db_query($query, array($abid));
}

function get_songs_by_artist($aid) {
	$query = "SELECT songs.id AS sid, songs.title, artists.name AS artist_name, songs.image AS song_image, songs.file AS file_path
			FROM songs 
			INNER JOIN artists ON songs.artist_id = artists.id
			WHERE songs.artist_id = ?";
	return db_query($query, array($aid));
}

function get_favorite_songs($uid) {
    $query = "SELECT songs.id AS sid, songs.title, artists.name AS artist_name, songs.image AS song_image, songs.file AS file_path
            FROM tracks_playlist
            INNER JOIN songs ON tracks_playlist.sid = songs.id
            INNER JOIN artists ON songs.artist_id = artists.id
            WHERE tracks_playlist.uid = ? AND tracks_playlist.favorite = 1";
    return db_query($query, array($uid));
}

function get_top_songs() {
    $query = "SELECT songs.id AS sid, songs.title, artists.name AS artist_name, songs.image AS song_image, songs.file AS file_path
            FROM songs
            INNER JOIN artists ON songs.artist_id = artists.id
            ORDER BY songs.views DESC
            LIMIT 2";
    return db_query($query);
}

function get_all_songs(){
	$query = "SELECT songs.id AS sid, songs.title, artists.name AS artist_name, songs.image AS song_image, songs.file AS file_path
			FROM songs
			INNER JOIN artists ON songs.artist_id = artists.id";
	return db_query($query);
}

function displaySongs($songs) {
	if ($songs !== false) {
		$count = 1;
		foreach ($songs as $song) {
			$count_str = str_pad($count, 2, '0', STR_PAD_LEFT);
			echo "<li class='songItem' onclick='loadSong(\"{$song['title']}\", \"{$song['artist_name']}\",
				\"{$song['song_image']}\", \"{$song['file_path']}\")'>";
			echo "<span>{$count_str}</span>";
			echo "<img src='{$song['song_image']}' alt=''>";
			echo "<h5>{$song['title']} <br> <div class='subtitle'>{$song['artist_name']}</div></h5>";
			echo "<i class='bi playlistPlay bi-play-fill' id='{$song['sid']}'></i>";
			echo "</li>";
			$count++;
		}
	} else {
		echo "<p>No songs available.</p>";
	}
}