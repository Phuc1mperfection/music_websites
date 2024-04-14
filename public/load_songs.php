<?php
include "../public/user/functions.php";

if(isset($_GET['option']) && isset($_GET['id'])) {
    $option = $_GET['option'];
    $id = $_GET['id'];
    $uid = isset($_GET['uid']) ? $_GET['uid'] : null;
    $uid = $_GET['id']; 
    if($option === 'playlist') {
        $songs = get_songs_by_playlist($id);
    } elseif($option === 'album') {
        $songs = get_songs_by_album($id);
    } elseif($option === 'artist') {
        $songs = get_songs_by_artist($id);
    } elseif( $option === 'all'){
        $songs = get_all_songs();
    } elseif( $option === 'top'){
        $songs = get_top_songs();
    } elseif( $option === 'like' && $uid){
        $songs = get_favorite_songs($uid);
    }
    displaySongs($songs);
}
?>