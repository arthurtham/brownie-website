<?php
$dir = dirname(__DIR__, 1);
$title = "BrowntulStar - Search";
require $dir . "/templates/header.php";
?>
<div class="container body-container">
    <h1>Website Search</h1>
    <p>What would you like to search for?</p>
    <p>All results will pull from non-sub-perk pages on browntulstar.com and its subdomains.</p>
    <hr>
    <script async src="https://cse.google.com/cse.js?cx=723c7135330e047f5">
    </script>
    <div class="gcse-searchbox"></div>
    <div class="gcse-searchresults"></div>
</div>
<?php require $dir . "/templates/footer.php" ?>