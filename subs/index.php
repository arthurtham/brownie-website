<?php
$dir = dirname(__DIR__, 1);
$title = "Turtle Pond - Perks Status";
require $dir . "/templates/header.php";
?>

<div class="container body-container-no-bg" style="padding-bottom:0 !important">
	<div class="row">
		<div class="col-md-8 offset-md-2 text-white">
			<h1 class="text-center">Turtle Pond - Perks</h1>
			<h2 class="text-center">Support and Benefit!</h2>
			<p class="text-center">The power of technology is inspirational!<br>
			Log in with your subscribed Twitch account or connect your Twitch account
			to Discord and log in with Discord to access Browntul's many perks.
			You can also view IRIAM Star Badge perks by claiming the role in the Discord server.</p>
		</div>
	</div>
<?php
if (!isset($_SESSION['user'])) {
	echo "<div class='alert alert-danger' role='alert'>
	<p><center>To access all perks, log in with a subscribed Twitch account or a Discord account with a subscribed Twitch account linked to it.</center></p>
	<p><center>To access IRIAM Star Badge perks, join the Discord server, follow the instructions to get the Discord role, and log in to this website with the same Discord account.</center></p>
	</div>";
	echo "</div>";
} else { // User is logged in
	if (false) { //(!check_guild_membership($guild_id) || !check_roles([$sub_role_id, $vip_role_id, $mod_role_id])) {
		//require dirname(__DIR__, 1) . "/templates/login-required.php";
	} else {
		require $dir . "/templates/profile-box.php";
		echo '<div class="d-flex flex-column align-items-center justify-content-center">';
		// Special box appears if the user logs in with Twitch
		if (isset($_SESSION["twitch_user_access_token"])) {
			if (check_roles(array($sub_role_id))) {
				echo <<<JOINSERVERALERT
					<div class='alert alert-success' role='alert'>
					<center><p>Thanks for subscribing! To access all perks, be sure
					to join the Discord server and link your Twitch account to your Discord profile.</p>
					</div>
JOINSERVERALERT;
			} else {
				echo <<<JOINSERVERALERT
					<div class='alert alert-danger' role='alert'>
					<center><p>Subscribe on Twitch to get perks!
					Read more below to learn how to get perks via Twitch.</p>
					</div>
JOINSERVERALERT;
			}
		}
		// Special box appears if the user logs in but is not in the Turtle Pond server
		else if (!check_guild_membership($guild_id)) {
			echo <<<JOINSERVERALERT
			<div class='alert alert-danger' role='alert'>
			<center><p>It looks like you're not in the Turtle Pond Discord server.<br>
			To access all perks, log in with a subscribed Twitch account or a Discord account with a subscribed Twitch account linked to it.<br>
			To access IRIAM Star Badge perks, join the Discord server, follow the instructions to get the Discord role, and log in to this website with the same Discord account.<br>
			Please read the FAQ below for assistance.</p>
			</div>
JOINSERVERALERT;
		}
		echo "</div></div>";
	}
}
echo <<<SUBPERKSHEADER
	<div class="container body-container" style="padding-top:48px !important">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
			<h1 class="text-center">Main Menu</h1>
SUBPERKSHEADER;
if (!check_roles($sub_perk_roles)) { print_navbar_login_items($expand=true, $center=true, $subperks=true); }
$_kofi_logo = "<img height='18' style='border:0px;height:18px;margin-top:-4px' src='https://res.cloudinary.com/browntulstar/image/private/s--mOeZPgHn--/c_pad,h_48/f_webp/v1/com.browntulstar/img/platform-kofi?_a=BAAAUWGX' border='0' alt='Buy Me a Coffee at ko-fi.com' />";
echo <<<SUBPERKSHEADER2
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-lg-12">
				<div class="row g-1">
					<div class="col-lg-6">
						<a class="btn btn-danger w-100 mb-2" href="details">
							<i class="fa-solid fa-circle-info"></i>
							More Details
						</a>
					</div>
					<div class="col-lg-6">
						<a href="#" id="navbarSubs-button" class="btn btn-success w-100 mb-2"><i class="fa-solid fa-circle-check"></i> Access Perks</a>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<a class="btn btn-dark w-100 mb-2" href="/r/discord" target="_blank">
							<i class="fa-brands fa-discord"></i>
							Join Turtle Pond Discord Server
						</a>
					</div>
				</div>
				<div class="row g-1">
					<div class="col-lg-4">
						<a class="btn btn-dark w-100 mb-2" href="https://www.twitch.tv/browntulstar" target="_blank">
							<i class="fa-brands fa-twitch"></i>
							Sub on Twitch
						</a>
					</div>
					<div class="col-lg-4">
						<a class="btn btn-dark w-100 mb-2" href='https://ko-fi.com/browntulstar' target='_blank'>
						$_kofi_logo
						Donate on Ko-fi
						</a>
					</div>
					<div class="col-lg-4">
						<a class="btn btn-dark w-100 mb-2" href='/iriam'>
						<img style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/upload/com.browntulstar/img/iriam-logo.svg">
						Gift on IRIAM
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
SUBPERKSHEADER2;

?>
<?php require $dir . "/templates/footer.php" ?>