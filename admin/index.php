<?php

$dir = dirname(__DIR__, 1);
$title = "Admin";
require $dir . "/includes/admin-check.php";
require $dir . "/templates/header.php";

?>
<div class="container body-container">
<h1>Menu</h1>
<p>Please use a Desktop computer for optimal viewing.</p>
<ul>
    <li class="mb-2">
        <button disabled style="width:100px" class="btn btn-primary">Content</button>
        <a class="btn btn-dark" href="/admin/announcement.php">Announcements Editor</a>
        <a class="btn btn-dark" href="/admin/blog.php">Blog Editor</a>
        <a class="btn btn-dark" href="/admin/guide.php">Guide Editor</a>
        <a class="btn btn-dark" href="/admin/shop.php">Shop Editor</a>
    </li>
    <li class="mb-2">
        <button disabled style="width:100px" class="btn btn-primary">Links</button>
        <a class="btn btn-dark" href="/admin/shortlinks.php">Shortlinks</a>
        <a class="btn btn-dark" href="/admin/artist.php">Artist (Credits)</a>
        <a class="btn btn-dark" href="/admin/navbar.php">Navbar Contents</a>
    </li>
    <li class="mb-2">
        <button disabled style="width:100px" class="btn btn-primary">Tools</button>
        <a class="btn btn-dark" href="/admin/cloudinary.php">Cloudinary Media Signer</a>
    </li>
    <li class="mb-2">
        <button disabled style="width:100px" class="btn btn-primary">Debug</button>
        <a class="btn btn-dark" href="/admin/debug.php">Application Debug</a>
        <a class="btn btn-dark" href="/admin/phpinfo.php">PHPDebug</a>
    </li>
</ul>
</div>

<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>