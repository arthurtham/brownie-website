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
        <button disabled style="width:100px" class="btn btn-primary mb-2">Content</button>
        <a class="btn btn-dark mb-2" href="/admin/announcement.php">Announcements Editor</a>
        <a class="btn btn-dark mb-2" href="/admin/blog.php">Blog Editor</a>
        <a class="btn btn-dark mb-2" href="/admin/guide.php">Guide Editor</a>
        <a class="btn btn-dark mb-2" href="/admin/shop.php">Shop Editor</a>
        <a class="btn btn-dark mb-2" href="/admin/iriam_rewards.php">IRIAM Rewards Editor</a>
    </li>
    <li class="mb-2">
        <button disabled style="width:100px" class="btn btn-primary mb-2">Links</button>
        <a class="btn btn-dark mb-2" href="/admin/alert.php">Alert Post</a>
        <a class="btn btn-dark mb-2" href="/admin/shortlinks.php">Shortlinks</a>
        <a class="btn btn-dark mb-2" href="/admin/artist.php">Artist (Credits)</a>
        <a class="btn btn-dark mb-2" href="/admin/navbar.php">Navbar Contents</a>
    </li>
    <li class="mb-2">
        <button disabled style="width:100px" class="btn btn-primary mb-2">Tools</button>
        <a class="btn btn-dark mb-2" href="/admin/cloudinary.php">Cloudinary Media Signer</a>
    </li>
    <li class="mb-2">
        <button disabled style="width:100px" class="btn btn-primary mb-2">Debug</button>
        <a class="btn btn-dark mb-2" href="/admin/debug.php">Application Debug</a>
        <a class="btn btn-dark mb-2" href="/admin/phpinfo.php">PHPDebug</a>
    </li>
</ul>
</div>

<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>