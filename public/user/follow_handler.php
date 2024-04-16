<?php
    include "playlist_create.php";
    // include 'functions.php';

$aid = $_POST['aid'] ?? null;
$action = $_POST['action'] ?? '';
if (!$aid || !in_array($action, ['follow', 'unfollow'])) {
    echo 'Invalid parameters';
    exit;
}
if (!isset($_SESSION['uid'])) {
    echo 'Not logged in';
    exit;
}
$uid = $_SESSION['uid'];
try {
    if ($action == 'follow') {
        $values = [
            'uid' => $uid,
            'aid' => $aid,
        ];
        $query = "INSERT INTO follow (" . implode(',', array_keys($values)) . ") VALUES (:" . implode(', :', array_keys($values)) . ")";
        // $query = "INSERT INTO follow (uid, aid) VALUES (:uid, :aid)";
        $result = db_query_insert($query, array(':uid' => $uid, ':aid' => $aid));
        echo $result ? 'Followed successfully' : 'Failed to follow';
    } else {
        $values = [
            'uid' => $uid,
            'aid' => $aid,
        ];
        // $query = "DELETE INTO follow (" . implode(',', array_keys($values)) . ") VALUES (:" . implode(', :', array_keys($values)) . ")";
        $query = "DELETE FROM follow WHERE uid = :uid AND aid = :aid";
        $result = db_query_delete($query, $values);
        echo $result ? 'Unfollowed successfully' : 'Failed to unfollow';
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
