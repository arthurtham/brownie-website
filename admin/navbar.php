<?php

$dir = dirname(__DIR__, 1);
$title = "Navbar";
require $dir . "/includes/admin-check.php";
require $dir . "/includes/default-includes.php";

require $dir . "/templates/header.php";
?>

<div class="container body-container">
    <h1>Navbar Contents</h1>
    <p>Whoever reads this on GitHub is probably super excited, but all this does is
        export the <strong>navbar_contents</strong> data structure for the navbar.
    </p>
    <xmp style="white-space: pre-wrap"><?php
    $file = file_get_contents($dir . "/templates/navbar-contents.php");
    print_r($file);
?></xmp>
    
</div>
<?php
$_footer_adminmode = true;
require $dir . "/templates/footer.php";

?>