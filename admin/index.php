<?php

$dir = dirname(__DIR__, 1);

require $dir . "/includes/admin-check.php";
require $dir . "/includes/default-includes.php";
require $dir . "/templates/header.php";

?>
<div class="container body-container">
<h1>Menu</h1>
<a href="/admin/announcement.php">Announcement</a><br>
<a href="/admin/blog.php">Blog</a><br>
<a href="/admin/debug.php">Application Debug</a><br>
<a href="/admin/phpinfo.php">PHPDebug</a><br>
<a href="/admin/store.php">Store (obsolete)</a><br>
</div>

<?php
require $dir . "/templates/footer.php";

?>