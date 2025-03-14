<?php

$dir = dirname(__DIR__, 1);
$title = "Admin";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";

?>
<div class="container body-container">
<h1>Menu</h1>
<p>Please use a Desktop computer for optimal viewing</p>
<ul>
    <li><a class="btn btn-dark" href="/admin/announcement.php">Announcement</a></li>
    <li><a class="btn btn-dark" href="/admin/blog.php">Blog</a></li>
    <li><a class="btn btn-dark" href="/admin/guide.php">Guide</a></li>
    <li><a class="btn btn-dark" href="/admin/cloudinary.php">Cloudinary Media Signer</a></li>
    <li><a class="btn btn-dark" href="/admin/shortlinks.php">Shortlinks</a></li>
    <li><a class="btn btn-dark" href="/admin/debug.php">Application Debug</a></li>
    <li><a class="btn btn-dark" href="/admin/phpinfo.php">PHPDebug</a></li>
    <li><a class="btn btn-dark" href="/admin/navbar.php">Navbar</a></li>
    <li><a class="btn btn-dark" href="/admin/store.php">Store (obsolete)</a></li>
</ul>
</div>

<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>