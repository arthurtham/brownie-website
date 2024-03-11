<?php
$dir = dirname(__DIR__, 1);
$title = "Turtle Pond - Sub Perks";
require $dir . "/templates/header.php";
?>
<?php
echo '<div class="container body-container-no-bg" style="padding-bottom:0 !important">';
if (!isset($_SESSION['user'])) {
	echo "<div class='alert alert-danger' role='alert'>
	<center>To view which Discord roles that you have that unlock sub perks, you need to log in to Discord first.</center>
	</div>";
	echo '<h1 class="text-center text-white">Turtle Pond - Sub Perks</h1>';
	echo "</div>";
} else { // User is logged in
	if (false) { //(!check_guild_membership($guild_id) || !check_roles([$sub_role_id, $vip_role_id, $mod_role_id])) {
		//require dirname(__DIR__, 1) . "/templates/login-required.php";
	} else {
		echo '<div class="d-flex flex-column align-items-center justify-content-center"';
		echo '<p><h1 class="text-center text-white">Turtle Pond - Sub Perks</h1></p>';
		// Special box appears if the user logs in but is not in the Turtle Pond server
		if (isset($_GET["joinserver"])) {
			echo <<<JOINSERVERALERT
			"<div class='alert alert-danger' role='alert'>
			<center><p>It looks like you're not in the Turtle Pond Discord server.
			You must join the server in order to sync your Discord roles and activate your
			sub perks on the website. Please scroll down for more information and for the join links; then,
			log out and log back in again to check your perks.</p>
			<p><a class="btn btn-dark w-100 shadow" href="/discord" target="_blank" style="max-width:400px">
			<i class="fa-brands fa-discord"></i>
			Join Turtle Pond Discord Server
			</a></p></center>
			</div>"
JOINSERVERALERT;
		}
		require $dir . "/templates/profile-box.php";
		echo "</div></div>";
	}
}
// FAQ
$faqitems = array(
	array(
		"title" => "<i class='fa-brands fa-discord'></i> - How do I get the website to recognize my sub perks?",
		"contents" => "Here are the conditions:<ul>
		<li>You must be a member of the Turtle Pond Discord server.</li>
		<li>You must have one of these criteria satisfied:</li>
		<ul>
			<li>You have your Twitch account linked to your Discord account (Discord connections), and you're subscribed to Browntul on Twitch.</li>
			<li>You have your Discord account linked to your Ko-fi account, and you're subscribed to Browntul on Ko-fi. One-time donations do not satisfy this criteria- only recurring subscriptions do.</li>
			<li>Browntul himself has given you the VIP role in Turtle Pond.</li>
		</ul>
		<li>The criteria above must be satisfied by the time you log in to this website.</li>
		</ul>
		<br />
		<p><a class='btn btn-dark w-100' href='/discord' target='_blank' style='max-width:400px'>
			<i class='fa-brands fa-discord'></i>
			Join Turtle Pond Discord Server
			</a></p>
		"
	),
	array(
		"title" => "<i class='fa-brands fa-twitch'></i>
		- How do I link my subscribed Twitch account to my Discord account?",
		"contents" => "<p>Please go to <a target='_blank' href='https://support.discord.com/hc/en-us/articles/212112068-Twitch-Integration-FAQ#h_01GBQS0GVMV8ERXGH2QK1VXA4D'>this link</a> to learn how to connect your Twitch account to Discord. Once your account is linked, you will see your Twitch account in the Discord connections page. It may take up to 24 hours for your subscription to be recognized on Discord.</p>
		<p>If you're not subscribed on Twitch, you can do so here:</p>
		<p><a class='btn btn-dark w-100' href='https://www.twitch.tv/browntulstar/' target='_blank' style='max-width:400px'>
		<i class='fa-brands fa-twitch'></i>
		Visit Twitch Page
		</a></p>"
	),
	array(
		"title" => "<img style='border:0px;height:14px;' src='https://res.cloudinary.com/browntulstar/image/private/c_pad,h_48/com.browntulstar/img/platform-kofi.webp' border='0' alt='Buy Me a Coffee at ko-fi.com' /> - How do I link my Discord account to my subscribed Ko-fi account?",
		"contents" => "<p>Please go to <a target='_blank' href='https://help.ko-fi.com/hc/en-us/articles/8664701197073-How-do-I-join-a-Creator-s-Discord#h_01H9FYE7RQD1RF4D4CN4S5JVE3'>this link</a> to learn how to connect your Ko-fi account to Discord. After connecting your accounts, your role will be granted immediately.</p>
		<p>Here is the link to the Ko-fi for your convenience. The option to link your Discord to Ko-fi should appear on the top left for Desktop users.</p>
		<p><a class='btn btn-dark w-100' href='https://ko-fi.com/browntulstar' target='_blank' style='max-width:400px'>
		<img height='24' style='border:0px;height:24px;' src='https://storage.ko-fi.com/cdn/kofi4.png?v=3' border='0' alt='Buy Me a Coffee at ko-fi.com' />
		Visit Ko-fi Page
	</a></p>"
	),
	array(
		"title" => "Are there other ways to get sub perks?",
		"contents" => "<p>Currently, the only way to get sub perks is to link your subscribed Twitch and Ko-fi accounts, or get a VIP role from Browntul on Discord. There are no other ways.</p>"
	),
	array(
		"title" => "I did everything above, but I'm not getting my perks!",
		"contents" => "<p>Please wait for up to 24 hours for all the Discord connections to sync on Twitch and Ko-fi.</p>
		<p>Please also try to log out and log back in again.</p>
		<p>If you still don't have your sub perks, please ping @Browntul on Discord in the #turtle-party channel or <a href='browntulstar@browntulstar.com' target='_blank'>email Browntul</a> with your Discord username.</p>"
	),
);
echo <<<SUBPERKSHEADER
	<div class="container body-container" style="padding-top:48px !important">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<h1 class="text-center">Sub Perks Links</h1>
				<a class="btn btn-dark w-100 mb-2" href="https://www.twitch.tv/browntulstar" target="_blank">
					<i class="fa-brands fa-twitch"></i>
					Subscribe on Twitch
				</a>
				<a class="btn btn-dark w-100 mb-2" href='https://ko-fi.com/browntulstar' target='_blank'>
					<img height='24' style='border:0px;height:24px;' src='https://storage.ko-fi.com/cdn/kofi4.png?v=3' border='0' alt='Buy Me a Coffee at ko-fi.com' />
					Join on Ko-fi
				</a>
				<a class="btn btn-dark w-100 mb-2" href="/discord" target="_blank">
					<i class="fa-brands fa-discord"></i>
					Join Turtle Pond Discord Server
				</a>
				<a class="btn btn-dark w-100 mb-2" href="/store/?tab=donate">
					More Ways to Donate (no perks)
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<hr/>
SUBPERKSHEADER;
			require $dir . "/templates/sub-perks-description.php";
echo <<<SUBPERKSHEADER2
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<hr/>
				<h1 class="text-center">Sub Perks FAQ</h1>
					<div class="accordion" id="accordionFAQ">'
SUBPERKSHEADER2;
for ($_i = 0; $_i < count($faqitems); ++$_i) {
	$title = $faqitems[$_i]["title"];
	$contents = $faqitems[$_i]["contents"];
	echo <<<SUBPERKSFAQ
					<div class="accordion-item">
						<h2 class="accordion-header">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse$_i" aria-expanded="false" aria-controls="collapse$_i">
						$title
						</button>
						</h2>
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