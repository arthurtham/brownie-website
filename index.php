<?php
$dir = __DIR__;
$title = "BrowntulStar - Home";

require $dir . "/templates/header.php"
?>
<div class="container-fluid body-container-home">
	<div id="center-block" class="d-flex align-items-center justify-content-center" style="padding-top:50px">
		<center><img name="home-logo" id="home-logo" class="home-logo shiny" src="https://res.cloudinary.com/browntulstar/image/private/s--gRiI4zsg--/c_pad,h_400/e_shadow/com.browntulstar/img/browntulstar-logo-v2-large.png" />
			<div class="box bg-gradient shadow rounded text-center" style="background-color: rgba(255,255,255,0.2); padding: 20px; width:100%; max-width:500px">
				<div class="row">
					<div class="col-sm-12 p-1">
						<span class="d-flex flex-row">
						<a class="btn btn-twitch w-100" href="/stream">
							<i class="fa-brands fa-twitch"></i>
							Twitch
						</a>
						</span>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8 p-1">
						<span class="d-flex flex-row">
							<a class="btn btn-info w-100" href="/iriam">
								<img style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/upload/s--UJNCDZjT--/c_scale,w_200,h_200/f_webp/v1/com.browntulstar/img/iriam-logo.webp?_a=BAAAV6E0">
								<strong>IRIAM</strong>
							</a>
						</span>
					</div>
					<div class="col-sm-4 p-1">
						<span class="d-flex flex-row">
							<a class="btn btn-info w-100" href="/subs/iriam-rewards/">
								<strong>Rewards</strong>
							</a>
						</span>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 p-1">
						<span class="d-flex flex-row">
							<a href="/subs" class="btn btn-success w-100"><i class="fa-solid fa-circle-check"></i> Perks Hub</a>
						</span>
					</div>
					<div class="col-sm-3 p-1">
						<span class="d-flex flex-row">
							<a href="/subs/blog" class="btn btn-success w-100">Blog</a>
						</span>
					</div>
					<div class="col-sm-3 p-1">
						<span class="d-flex flex-row">
							<a href="/discord" class="btn btn-light w-100"><i class="fa-brands fa-discord"></i> Server</a>
						</span>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4 p-1">
						<span class="d-flex flex-row">
							<a href="/app" class="btn btn-dark w-100">Apps/Games</a>
						</span>
					</div>
					<div class="col-sm-4 p-1">
						<span class="d-flex flex-row">
							<a href="/announcements" class="btn btn-dark w-100">Browntul Says</a>
						</span>
					</div>
					<div class="col-sm-4 p-1">
						<span class="d-flex flex-row">
							<a href="/guides" class="btn btn-dark w-100">Guides</a>
						</span>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4 p-1">
						<span class="d-flex flex-row">
							<a href="#home-section-about" class="btn btn-dark w-100">About</a>
						</span>
					</div>
					<div class="col-sm-4 p-1">
						<span class="d-flex flex-row">
							<a href="credits" class="btn btn-dark w-100">Credits</a>
						</span>
					</div>
					<div class="col-sm-4 p-1">
						<span class="d-flex flex-row">
							<a href="/store" class="btn btn-dark w-100">Shop</a>
						</span>
					</div>
				</div>
				<div class="row pt-2">
					<span class="w-100"><small> 
					<a href="https://browntulstar.com/r/links" class="text-black" style="text-decoration: none" target="_blank">Socials: @browntulstar</a>
					</small></span>
				</div>
				</div>
		</center>
	</div>
</div>
<div class="container-fluid">
	<div id="home-section-about" class="row py-5 home-div-row" style="background-image: url('https://res.cloudinary.com/browntulstar/image/private/s--zCA0sKlO--/e_blur:300/c_scale,h_1080/f_webp/com.browntulstar/img/credits-portfolio-nary.png')">
		<div class="col-md-12 home-div-col">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-2">	
						<center><img loading="lazy" class="bg-light mb-4 shadow" src="https://res.cloudinary.com/browntulstar/image/private/s--Gq5rx5qg--/c_mpad,h_300,w_300/com.browntulstar/img/turtleyear-sm.png" style="border-radius: 100%;width:auto;max-width:min(300px, 70vw)" /></center>
						<div class="card mx-auto">
							<div class="card-body">
								<h1 class="card-title text-center">About Me</h1>
								<p class="text-center">I'm a content creator, event organizer, esports commentator/producer, and software programmer. You might know me as the host of a community VALORANT tournament named #BrownieVAL.
								</p>
								<p class="text-center">I first started streaming on Twitch in August of 2019, and on IRIAM in June of 2025.
									You'll find my Killjoy turtle PNGTuber hanging out in my comfy bedroom, tinkering with new stream widgets and coding up new software for my turtle shells to enjoy.
								</p>
								<p class="text-center">As a support staff in esports events online and IRL, I'm your go-to person to help with event organization and execution. With over 5 years of experience, I've worked in fast-paced adaptable environments to ensure smooth operations and a great experience for the true stars of the show: the players. Ultimately, I hope to provide opportunities for newcomers in the esports space to experience the thrill of competitive gaming in more intimate community environments.
								</p>
								<div class="text-center">
								<a class="btn btn-dark m-2 shadow" href="/discord" style="max-width:400px">
									<i class="fa-brands fa-discord"></i>
									Discord Server
								</a> 
								<a class="btn btn-dark m-2 shadow" href='/r/links' style="max-width:400px">
									<i class="fa-solid fa-link"></i> 
									Links/Socials
								</a>
								<a class="btn btn-dark m-2 shadow" href="/coding" style="max-width:400px">
									<i class="fa-solid fa-video"></i>
									Coding Portfolio
								</a> 
								<a class="btn btn-dark m-2 shadow" href="/esports" style="max-width:400px">
									<i class="fa-solid fa-video"></i>
									Esports Portfolio
								</a> 
								<a class="btn btn-dark m-2 shadow" href="/credits" style="max-width:400px">
									<i class="fa-solid fa-paintbrush"></i>
									Art and Stream Credits
								</a> 
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row py-5 home-div-row" style="background-image: url('https://res.cloudinary.com/browntulstar/image/upload/s--SD3W6uDR--/f_webp/f_png/v1/com.browntulstar/img/brownieval-background-v1?_a=BAAAUWGX')">
		<div class="col-md-12 home-div-col">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-2">	
						<center><img loading="lazy" class="bg-light mb-4 shadow" src="https://res.cloudinary.com/browntulstar/image/private/s--y9zZhHfd--/ar_1:1,c_scale,h_400/f_webp/com.browntulstar/img/brownieval-logo-v1.png" style="border: 3px solid black; border-radius: 100%;width:auto;max-width:min(300px, 70vw)" /></center>
						<div class="card mx-auto">
							<div class="card-body">
								<h1 class="card-title text-center">#BrownieVAL</h1>
								<p class="text-center">#BrownieVAL is a series of cross-community events hosted by Browntul featuring
									small communities bonding together in a tournament-like environment. Players come
									together in a cross-rank, for-fun experience where they can represent their community
									leaders and foster friends with their sister communities, all while working their way
									towards championship glory.
								</p>
								<div class="text-center">
								<a class="btn btn-dark m-2 shadow" href='https://brownieval.browntulstar.com/' target='_blank' style="max-width:400px">
									<img class='rounded' style='height:18px;margin-top:-4px' src='https://res.cloudinary.com/browntulstar/image/private/s--fcXDbYLp--/f_webp/v1/com.browntulstar/img/brownieval-logo-v1?_a=BAAAUWGX'> <i class="fa-solid fa-link"></i> Website
								</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row py-5 home-div-row brownie-gray">
		<div class="col-md-12 home-div-col">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1 class="text-center text-white">By The Numbers</h1>
					</div>
				</div>
				<div class="row mt-2 mb-2">
					<div class="col-md-4 mb-2">
						<a href="/stream" type="button" class="btn btn-twitch btn-lg w-100 py-4">
							<h2>1.3k Followers</h2>
							<i class="fa-brands fa-twitch"></i> Twitch
						</a>
					</div>
					<div class="col-md-4 mb-2">
						<a href="/iriam" type="button" class="btn btn-info btn-lg w-100 py-4">
							<h2>300 Followers</h2>
							<img style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/upload/s--UJNCDZjT--/c_scale,w_200,h_200/f_webp/v1/com.browntulstar/img/iriam-logo.webp?_a=BAAAV6E0"> IRIAM
						</a>
					</div>	
					<div class="col-md-4 mb-2">
						<a href="https://x.com/browntulstar" target="_blank" type="button" class="btn btn-light btn-lg w-100 py-4">
							<h2>800 Followers</h2>
							<i class="fa-brands fa-x-twitter"></i> X
						</a>
					</div>	
				</div>
				<div class="row mb-2">	
					<div class="col-md-6 mb-2">
						<a href="/esports" type="button" class="btn btn-primary btn-lg w-100 py-4">
							<h2>50+ Appearances</h2>
							as Esports Caster/Producer
						</a>
					</div>		
					<div class="col-md-6 mb-2">
						<a href="/esports" type="button" class="btn btn-primary btn-lg w-100 py-4">
							<h2>15+ Events</h2>
							as Event Organizer
						</a>
					</div>				
				</div>
				<div class="row mb-2">
					<div class="col-md-12 mb-2 text-white text-center">
						<small>Estimates as of Wednesday, October 29th, 2025</small>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row py-5 home-div-row brownie-red">
		<div class="col-md-12 home-div-col">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1 class="text-center text-white">Organizations I'm In</h1>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-md-4 mb-2">
						<div class="card w-100 h-100">
							<img loading="lazy" src="https://res.cloudinary.com/browntulstar/image/private/s--10Ksbhlw--/c_pad,b_gen_fill,w_430,h_261/f_webp/v1/com.browntulstar/img/brownieval-logo-v1?_a=BAAAUWGX" class="card-img-top" alt="okimi logo" style="object-fit: cover;height:200px">
							<div class="card-body">
								<h4 class="card-title  text-center">#BrownieVAL</h4>
								<h6 class="text-center">Founder and Organizer</h6>
								<p style="text-align:center"><a class="btn btn-success w-100" style="max-width:300px" href="https://brownieval.browntulstar.com/" target="_blank">Website</a></p>
								<p style="text-align:center"></p>
							</div>
						</div>
					</div>
					<div class="col-md-4 mb-2">
						<div class="card w-100 h-100">
							<img loading="lazy" src="https://res.cloudinary.com/browntulstar/image/private/s--k9RUJeuR--/c_pad,h_200/f_webp/v1/com.browntulstar/img/team-kazoku?_a=BAAAUWGX" class="card-img-top" alt="kazoku logo" style="object-fit: cover;height:200px">
							<div class="card-body">
								<h4 class="card-title  text-center">Kazoku</h4>
								<h6 class="text-center">Events Coordinator</h6>
								<p style="text-align:center"><a class="btn btn-success w-100" style="max-width:300px" href="https://kazoteam.carrd.co/" target="_blank">Website</a></p>
								<p style="text-align:center"></p>
							</div>
						</div>
					</div>
					<div class="col-md-4 mb-2">
						<div class="card w-100 h-100">
							<img loading="lazy" src="https://res.cloudinary.com/browntulstar/image/private/s--zRJGWkmd--/c_pad,h_200/f_webp/v1/com.browntulstar/img/team-comfycafelogo?_a=BAAAUWGX" class="card-img-top" alt="okimi logo" style="object-fit: cover;height:200px">
							<div class="card-body">
								<h4 class="card-title  text-center">Okimi Cafe</h4>
								<h6 class="text-center">Co-founder and Co-manager Emeritus</h6>
								<p style="text-align:center"><a class="btn btn-success w-100" style="max-width:300px" href="https://okimicafe.crd.co/" target="_blank">Website</a></p>
								<p style="text-align:center"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="home-section-watch" class="row py-5 d-flex align-items-center justify-content-center home-div-row brownie-green" style="padding-bottom:200px !important; min-height:fit-content !important">
		<div class="col-lg-12 d-flex justify-content-center home-div-col">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center text-white">
						<h1>Get In Touch!</h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3 offset-lg-3 mb-2 text-center">
						<a class="btn btn-dark text-white my-2 shadow w-100" href="https://browntulstar.com/r/links" target="_blank">
							<i class="fa-solid fa-link"></i>
							Social Links
						</a>
					</div>
					<div class="col-lg-3 mb-2 text-center">
						<a class="btn btn-dark text-white my-2 shadow w-100" href="/contact">
							<i class="fa-solid fa-envelope"></i>
							Contact
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
$_FOOTER_HOME = false;
require $dir . "/templates/footer.php"
?>