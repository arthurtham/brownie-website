<?php

echo <<<NAVBAR
    <header>
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark" style="position:fixed; width:100%; top:0; padding-left:20px; padding-right:20px;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="/assets/img/turtleavatar.png" width=30px height=30px class="d-inline-block align-top" style="border-radius:100%" />
            BrowntulStar
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarAbout" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    About
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarAbout"> 
                    <li><a class="dropdown-item" href="/about">About Me</a></li>
                    <li><a class="dropdown-item" href="/about/credits">Credits</a></li>
                    <li><hr class="dropdown-divider" />
                    <li><h6 class="dropdown-header">Portfolio</h6></li>
                    <li><a class="dropdown-item" href="/about/coding">Coding</a></li>
                    <li><a class="dropdown-item" href="/about/shoutcasting">Commentating<br>and Production</a></li>
                    <li><hr class="dropdown-divider" />
                    <li><h6 class="dropdown-header">Live</h6></li>
                    <li><a class="dropdown-item" href="/announcements">Announcements</a></li>
                    <li><a class="dropdown-item" href="/stream">Stream</a></li>
                </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/store">Support/Donate</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarSubs" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Sub Perks
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarSubs">
                    <li><a class="dropdown-item" href="/subs">Subs Home</a></li>
                    <li><hr class="dropdown-divider" />
                    <li><h6 class="dropdown-header">Sub Perks</h6></li>
                    <li><a class="dropdown-item" href="/subs/blog">Blog</a></li>
                    <li><a class="dropdown-item" href="/subs/karaoke">Tank Engine Karaoke</a></li>
                    <li><a class="dropdown-item" href="/r/clipcompetition">#BrownieVAL Clip Generator</a></li>
                    <li><a class="dropdown-item" href="/brownieval/subonlyvideos">#BrownieVAL Sub-only VODs</a></li>
                </ul>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarEvents" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Special Events
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarEvents">
                    <li><h6 class="dropdown-header">Tournaments</h6></li>
                    <li><a class="dropdown-item" href="https://brownieval.browntulstar.com" target="_blank">#BrownieVAL</a></li>
                    <li><hr class="dropdown-divider" />
                    <li><h6 class="dropdown-header">Special Streams</h6></li>
                    <li><a class="dropdown-item" href="https://subathon.browntulstar.com" target="_blank">Mini-Subathon Spectacular</a></li>
                    <li><a class="dropdown-item" href="https://birthday2024.browntulstar.com" target="_blank">Birthday Bash 2024</a></li>
                </ul>
                </li>
            </ul>
            <li class="d-flex">
NAVBAR;
// Auth_URL now handled in login file
// $auth_url = url($client_id, $redirect_url, $scopes);\
if (isset($_SESSION['user'])) {
    echo '<a href="/profile"><button class="btn btn-primary"><i class="fa-brands fa-discord"></i> ' . $_SESSION['username'] . '</button></a></li>&nbsp;<li class="d-flex"><a href="/logout.php"><button class="btn btn-danger">Logout</button></a>';
} else {
    echo "<a href='" . "/login.php" ."'><button class='btn btn-success'><i class='fa-brands fa-discord'></i> Login</button></a>";
}
echo <<<NAVBAR
            </li>
        </div>
    </div>
NAVBAR;

echo "</header>"

?>