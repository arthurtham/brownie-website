<?php

/* Home Page
* The home page of the working demo of oauth2 script.
* @author : MarkisDev
* @copyright : https://markis.dev
*/

# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);


# Including all the required scripts for demo
require dirname(__DIR__, 1) . "/includes/functions.php";
require dirname(__DIR__, 1) . "/includes/discord.php";
require dirname(__DIR__, 1) . "/config.php";
require dirname(__DIR__, 1) . "/includes/sessiontimer.php";

# ALL VALUES ARE STORED IN SESSION!
# RUN `echo var_export([$_SESSION]);` TO DISPLAY ALL THE VARIABLE NAMES AND VALUES.
# FEEL FREE TO JOIN MY SERVER FOR ANY QUERIES - https://join.markis.dev

?>

<html>

<head>
	<?php $title = "BrowntulStar - Privacy" ?>
	<?php require dirname(__DIR__, 1) . "/templates/header-includes.php" ?>
    <style>
		.body-container hr {
			margin-top:50px !important;
			margin-bottom:50px !important;
		}
	</style>
</head>

<body>
    <?php require dirname(__DIR__, 1) . "/templates/navbar.php" ?>
	<div class="container body-container" style="padding-top:50px;padding-bottom:100px">


<h1>Privacy Policy</h1>
<p>Last updated: July 10, 2022</p>
<p>The privacy policy will be updated when it is completed. However, usage of this website requires a Discord account
	when logged in, and the Discord privacy policy applies while using this website.
</p>
<p>If you have any questions about this Privacy Policy, You can contact us:</p>
<ul>
<li>By email: browntulstar@browntulstar.com</li>
</ul>


    </div>
	<?php require dirname(__DIR__, 1) . "/templates/footer.php" ?>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>