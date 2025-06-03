<?php
$dir = __DIR__;
$title = "BrowntulStar - Home";

require $dir . "/templates/header.php"
?>
<div class="container-fluid body-container-home">
	<div id="center-block" class="d-flex align-items-center justify-content-center" style="padding-top:50px">
		<center><img src="https://res.cloudinary.com/browntulstar/image/private/s--gRiI4zsg--/c_pad,h_400/e_shadow/com.browntulstar/img/browntulstar-logo-v2-large.png" style="width:100%;max-width:500px" />
			<div class="box bg-gradient shadow rounded" style="background-color: rgba(255,255,255,0.2); padding: 20px; width:100%; max-width:370px">
				<div class="row g-2">
					<div class="col col-md-6">
						<span class="d-flex flex-row gap-1" style="text-align: center; padding-bottom:6px">
						<a class="btn btn-primary w-100" href="/stream">
							<i class="fa-brands fa-twitch"></i>
							Twitch
						</a>
						</span>
					</div>
					<div class="col col-md-6">
						<span class="d-flex flex-row gap-1" style="text-align: center; padding-bottom:6px">
							<a class="btn btn-primary w-100" href="/iriam">
								<img style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/upload/com.browntulstar/img/iriam-logo.svg">
								IRIAM
							</a>
						</span>
					</div>
				</div>
				<span class="d-flex flex-row gap-1" style="text-align: center; padding-bottom:6px">
					<a href="#" id="navbarSubs-button" class="btn btn-success w-100"><i class="fa-solid fa-circle-check"></i> Perks</a>
				</span>
				<span class="d-flex flex-row gap-1" style="text-align: center; padding-bottom:6px">
					<a href="#home-section-about" class="btn btn-dark w-100">About</a>
				</span>
				<span class="d-flex flex-row gap-1" style="text-align: center; padding-bottom:6px">
					<a href="/credits" class="btn btn-dark w-100">Credits</a>
				</span>
				<span class="d-flex flex-row gap-1 pt-2" style="text-align: center; padding-bottom:6px">
					<span class="w-100"><small> 
					<a href="https://browntulstar.com/r/links" class="text-black" style="text-decoration: none" target="_blank">Socials: @browntulstar</a>
					</small></span>
				</span>
		</center>
	</div>
</div>
<div class="container-fluid">
	<div id="home-section-about" class="row py-5 home-div-row" style="background-image: url('https://res.cloudinary.com/browntulstar/image/private/s--zCA0sKlO--/e_blur:300/c_scale,h_1080/f_webp/com.browntulstar/img/credits-portfolio-nary.png')">
		<div class="col-md-12 home-div-col">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-2">	
						<center><img loading="lazy" class="bg-light mb-4 shadow" src="https://res.cloudinary.com/browntulstar/image/private/s--Gq5rx5qg--/c_mpad,h_300,w_300/com.browntulstar/img/turtleyear-sm.png" style="border-radius: 100%;width:auto;max-width:min(300px, 100vw)" /></center>
						<div class="card mx-auto">
							<div class="card-body">
								<h1 class="card-title text-center">About Me</h1>
								<p class="text-center">I'm a content creator, esports commentator and producer, and software programmer. You might know me from being a community member
									in many Twitch streams on the Pacific time zone and the host of a VALORANT tournament called #BrownieVAL!
								</p>
								<p class="text-center">I first started streaming on Twitch in August of 2019. On my stream, I enjoy playing chaotic multiplayer games and exploring new ways to play.
									You'll find my Killjoy turtle PNGTuber hanging out in my comfy bedroom, tinkering with new stream widgets and coding up new software for my turtle shells to enjoy.
									I hope you can enjoy my content!
								</p>
								<div class="text-center">
								<a class="btn btn-dark m-2 shadow" href="/r/discord" target="_blank" style="max-width:400px">
									<i class="fa-brands fa-discord"></i>
									Discord Server
								</a> 
								<a class="btn btn-dark m-2 shadow" href="/shoutcasting" style="max-width:400px">
									<i class="fa-solid fa-video"></i>
									Portfolio
								</a> 
								<a class="btn btn-dark m-2 shadow" href='#home-section-watch' style="max-width:400px">
									<i class="fa-solid fa-link"></i> More Links and Socials
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
						<center><img loading="lazy" class="bg-light mb-4 shadow" src="https://res.cloudinary.com/browntulstar/image/private/s--y9zZhHfd--/ar_1:1,c_scale,h_400/f_webp/com.browntulstar/img/brownieval-logo-v1.png" style="border: 3px solid black; border-radius: 100%;width:auto;max-width:min(300px, 100vw)" /></center>
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
								<a class="btn btn-dark m-2 shadow" href="/r/brownievaldiscord" target="_blank" style="max-width:400px">
									<img class='rounded' style='height:18px;margin-top:-4px' src='https://res.cloudinary.com/browntulstar/image/private/s--fcXDbYLp--/f_webp/v1/com.browntulstar/img/brownieval-logo-v1?_a=BAAAUWGX'> <i class="fa-brands fa-discord"></i>
									Tournament Server
								</a>
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
						<h1 class="text-center text-white">Games I Stream</h1>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 mb-2">
						<div class="card w-100 h-100">
							<img loading="lazy" src="https://res.cloudinary.com/browntulstar/image/private/s--NUbAjcLX--/c_pad,h_400/com.browntulstar/img/games-honkaistarrail.jpg" class="card-img-top" alt="qingque honkai star rail" style="object-fit: cover;height:200px">
							<div class="card-body">
								<h4 class="card-title  text-center">Honkai: Star Rail</h4>
							</div>
						</div>
					</div>
					<div class="col-md-4 mb-2">
						<div class="card w-100 h-100">
							<img loading="lazy" src="https://res.cloudinary.com/browntulstar/image/private/s--hvYzDb2e--/c_crop,h_0.95,w_0.95/c_pad,h_400/com.browntulstar/img/games-marvelrivals.jpg" class="card-img-top" alt="marvel rivals" style="object-fit: cover;height:200px">
							<div class="card-body">
								<h4 class="card-title  text-center">Marvel Rivals</h4>
							</div>
						</div>
					</div>
					<div class="col-md-4 mb-2">
						<div class="card w-100 h-100">
							<img loading="lazy" src="https://res.cloudinary.com/browntulstar/image/private/s--1WaZm_di--/c_pad,h_400/com.browntulstar/img/games-valorant-kj.jpg" class="card-img-top" alt="valorant killjoy" style="object-fit: cover;height:200px">
							<div class="card-body">
								<h4 class="card-title  text-center">VALORANT</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<hr />
					</div>
				</div>
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
	<div id="home-section-watch" class="row py-5 d-flex align-items-center justify-content-center home-div-row brownie-red" style="padding-bottom:200px !important; min-height:fit-content !important">
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
						<a class="btn btn-dark text-white my-2 shadow w-100" href="/contact" target="_blank">
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