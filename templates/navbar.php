<?php

echo <<<NAVBAR
    <header>
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">BrowntulStar</a>
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
                    <li><hr class="dropdown-divider" />
                    <li><h6 class="dropdown-header">Portfolio</h6></li>
                    <li><a class="dropdown-item disabled">Games</a></li>
                    <li><a class="dropdown-item disabled">Shoutcasting</a></li>
                </ul>
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
                </ul>
                </li>
            </ul>
            <li class="d-flex">
NAVBAR;
$auth_url = url($client_id, $redirect_url, $scopes);
if (isset($_SESSION['user'])) {
    echo '<button class="btn btn-primary">Hello, ' . $_SESSION['username'] . '!</a></li>&nbsp;<li class="d-flex"><a href="/logout.php"><button class="btn btn-danger">Logout</button></a>';
} else {
    echo "<a href='$auth_url'><button class='btn btn-success'>Discord Login</button></a>";
}
echo <<<NAVBAR
                &nbsp;<a href="/discord"><button class='btn btn-primary' style='background-color:#5865F2 !important'>Turtle Pond Server</button></a>
            </li>
        </div>
    </div>
NAVBAR;

echo "</header>"

?>