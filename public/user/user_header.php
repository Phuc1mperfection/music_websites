<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../public/assets/css/dropdown.css">

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
            <input type="text" placeholder="Tìm kiếm..." class="search-input">
            <button><span class="fa fa-search"></span></button>
        </div>
        <div class="navbar">
            <!-- <li>
                        <a href="#">Download</a>
                    </li> -->
            <!-- <li class="divider">|</li> -->
                <?php
                echo "<p>Hi, " . $_SESSION['uid'] . "</p>";
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