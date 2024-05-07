<!DOCTYPE html>
<html lang="en">

<head>
	<title>Music Website</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="http://localhost:84/music_websites/public/assets/css/style.css">

</head>

<body>
	
	<header style="background-color: white; color: black;">
		<div class="logo-holder">
		<a href="dashboard"><center><img src="../assets/images/treble-clef.png" style="border-radius: 10%;"></center></a>
		</div>
		<div class="heaeder-div">
			<div class="main-title">
				ADMIN AREA
				<div class="socials">

				</div>
			</div>
			<div class="main-nav">
				<div class="nav-item"><a href="<?=ROOT?>/admin/dashboard">Dashboard</a></div>
				<div class="nav-item"><a href="<?=ROOT?>/admin/users">Users</a></div>
				<div class="nav-item"><a href="<?=ROOT?>/admin/songs">Songs</a></div>
				<div class="nav-item"><a href="<?=ROOT?>/admin/categories">Categories</a></div>
				<div class="nav-item"><a href="<?=ROOT?>/admin/artists">Artists</a></div>
				<div class="nav-item"><a href="<?=ROOT?>/admin/stats">Stats</a></div>
				<a href="#"></a>
				<div class="nav-item"><a href="<?=ROOT?>/logout">Logout</a></div>
			</div>
		</div>
	</header>