<?php

echo <<<NAVBAR
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">BrowntulStar</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/subs">Subs</a>
                </li>
            </ul>
            <li class="d-flex">
NAVBAR;
$auth_url = url($client_id, $redirect_url, $scopes);
if (isset($_SESSION['user'])) {
    echo '<a href="/includes/logout.php"><button class="btn btn-danger">LOGOUT</button></a>';
} else {
    echo "<a href='$auth_url'><button class='btn btn-success'>LOGIN</button></a>";
}
echo <<<NAVBAR
            </li>
        </div>
    </div>
NAVBAR;
        
echo "</header>"

?>