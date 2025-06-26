<?php
$dir = dirname(__DIR__, 1);
require_once $dir . "/includes/default-includes.php";
if (!isset($title)) {
    $title = "BrowntulStar - Error"; 
}
require $dir . "/templates/header.php";
?>

<div class="container-fluid body-container-iriam">
	<div id="iriam-section" class="row py-5 home-div-row h-100">
		<div class="col-md-12 home-div-col" style="padding-bottom: 100px;">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-2">	
						<div class="card bg-dark text-white mx-auto">
							<div class="card-body">
                                <div class="d-flex flex-column align-items-center justify-content-center" style="height:100%">
                                    <span>
                                        <h1 class="text-center">403 Insufficient Perks</h1>
                                        <center>
                                        <p>This is an IRIAM ★ Star Badge perk.</p>
                                        <p><strong>Something not right?</strong> Make sure you meet the Star Badge tier
                                        on IRIAM for this content, then join the Discord server to claim the corresponding Star Badge roles. After confirming you
                                        have the roles, log out and log back in to this website with your Discord account.</p> 
                                        </center>
                                    </span>
                                    <div class="alert alert-dark" role="alert">
                                        <p class="text-center">Trying to access perks? For help setting up your perks, please go to <a href="/subs/details">this page</a>.</p>
                                    </div>
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