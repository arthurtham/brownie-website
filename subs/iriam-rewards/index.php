<?php
$dir = dirname(__DIR__, 2);
require_once $dir . "/includes/default-includes.php";
require_once $dir . "/includes/mysql.php";
require_once $dir . "/includes/CloudinarySigner.php";
$title = "BrowntulStar - IRIAM Star Badge Rewards";

// if (!isset($_SESSION['user']) || !check_roles($iriam_star_roles)) {
// 	require $dir . "/error/403-iriam.php";
// 	die();
// }


require $dir . "/templates/header.php";

$star1_small_banner = '<span class="badge bg-primary me-1">1★</span>';
$star2_small_banner = '<span class="badge bg-primary me-1">2★</span>';
$star3_small_banner = '<span class="badge bg-primary me-1">3★</span>';
?>
<div class="container-fluid body-container-iriam">
	<div id="iriam-section" class="row py-5 home-div-row h-100">
		<div class="col-md-12 home-div-col" style="padding-bottom: 100px;">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-2">	
						<div class="card bg-dark text-white mx-auto">
							<div class="card-body">
                                <div>
									<div class="text-center">
										<img loading="lazy" class="bg-light mb-4 shadow" src="https://res.cloudinary.com/browntulstar/image/upload/com.browntulstar/img/iriam-logo.svg" style="border-radius: 100%;width:200px" />
										<h1 class="card-title">IRIAM Star Badge Rewards</h1>
										<p>
											<h2>You're a star! A super star!</h2><br>
											Thanks to the Star Fan Badge supporters on IRIAM, they get to claim these exclusive IRIAM star fan badge rewards.
										</p>
										<p>
											All rewards are available no matter 
											when a user achieved the IRIAM Star Badge reward.<br>
											All they need to do is have the corresponding IRIAM star badge Discord role.
										</p>
										<p>
											All IRIAM Discord roles reset on every 5th of the new month.
										</p>
									</div>
<?php
									if (isset($_SESSION['user'])) {
									echo '<hr>';
									echo '<div class="text-center">
									<h3>Confirm your roles</h3>
									<p>Make sure you have the STARS (IRIAM 1★) or SUPER STARS (IRIAM 2★/3★) role from the Turtle Pond Discord server. 
									You can view all rewards, but you can only download the rewards that you have access to.
									The rewards are labeled by their ★ reward level.</p>
									<p>You can claim the roles by going to the #iriam-★badge-assign Discord text channel.</p>';
										require $dir . "/templates/profile-box.php";
									}
									echo '</div>';
?>
									<hr>
									<?php 

									if (!isset($_SESSION['user']) || !check_roles($iriam_star_roles)) {
									?>
									<div class='w-100'>
										<div class="tab-content d-flex flex-column align-items-center justify-content-center" style="min-height: 350px";>
											<div class="text-center w-100" id="tab-landing">
												<h2>Many IRIAM rewards await you!</h2>
												<p>Watch on IRIAM and gain a Star Badge.
												<br>Then, join the Discord server and claim your role in the #iriam-★badge-assign text channel.
												<br>Finally, log in to this website with Discord and access the perks!</p>
												<br>
												<?= print_navbar_login_items($expand=true, $center=true, $subperks=true) ?>
												<br>
												<a class="btn btn-info mb-2 w-100 shadow" href='/iriam' style="max-width:300px">
													<img style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/upload/com.browntulstar/img/iriam-logo.svg">
													About IRIAM
												</a><br>
												<a class="btn btn-light mb-2 w-100" href="/r/discord" style="max-width:300px" target="_blank">
													<i class="fa-brands fa-discord"></i>
													Join Turtle Pond Server
												</a><br>
												<a class="btn btn-success mb-2 w-100" href="/subs" style="max-width:300px">
													<i class="fa-solid fa-circle-check"></i>
													Overall Perks Info
												</a><br>
											</div>
										</div>
									</div>

									<?php
									} else {

									$rewards_table_selection_contents = array(
										#'id' => array('id' => '2025-06', 'label' => 'June 2025', 'rewards' => array()),
									);
									$rewards_table_selection_options = '';

									$sql_rewards = "SELECT * FROM `iriam_rewards` WHERE `published`=1 ORDER BY `iriam_reward_date` DESC";
									$result_rewards = $conn->query($sql_rewards);
									unset($sql_rewards);

									if ($result_rewards && $result_rewards->num_rows > 0) {
										// Fetch all rewards and organize them by month
										while ($row = $result_rewards->fetch_assoc()) {
											$content_id = date('Y-m', strtotime($row['iriam_reward_date']));
											// If the content id is not in the array, add it
											if (!isset($rewards_table_selection_contents[$content_id])) {
												$content_month = date('F Y', strtotime($row['iriam_reward_date']));
												$rewards_table_selection_contents[$content_id] = array(
													'id' => $content_id,
													'label' => $content_month,
													'rewards' => array()
												);
												// Add the option to the selection options
												$rewards_table_selection_options .= "<option data-target='#tab-$content_id'>$content_month</option>";
											}
											// Add the reward to the corresponding month. There can be multiple rewards in a month.
											$rewards_table_selection_contents[$content_id]['rewards'][] = array(
												'name' => $row['iriam_reward_name'],
												'description' => $row['iriam_reward_description'],
												'thumbnail' => $row['iriam_reward_thumbnail'],
												'type' => $row['iriam_reward_type'],
												'reward_date' => $row['iriam_reward_date'],
												'download_id' => $row['iriam_reward_download_id'],
												'1star' => $row['1star'],
												'2star' => $row['2star'],
												'3star' => $row['3star']
											);
										}
									}
									?>

									<div class="mb-2">
										<div class="input-group mb-3">
											<div class="input-group-text">
												<i class="fa-solid fa-calendar-days"></i>
											</div>
											<select class="form-select" id="rewards-table-select" style="width: auto;">
												<option disabled selected data-target="#tab-landing">Select a month...</option>
												<?= $rewards_table_selection_options ?>
											</select>
										</div>
									</div>
									<div class='w-100'>
										<div class="tab-content d-flex flex-column align-items-center justify-content-center" style="min-height: 250px";>
											<div class="tab-pane active text-center w-100" id="tab-landing">
												<h2>Ready to claim your rewards?</h2>
												<p>Select a month from the dropdown above to view the rewards for that month.</p>
												<br>
												<a class="btn btn-info mb-2 w-100 shadow" href='/iriam' style="max-width:300px">
													<img style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/upload/com.browntulstar/img/iriam-logo.svg">
													IRIAM
												</a><br>
												<a class="btn btn-success mb-2 w-100" href="/subs/details" style="max-width:300px">
													<i class="fa-solid fa-circle-check"></i>
													Overall Perks Info
												</a>
											</div>
<?php
											foreach ($rewards_table_selection_contents as $content) {
												$content_id = $content['id'];
												$content_label = $content['label'];
												$rewards = $content['rewards'];

												echo "<div class='tab-pane w-100' id='tab-$content_id'>";
													echo "<h2 class='text-center'>Rewards from $content_label</h2>";
													if (count($rewards) > 0) {
														foreach ($rewards as $reward) {
															$cld_signer = new CloudinarySigner();
															$reward_thumbnail = $cld_signer->signUrl($reward['thumbnail']);
															$reward_name = $reward['name'];
															$reward_description = $reward['description'];
															$reward_type = $reward['type'] ?? 'default'; // Default type if not set
															$download_id = $reward['download_id'];
															$reward_star_banners = "";
															if (intval($reward['1star']) == 1) {
																$reward_star_banners .= $star1_small_banner;
															}
															if (intval($reward['2star']) == 1) {
																$reward_star_banners .= $star2_small_banner;
															}
															if (intval($reward['3star']) == 1) {
																$reward_star_banners .= $star3_small_banner;
															}
															
															echo <<<CREDITSPOST
																<div class="card mt-2" style="width: 100%;color:black">
																	<div class="card-body">
																		<div class="container">
																			<div class="row">
																				<div class="col-lg-4" oncontextmenu='return false;' ondragstart='return false;'>
																					<center><div><img loading="lazy" class="rounded shadow" src="$reward_thumbnail" style="max-height: 200px; max-width: min(100%,225px);" /></div></center>
																					<br />
																				</div>
																				<div class="col-lg-8">
																					<h2 class="card-title">$reward_name</h2>
																					<h5>$reward_star_banners</h5>
																					<p>$reward_description</p>
																					<p><a class="btn btn-danger" href="/subs/iriam-rewards/download?type=$reward_type&id=$download_id"><i class="fa-solid fa-download"></i> Download</a></p>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
CREDITSPOST;
															}
														} else {
															echo <<<NOREWARDS
															<div id="center-block" class="d-flex flex-column align-items-center justify-content-center" style="color:white">
															<p class='text-center'>No rewards available for this month.</p>
															</div>
NOREWARDS;
														}
													echo "</div>";
												}
?>
											</div>
										</div>
									</div>

									<?php
									}
									?>
									<hr>
                                    <p class="text-center">
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
<script>
$("#rewards-table-select").on("change", function(e) {
  var target = $("option:selected", this).data("target");
  $(".tab-pane").removeClass("active");
  $(target).addClass("active");
});
</script>
<?php require $dir . "/templates/footer.php" ?>