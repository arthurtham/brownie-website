<?php

echo <<<NAVBAR
    <header>
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-success">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">BrowntulStar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarSubs" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Sub Perks
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarSubs">
                    <li><a class="dropdown-item" href="/subs">Subs Home</a></li>
                    <li><a class="dropdown-item" href="/subs/blog">Blog</a></li>
                </ul>
                </li>
            </ul>
            <li class="d-flex">
NAVBAR;
$auth_url = url($client_id, $redirect_url, $scopes);
if (isset($_SESSION['user'])) {
    echo '<a class="nav-link disabled" style="color:white">Logged in using Discord as: ' . $_SESSION['username'] . '. </a><a href="/includes/logout.php"><button class="btn btn-danger">Logout</button></a>';
} else {
    echo "<a href='$auth_url'><button class='btn btn-info'>Discord Login</button></a>";
}
echo <<<NAVBAR
            </li>
        </div>
    </div>
NAVBAR;

echo "</header>"

?>