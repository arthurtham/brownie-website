<?php

$dir = dirname(__DIR__, 1);

require $dir . "/includes/admin-check.php";
require $dir . "/includes/default-includes.php";
require $dir . "/templates/header.php";

?>
<div class="container body-container">
<h1>Menu</h1>
<a class="btn btn-dark" href="/admin/announcement.php">Announcement</a><br>
<a class="btn btn-dark" href="/admin/blog.php">Blog</a><br>
<a class="btn btn-dark" href="/admin/shortlinks.php">Shortlinks</a><br>
<a class="btn btn-dark" href="/admin/debug.php">Application Debug</a><br>
<a class="btn btn-dark" href="/admin/phpinfo.php">PHPDebug</a><br>
<a class="btn btn-dark" href="/admin/debug.php">Navbar</a><br>
<a class="btn btn-dark" href="/admin/store.php">Store (obsolete)</a><br>
</div>

<?php
require $dir . "/templates/footer.php";

?>