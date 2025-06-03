<?php
$dir = dirname(__DIR__, 2);
require_once $dir . "/includes/default-includes.php";
$title = "BrowntulStar - IRIAM Star Badge Rewards";

if (!isset($_SESSION['user']) || !check_roles(array_merge(array($turtle_role_id),$iriam_star_roles))) {
	require $dir . "/error/403-iriam.php";
	die();
}


require $dir . "/templates/header.php";
?>
<div class="container-fluid">
	<div id="home-section-about" class="row py-5 home-div-row h-100" style="background-image: url('https://res.cloudinary.com/browntulstar/image/upload/v1748902463/com.browntulstar/img/iriam-bg.jpg')">
		<div class="col-md-12 home-div-col">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">	
                        <center><img src="https://res.cloudinary.com/browntulstar/image/upload/s--s7BzgqvH--/c_scale,w_400/f_webp/v1/com.browntulstar/img/pngtuber-turtle-half.png?_a=BAAAV6E0" style="width:auto;max-width:min(70vw,400px)"></center>
						<div class="card bg-dark text-white mx-auto">
							<div class="card-body">
                                <div class="text-center">
                                    <img loading="lazy" class="bg-light mb-4 shadow" src="https://res.cloudinary.com/browntulstar/image/upload/com.browntulstar/img/iriam-logo.svg" style="border-radius: 100%;width:200px" />
								    <h1 class="card-title">IRIAM Star Badge Rewards</h1>
                                    <p class="text-center">
                                        Coming Soon!<br>

                                    </p>
                                    <p>
                                        <small>IRIAM and its logo and artwork are copyrighted and trademarked by IRIAM Inc. All rights reserved.</small>                                    
                                    </p>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require $dir . "/templates/footer.php" ?>