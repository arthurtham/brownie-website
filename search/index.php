<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Search";
require $dir . "/templates/header.php";
?>
<div class="container body-container">
    <h1>Domain-wide Search</h1>
    <p>Search across all pages on browntulstar.com and its subdomains.</p>
    <p>To search for specific blog posts, please visit the <a href="/subs/blog">blog page</a>.</p>
    <hr>
    <script async src="https://cse.google.com/cse.js?cx=723c7135330e047f5">
    </script>
    <div class="gcse-searchbox"></div>
    <div class="gcse-searchresults"></div>
</div>
<?php require $dir . "/templates/footer.php" ?>