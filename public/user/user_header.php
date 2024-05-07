<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<style>
    .p-class {
        color: blue;
        font-size: 18px;
    }
</style>
<header>
    <div class="topbar">
    <div class="search">

<div class="search-container">
<form action="../public/home.php" class="search-bar" method="GET">
    <input type="hidden" name="page" value="user_search">
    <input type="text" placeholder="Search anything" class="search-input" name="find">
    <button type="submit" class="search-button"><img src="./assets/images/search.png" alt="dgf"></button>
</form>
</div>
</div>
        <div class="navbar">
            <!-- <li>
                        <a href="#">Download</a>
                    </li> -->
            <!-- <li class="divider">|</li> -->
            <?php
            ?>
            <div class="dropdown">
                <i class="fas fa-bars dropbtn" onclick="dropdown()"></i>
                <div id="myDropdown" class="dropdown-content">
                    <a href="../public/user/logout.php">Logout</a>
                </div>
            </div>

            <script>
                function dropdown() {
                    document.getElementById("myDropdown").classList.toggle("show");
                }

                window.onclick = function(event) {
                    if (!event.target.matches('.dropbtn')) {
                        var dropdowns = document.getElementsByClassName("dropdown-content");
                        var i;
                        for (i = 0; i < dropdowns.length; i++) {
                            var openDropdown = dropdowns[i];
                            if (openDropdown.classList.contains('show')) {
                                openDropdown.classList.remove('show');
                            }
                        }
                    }
                }
            </script>
        </div>
    </div>
</header>

<body>
</body>

</html>