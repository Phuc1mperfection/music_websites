<?php
    include "functions.php";

    //Kiểm tra xem session uid đã tồn tại chưa
    $uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : '';
    if (!empty($uid)) {
    session_start();
    $uid = $_SESSION['uid'];
    $user_playlists = get_user_playlists($uid);
    $albums = get_albums();
    $artists = get_artists();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['playlist_name'])) {
        $playlistName = filter_var(trim($_POST['playlist_name']) );
        if (!empty($playlistName)) {
            $existingPlaylist = db_query("SELECT * FROM playlist WHERE playlist_name = :playlist_name AND uid = :uid", ['playlist_name' => $playlistName, 'uid' => $uid]);
            if ($existingPlaylist !== false && count($existingPlaylist) > 0) {
                $error = 'Playlist already exists.';
            } else {
                $playlistImage = '';
                $uploadDir = 'uploads/';
                if (isset($_FILES['file_image']) && $_FILES['file_image']['error'] === UPLOAD_ERR_OK) {
                    $uploadedFile = $uploadDir . basename($_FILES['file_image']['name']);
                    move_uploaded_file($_FILES['file_image']['tmp_name'], $uploadedFile);
                    $playlistImage = $uploadedFile;
                } else {
                    $playlistImage = $uploadDir.filter_var(trim($_POST['playlist_image']));
                }
                if (empty($error)) {
                    $values = [
                        'uid' => $uid,
                        'playlist_name' => $playlistName,
                        'playlist_image' => $playlistImage,
                    ];
                    $query = "INSERT INTO playlist (" . implode(',', array_keys($values)) . ") VALUES (:" . implode(', :', array_keys($values)) . ")";
                    $row_count = db_query_insert($query, $values);
    
                    if ($row_count !== false && $row_count > 0) {
                        $success = 'Playlist created successfully!';
                    } else {
                        $error = 'Failed to create playlist.';
                    }
                }
            }
        } else {
            $error = 'Please provide a playlist name.';
        }
    }
}
?>
