<?php
$dir = dirname(__DIR__, 2);
$title = "Turtle Pond - Perks Hub";
require $dir . "/templates/header.php";
?>
<?php
$_kofi_logo = "<img height='18' style='border:0px;height:18px;margin-top:-4px' src='https://res.cloudinary.com/browntulstar/image/private/s--mOeZPgHn--/c_pad,h_48/f_webp/v1/com.browntulstar/img/platform-kofi?_a=BAAAUWGX' border='0' alt='Buy Me a Coffee at ko-fi.com' />";

echo '<div class="container body-container">';

echo '<div class="d-flex flex-column align-items-center justify-content-center">';
echo '<p><h1 class="text-center">Turtle Pond - Perks FAQ</h1></p>';

// FAQ
$_kofi_logo = "<img height='18' style='border:0px;height:18px;margin-top:-4px' src='https://res.cloudinary.com/browntulstar/image/private/s--mOeZPgHn--/c_pad,h_48/f_webp/v1/com.browntulstar/img/platform-kofi?_a=BAAAUWGX' border='0' alt='Buy Me a Coffee at ko-fi.com' />";
$faqitems = array(
	array(
		"title" => "<span style='width:20px'><i class='fa-brands fa-discord'></i></span>
		&nbsp;How do I use my Discord account to access perks?",
		"contents" => "Here are the conditions for Discord users:<ul>
		<li>You must be a member of the Turtle Pond Discord server.</li>
		<li>You must have one of these criteria satisfied:</li>
		<ul>
			<li>You have your Twitch account linked to your Discord account (Discord connections), and you're subscribed to Browntul on Twitch.</li>
			<li>You achieved a ★ Star Badge reward on IRIAM and claimed the corresponding IRIAM ★ Star Badge role in the Discord server.</li>
			<li>Browntul himself has given you the VIP role in Turtle Pond.</li>
		</ul>
		<li>The criteria above must be satisfied by the time you log in to this website.</li>
		</ul>
		<p>To learn how to connect your Twitch account to Discord or claim the IRIAM Discord role, please see the sections below.</p>
		<br />
		<p><a class='btn btn-dark w-100' href='/discord' target='_blank' style='max-width:400px'>
			<i class='fa-brands fa-discord'></i>
			Join Turtle Pond Discord Server
			</a></p>
		"
	),
	array(
		"title" => "<span style='width:20px'><i class='fa-brands fa-twitch'></i>
		</span>&nbsp;How do I use my subscribed Twitch account to access perks?",
		"contents" => "<p>Please go to <a target='_blank' href='https://support.discord.com/hc/en-us/articles/212112068-Twitch-Integration-FAQ#h_01GBQS0GVMV8ERXGH2QK1VXA4D'>this link</a> to learn how to connect your Twitch account to Discord. Once your account is linked, you will see your Twitch account in the Discord connections page. It may take up to 24 hours for your subscription to be recognized on Discord. Then, log out and log back in to this website to access your perks.</p>
		<p>Alternatively, simply log in with your Twitch account instead of Discord to access perks. This only applies to users that are actively subscribed on Twitch (no VIPs or other special roles).</p>
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
		"title" => "<span style='width:20px'><img style=\"height:20px;margin-top:-4px\" src=\"https://res.cloudinary.com/browntulstar/image/upload/com.browntulstar/img/iriam-logo.svg\">
		</span>&nbsp;How do I access my IRIAM Star Reward Perks?",
		"contents" => "
		<p>IRIAM is a virtual reality live streaming platform where you can watch and interact with your favorite VTubers in real-time. You can watch them exclusively on your mobile smartphone device or tablet.</p>
		<p>You can learn more about IRIAM by clicking on the IRIAM button below. An IRIAM account is required to gain IRIAM ★ Star Badge roles.</p>
		<p>To access your IRIAM ★ Star Badge rewards, you must have one of the <strong>STARS</strong> roles in the Turtle Pond Discord server. You can claim these roles by going to the #iriam-★badge-assign text channel and following the instructions. After you are assigned the proper roles, log out and log back in to this website with your Discord account and visit the IRIAM link below.</p>
		
		<p><a class=\"btn btn-info mb-2 w-100 shadow\" href='/iriam' style=\"max-width:400px\">
			<img style=\"height:20px;margin-top:-4px\" src=\"https://res.cloudinary.com/browntulstar/image/upload/com.browntulstar/img/iriam-logo.svg\">
			Learn more about IRIAM
		</a></p>
		<p><a class='btn btn-dark w-100' href='/discord' target='_blank' style='max-width:400px'>
			<i class='fa-brands fa-discord'></i>
			Join Turtle Pond Discord Server
			</a></p>
		
		"
	),
	array(
		"title" => "Are there other ways to get perks?",
		"contents" => "<p>Currently, the only way to get perks is to link your subscribed Twitch accounts to Discord and join the Turtle Pond server; log in with Twitch directly; get a IRIAM ★ Star Badge and claim the corresponding Discord role in the Turtle Pond server;
		or get a VIP role from Browntul in the Turtle Pond Discord server. There are no other ways.</p>"
	),
	array(
		"title" => "I did everything above, but I'm not getting my perks!",
		"contents" => "<p>Please wait for up to 24 hours for all the Discord connections to sync on Twitch.</p>
		<p>Please make sure that if you're an IRIAM ★ Star Badge holder that you also received the corresponding role in the Discord server.</p>
		<p>Please also try to log out and log back in again.</p>
		<p>If you still don't have your perks, please ping @Browntul on Discord in the #turtle-party channel or <a href='/contact' target='_blank'>email Browntul</a> with your Discord username.</p>"
	),
);
echo <<<SUBPERKSHEADER2
	<div class="row w-100">
		<div class="col-lg-12">
			<p class="text-center"><a class="btn btn-success mb-2 w-100" href="/subs" style="max-width:300px">
				<i class="fa-solid fa-circle-check"></i>
				Back to Perks Info
			</a></p>
			<hr>
			<div class="row mb-2">
				<div class="col-lg-12">
SUBPERKSHEADER2;
			require $dir . "/templates/sub-perks-description.php";
echo <<<SUBPERKSHEADER2
				</div>
			</div>	
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
					<div id="collapse$_i" class="accordion-collapse collapse">
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
</div>
</div>';
?>
<?php require $dir . "/templates/footer.php" ?>