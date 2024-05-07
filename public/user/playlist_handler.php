<?php
include "functions.php";
$uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : '';
if (!empty($uid)) {
    $uid = $_SESSION['uid'];
    $user_playlists = get_user_playlists($uid);
    $albums = get_albums();
    $artists = get_artists_with_follow_status($uid);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['playlist_name'])) {
        $playlistName = filter_var(trim($_POST['playlist_name']));
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
                    $playlistImage = $uploadDir . filter_var(trim($_POST['playlist_image']));
                }
                if (empty($error)) {
                    $values = [
                        'uid' => $uid,
                        'playlist_name' => $playlistName,
                        'playlist_image' => $playlistImage,
                    ];
                    unset($_SESSION['error']);
                    $query = "INSERT INTO playlist (" . implode(',', array_keys($values)) . ") VALUES (:" . implode(', :', array_keys($values)) . ")";
                    $row_count = db_query_insert($query, $values);

                    if ($row_count !== false && $row_count > 0) {
                        $success = 'Playlist created successfully!';
                        $_SESSION['success'] = $success;
                        header("Location: " . $_SERVER['PHP_SELF']); // Reload the page
                        exit;
                    }else {
                        $error = 'Failed to create playlist.';
                        echo '<script type="text/javascript">alert("' . addslashes($error) . '");</script>';
                    }
                }
            }
        } else {
            $error = 'Please provide a playlist name.';
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['playlist'])) {
        $playlistId = filter_var(trim($_POST['playlist']));
        if (!empty($playlistId)) {
            // Delete songs from the playlist
            $song_row_count = db_query("DELETE FROM user_playlists WHERE pid = :pid", ['pid' => $playlistId]);

            // Delete the playlist
            $playlist_row_count = db_query("DELETE FROM playlist WHERE pid = :pid AND uid = :uid", ['pid' => $playlistId, 'uid' => $uid]);
            if ($playlist_row_count !== false && $playlist_row_count > 0) {
                echo '<script type="text/javascript">alert("' . addslashes($success) . '");</script>';
            header("Location: " . $_SERVER['PHP_SELF']); // Reload the page
                        exit;
            } else {
                $error = 'Failed to delete playlist.';
            echo '<script type="text/javascript">alert("' . addslashes($success) . '");</script>';
            $_SESSION['error'] = $success;
                header("Location: " . $_SERVER['PHP_SELF']); // Reload the page
                exit;
            }
        } else {
            $error = 'No playlists to delete.';
            $_SESSION['error'] = $error;
            echo '<script type="text/javascript">alert("' . addslashes($success) . '");</script>';
            header("Location: " . $_SERVER['PHP_SELF']); // Reload the page
            exit;
        }
    }
}
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']); // Unset the error message in the session
}
