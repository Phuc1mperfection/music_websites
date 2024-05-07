	

<?php require page('includes/admin-header')?>
<?php
// Fetch song views data from database
$query = "SELECT title, views FROM songs";
$songs = db_query($query);

// Prepare data for chart
$labels = [];
$data = [];
foreach ($songs as $song) {
    $labels[] = $song['title'];
    $data[] = $song['views'];
}

$query = "SELECT COUNT(*) as total FROM songs";
$songs = db_query_one($query);
$total_songs = $songs['total'];

// Fetch total number of views
$query = "SELECT SUM(views) as total FROM songs";
$views = db_query_one($query);
$total_views = $views['total'];

// Fetch total number of users
$query = "SELECT COUNT(*) as total FROM users";
$users = db_query_one($query);
$total_users = $users['total'];


$query = "SELECT COUNT(*) as total FROM playlist";
$users = db_query_one($query);
$total_playlist = $users['total'];
// Fetch total number of artists
$query = "SELECT COUNT(*) as total FROM artists";
$artists = db_query_one($query);
$total_artists = $artists['total'];
?>
	<!DOCTYPE html>
    <html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
    <style>
.stats-container {
    display: flex; 
    justify-content: space-around; 
    background-color: #4D869C; 
    padding: 20px; 
    border-radius: 5px;
}

.stats-container div {
    transition: background-color 0.3s ease;
    border-radius: 5rem;
    padding: 20px;
}

.stats-container div:hover {
    background-color: #6A9CB2;
}
</style>
    <section class="admin-content" style="min-height: 200px;">
  <h2>Stats</h2>
  <div class="stats-container">
    <div>
        <h2><?php echo $total_songs; ?></h2>
        <p>Total Songs</p>
    </div>
    <div>
        <h2><?php echo $total_views; ?></h2>
        <p>Total Views</p>
    </div>
    <div>
        <h2><?php echo $total_playlist; ?></h2>
        <p>Total Playlists</p>
    </div>
    <div>
        <h2><?php echo $total_users; ?></h2>
        <p>Total Users</p>
    </div>
    <div>
        <h2><?php echo $total_artists; ?></h2>
        <p>Total Artists</p>
    </div>
</div>
  		</section>
    </html>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <canvas id="songViewsChart"></canvas>

<script>
var ctx = document.getElementById('songViewsChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Song Views',
            data: <?php echo json_encode($data); ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
    </body>
<?php require page('includes/admin-footer')?>