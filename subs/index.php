<?php
$dir = dirname(__DIR__, 1);
$title = "Turtle Pond - Sub Status";
require $dir . "/templates/header.php";
?>

<div class="container body-container-no-bg" style="padding-bottom:0 !important">
	<div class="row">
		<div class="col-md-8 offset-md-2 text-white">
			<h1 class="text-center">Turtle Pond - Sub Perks</h1>
			<h2 class="text-center">Subscribe and Benefit!</h2>
			<p class="text-center">The power of technology is inspirational!<br>
			Log in with your subscribed Twitch account, or connect your Twitch/Ko-fi account
			to Discord and log in with Discord to access Browntul's many sub perks.</p>
		</div>
	</div>
<?php
if (!isset($_SESSION['user'])) {
	echo "<div class='alert alert-danger' role='alert'>
	<center>To access all sub perks, log in with a subscribed Twitch account or a Discord account with a subscribed Twitch/Ko-fi account linked to it.</center>
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
					<center><p>Thanks for subscribing! To access all sub perks, be sure
					to join the Discord server and link your Twitch account to your Discord profile.</p>
					</div>
JOINSERVERALERT;
			} else {
				echo <<<JOINSERVERALERT
					<div class='alert alert-danger' role='alert'>
					<center><p>Subscribe on Twitch to get sub perks!
					Read more below to learn how to get sub perks via Twitch.</p>
					</div>
JOINSERVERALERT;
			}
		}
		// Special box appears if the user logs in but is not in the Turtle Pond server
		else if (!check_guild_membership($guild_id)) {
			echo <<<JOINSERVERALERT
			<div class='alert alert-danger' role='alert'>
			<center><p>It looks like you're not in the Turtle Pond Discord server.
			To access all sub perks, log in with a subscribed Twitch account or a Discord account with a subscribed Twitch/Ko-fi account linked to it.
			Please read the FAQ below for assistance.</p>
			</div>
JOINSERVERALERT;
		}
		echo "</div></div>";
	}
}
// FAQ
$_kofi_logo = "<img height='18' style='border:0px;height:18px;margin-top:-4px' src='https://res.cloudinary.com/browntulstar/image/private/s--mOeZPgHn--/c_pad,h_48/f_webp/v1/com.browntulstar/img/platform-kofi?_a=BAAAUWGX' border='0' alt='Buy Me a Coffee at ko-fi.com' />";
$faqitems = array(
	array(
		"title" => "What are in the sub perks?",
		"contents" => '<p><a class="btn btn-danger w-100 mb-2" style="max-width:300px" href="perks">
							<i class="fa-solid fa-circle-info"></i>
							Sub Perks Details
						</a></p>'
	),
	array(
		"title" => "<i class='fa-brands fa-discord'></i>
		How do I use my Discord account to access perks?",
		"contents" => "Here are the conditions for Discord users:<ul>
		<li>You must be a member of the Turtle Pond Discord server.</li>
		<li>You must have one of these criteria satisfied:</li>
		<ul>
			<li>You have your Twitch account linked to your Discord account (Discord connections), and you're subscribed to Browntul on Twitch.</li>
			<li>You have your Ko-fi account linked to your Discord account on Ko-fi's website, and you're a recurring subscriber to Browntul on Ko-fi.</li>
			<li>Browntul himself has given you the VIP role in Turtle Pond.</li>
		</ul>
		<li>The criteria above must be satisfied by the time you log in to this website.</li>
		</ul>
		<p>To learn how to connect your Twitch or Ko-fi accounts to Discord, please see the sections below.</p>
		<br />
		<p><a class='btn btn-dark w-100' href='/discord' target='_blank' style='max-width:400px'>
			<i class='fa-brands fa-discord'></i>
			Join Turtle Pond Discord Server
			</a></p>
		"
	),
	array(
		"title" => "<i class='fa-brands fa-twitch'></i>
		How do I use my subscribed Twitch account to access perks?",
		"contents" => "<p>Please go to <a target='_blank' href='https://support.discord.com/hc/en-us/articles/212112068-Twitch-Integration-FAQ#h_01GBQS0GVMV8ERXGH2QK1VXA4D'>this link</a> to learn how to connect your Twitch account to Discord. Once your account is linked, you will see your Twitch account in the Discord connections page. It may take up to 24 hours for your subscription to be recognized on Discord. Then, log out and log back in to this website to access your perks.</p>
		<p>Alternatively, simply log in with your Twitch account instead of Discord to access sub perks. This only applies to users that are actively subscribed on Twitch (no VIPs or other special roles).</p>
		<p>If you're not subscribed on Twitch, you can do so here:</p>
		<p><a class='btn btn-dark w-100' href='https://www.twitch.tv/browntulstar/' target='_blank' style='max-width:400px'>
		<i class='fa-brands fa-twitch'></i>
		Visit Twitch Page
		</a></p>
		<p><a class='btn btn-dark w-100' href='/discord' target='_blank' style='max-width:400px'>
			<i class='fa-brands fa-discord'></i>
			Join Turtle Pond Discord Server
			</a></p>"
	),
	array(
		"title" => "<img style='border:0px;height:14px;' src='https://res.cloudinary.com/browntulstar/image/private/s--mOeZPgHn--/c_pad,h_48/f_webp/v1/com.browntulstar/img/platform-kofi?_a=BAAAUWGX' border='0' alt='Buy Me a Coffee at ko-fi.com' /> 
		How do I link my Discord account to my subscribed Ko-fi account?",
		"contents" => "<p>Please go to <a target='_blank' href='https://help.ko-fi.com/hc/en-us/articles/8664701197073-How-do-I-join-a-Creator-s-Discord#h_01H9FYE7RQD1RF4D4CN4S5JVE3'>this link</a> to learn how to connect your Ko-fi account to Discord. After connecting your accounts, your role will be granted immediately. Then, log out and log back in to this website to access your perks.</p>
		<p>Please note that one-time donations do not satisfy this criteria- only recurring subscriptions do.</p>
		<p>Here is the link to the Ko-fi page. The option to link your Discord to Ko-fi should appear on the top left for Desktop users.</p>
		<p><a class='btn btn-dark w-100' href='https://ko-fi.com/browntulstar' target='_blank' style='max-width:400px'>
		$_kofi_logo
		Visit Ko-fi Page
		</a></p>
		<p><a class='btn btn-dark w-100' href='/discord' target='_blank' style='max-width:400px'>
				<i class='fa-brands fa-discord'></i>
				Join Turtle Pond Discord Server
				</a></p>
		"
	),
	array(
		"title" => "Are there other ways to get sub perks?",
		"contents" => "<p>Currently, the only way to get sub perks is to link your subscribed Twitch and/or Ko-fi accounts to Discord and join the Turtle Pond server; log in with Twitch directly; 
		or get a VIP role from Browntul on Discord. There are no other ways.</p>"
	),
	array(
		"title" => "I did everything above, but I'm not getting my perks!",
		"contents" => "<p>Please wait for up to 24 hours for all the Discord connections to sync on Twitch and Ko-fi.</p>
		<p>Please also try to log out and log back in again.</p>
		<p>If you still don't have your sub perks, please ping @Browntul on Discord in the #turtle-party channel or <a href='/contact' target='_blank'>email Browntul</a> with your Discord username.</p>"
	),
);
echo <<<SUBPERKSHEADER
	<div class="container body-container" style="padding-top:48px !important">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
			<h1 class="text-center">Main Menu</h1>
SUBPERKSHEADER;
if (!check_roles($sub_perk_roles)) { print_navbar_login_items($expand=true, $center=true, $subperks=true); }
echo <<<SUBPERKSHEADER2
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<div class="row">
					<div class="col-lg-12">
						<a class="btn btn-danger w-100 mb-2" href="perks">
							<i class="fa-solid fa-circle-info"></i>
							Sub Perks Details
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<a href="#" id="navbarSubs-button" class="btn btn-success w-100 mb-2"><i class="fa-solid fa-circle-check"></i> Access Sub Perks</a>
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
				<div class="row">
					<div class="col-lg-6">
						<a class="btn btn-dark w-100 mb-2" href="https://www.twitch.tv/browntulstar" target="_blank">
							<i class="fa-brands fa-twitch"></i>
							Sub on Twitch
						</a>
					</div>
					<div class="col-lg-6">
						<a class="btn btn-dark w-100 mb-2" href='https://ko-fi.com/browntulstar' target='_blank'>
						$_kofi_logo Join on Ko-fi
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<hr/>
					<center><h2>FAQ: Link Subscribed Account</h2></center>
					<div class="accordion" id="accordionFAQ">
SUBPERKSHEADER2;
for ($_i = 0; $_i < count($faqitems); ++$_i) {
	$title = $faqitems[$_i]["title"];
	$contents = $faqitems[$_i]["contents"];
	echo <<<SUBPERKSFAQ
					<div class="accordion-item">
						<p class="accordion-header">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse$_i" aria-expanded="false" aria-controls="collapse$_i">
						$title
						</button>
						</p>
						<div id="collapse$_i" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
						<div class="accordion-body">
							$contents
						</div>
						</div>
					</div>
SUBPERKSFAQ;
}
echo '
				</div>
			</div>
		</div>
	</div>'
?>
<?php require $dir . "/templates/footer.php" ?>