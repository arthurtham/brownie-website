<?php
$dir = dirname(__DIR__, 2);
require_once $dir . "/includes/default-includes.php";
require_once $dir . "/includes/mysql.php";
require_once $dir . "/includes/CloudinarySigner.php";
$title = "BrowntulStar - IRIAM Star Badge Rewards";

if (!isset($_SESSION['user']) || !check_roles($iriam_star_roles)) {
	require $dir . "/error/403-iriam.php";
	die();
}


require $dir . "/templates/header.php";
?>
<div class="container-fluid body-container-iriam">
	<div id="iriam-section" class="row py-5 home-div-row h-100">
		<div class="col-md-12 home-div-col" style="padding-bottom: 100px;">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">	
						<div class="card bg-dark text-white mx-auto">
							<div class="card-body">
                                <div>
									<div class="text-center">
										<img loading="lazy" class="bg-light mb-4 shadow" src="https://res.cloudinary.com/browntulstar/image/upload/com.browntulstar/img/iriam-logo.svg" style="border-radius: 100%;width:200px" />
										<h1 class="card-title">IRIAM Star Badge Rewards</h1>
										<p>
											<strong>You're a star! A super star!</strong>
											Thanks to your support, you get to claim these exclusive IRIAM star fan badge rewards.
										</p>
										<p>
											Inspired by the rewards that IRIAM US's Founding Streamers offer, all rewards are available no matter when you achieved the IRIAM star fan badge reward. All you need to do is be able to access this page by having the corresponding IRIAM star badge Discord role.
										</p>
									</div>
									<div class="text-center">
<?php
											if (check_roles([$iriam_1star_role_id])) {
												echo '<h5><span class="badge bg-primary" style="width:100%;max-width: 200px">STARS (IRIAM 1★)</span></h5>';
											}
											if (check_roles([$iriam_2star_role_id])) {
												echo '<h5><span class="badge bg-primary" style="width:100%;max-width: 200px">SUPER STARS (IRIAM 2★)</span></h5>';
											}
											if (check_roles([$iriam_3star_role_id])) {
												echo '<h5><span class="badge bg-primary" style="width:100%;max-width: 200px">SUPER STARS (IRIAM 3★)</span></h5>';
											}
?>
									</div>
									<hr>
									<?php 

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
												'download_id' => $row['iriam_reward_download_id']
											);
										}
									}
									?>

									<div class="mb-2">
										<div class="input-group mb-3">
											<div class="input-group-text">
												<i class="fa-solid fa-calendar-days"></i>
											</div>
											<select class="form-select" id="rewards-table-select" style="width: auto; max-width: 300px">
												<option disabled selected data-target="#tab-landing">Select a month...</option>
												<?= $rewards_table_selection_options ?>
											</select>
										</div>
									</div>
									<div class='w-100'>
										<div class="tab-content" style="min-height: 500px";>
											<div class="tab-pane active" id="tab-landing">
												<p>Select a month from the dropdown above to view the rewards for that month.</p>
											</div>
<?php
											foreach ($rewards_table_selection_contents as $content) {
												$content_id = $content['id'];
												$content_label = $content['label'];
												$rewards = $content['rewards'];

												echo "<div class='tab-pane' id='tab-$content_id'>";
													echo "<h1>Rewards from $content_label</h1>";
													if (count($rewards) > 0) {
														foreach ($rewards as $reward) {
															$cld_signer = new CloudinarySigner();
															$reward_thumbnail = $cld_signer->signUrl($reward['thumbnail']);
															$reward_name = $reward['name'];
															$reward_description = $reward['description'];
															$reward_type = $reward['type'] ?? 'default'; // Default type if not set
															$download_id = $reward['download_id'];

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
																					<p>$reward_description</p>
																					<p><a class="btn btn-danger" href="/subs/iriam-rewards/download.php?type=$reward_type&id=$download_id"><i class="fa-solid fa-download"></i> Download</a></p>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
CREDITSPOST;
															}
														} else {
															echo "<p class='text-center'>No rewards available for this month.</p>";
														}
													echo "</div>";
												}
?>
											</div>
										</div>
									</div>
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