<?php
$dir = dirname(__DIR__, 2);
require_once $dir . "/includes/default-includes.php";
require_once $dir . "/includes/mysql.php";
require_once $dir . "/includes/CloudinarySigner.php";
require_once $dir . "/vendor/autoload.php";
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;
$title = "BrowntulStar - IRIAM Star Badge Rewards";

$_iriam_access_allowed = (isset($_SESSION['user']) && check_roles(array_merge($iriam_star_roles, array($vip_role_id, $mod_role_id))));

require $dir . "/templates/header.php";

$star1_small_banner = '<span class="badge bg-primary me-1">STARS (IRIAM 1★)</span>';
$star2_small_banner = '<span class="badge bg-primary me-1">SUPER STARS (IRIAM 2★)</span>';
$star3_small_banner = '<span class="badge bg-primary me-1">GRAND STARS (IRIAM 3★)</span>';
?>
<div class="container-fluid body-container-iriam">
	<div id="iriam-section" class="row py-5 home-div-row h-100">
		<div class="col-md-12 home-div-col" style="padding-bottom: 100px;">
			<div class="container">
				<div class="row">
					<div class="col-lg-10 offset-lg-1">	
						<div class="card bg-dark text-white mx-auto">
							<div class="card-body">
                                <div>
									<div class="text-center">
										<img loading="lazy" class="bg-light mb-4 shadow" src="https://res.cloudinary.com/browntulstar/image/upload/s--UJNCDZjT--/c_scale,w_200,h_200/f_webp/v1/com.browntulstar/img/iriam-logo.webp?_a=BAAAV6E0" style="border-radius: 100%;width:200px" />
										<h1 class="card-title">IRIAM ★ Star Badge Rewards</h1>
										<p>
											<h2>You're a star! A super star!</h2><br>
											IRIAM ★ Star Badge holders can claim exclusive rewards. Isn't that so inspirational?
										</p>
										<p>
											Rewards are available to those that have the IRIAM ★ Star Badge Discord role.<br>
											All IRIAM Discord roles reset on every 5th of the new month.
										</p>
									</div>
<?php
									if (isset($_SESSION['user'])) {
									echo '<hr>';
									echo "<div class=\"text-center\" style=\"max-width:400px;margin:auto\">
									<h3>Confirm your roles</h3>
									<p>If you have one of the STARS (IRIAM 1★/2★/3★) roles from the Turtle Pond Discord server, then
									you're good to go! In addition, GOLD SHELLS (Discord VIPs) have the 
									same permissions as the SUPER STARS (IRIAM 2★).";
										require $dir . "/templates/profile-box.php";
									}
									echo '</div>';
?>
									<hr>
									<?php

									CacheManager::setDefaultConfig(new ConfigurationOption([
										"path" => $dir . "/cache"
									]));
									$instanceCache = CacheManager::getInstance("files");
									$key = "iriam_rewards_list";
									$cache = $instanceCache->getItem($key);
									if (!$cache->isHit() || isset($_GET["refreshcache"])) {
										$rewards_table_selection_contents = array(
											#'id' => array('id' => '2025-06', 'label' => 'June 2025', 'rewards' => array()),
										);
										$rewards_table_selection_options = '';
										

										$sql_rewards = "SELECT * FROM `iriam_rewards` WHERE `published`=1 ORDER BY `1star` DESC, `2star` DESC, `3star` DESC, `iriam_reward_name` ASC, `iriam_reward_date` DESC;";
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
													'file_size' => $row['iriam_reward_kilobytes'],
													'file_format' => $row['iriam_reward_format'],
													'1star' => $row['1star'],
													'2star' => $row['2star'],
													'3star' => $row['3star'],
													'hits' => $row['hits']
												);
											}
										}
										$instanceCache->save($cache->set(array(
											'contents' => $rewards_table_selection_contents,
											'options' => $rewards_table_selection_options
										))->expiresAfter(1800));
										// error_log("Cached IRIAM rewards list for 5 seconds.");
									} else {
										$cached_data = $cache->get();
										$rewards_table_selection_contents = $cached_data['contents'];
										$rewards_table_selection_options = $cached_data['options'];
										// error_log("Loaded IRIAM rewards list from cache.");
									}
									?>

									<div class="mb-2">
										<center>
										<div class="input-group mb-3" style="max-width:300px;">
											<div class="input-group-text">
												<i class="fa-solid fa-calendar-days"></i> 
											</div>
											<select class="form-select" id="rewards-table-select" style="width: auto;">
												<optgroup label="Rewards Information">
													<option data-target="#tab-landing">General Info</option>
													<option data-target="#tab-history">Fan Badge History</option>
												</optgroup>
												<hr>
												<optgroup label="Monthly Rewards">
												<?php 
												if ($_iriam_access_allowed) {
												?>
													<option disabled selected data-target="">Select a month...</option>
												<?= $rewards_table_selection_options ?>
												<?php 
												} else {
												?>
													<option disabled data-target="">Get ★Badge to access</option>
												<?php 
												}
												?>
												</optgroup>
											</select>
										</div>
										</center>
									</div>
									<div class='w-100'>
										<div class="tab-content d-flex flex-column align-items-center justify-content-center" style="min-height: 250px";>
											<div class="tab-pane active text-center w-100" id="tab-landing" style="max-width:400px;margin:auto">
												<?php 
												if (!$_iriam_access_allowed) {
												?>
												<h2>Many exclusive IRIAM rewards await you!</h2>
												<p>Watch on IRIAM and gain a ★ Star Badge. Then, join the Turtle Pond Discord server and claim your role in the <span style="white-space:nowrap"><strong>#iriam-★badge-assign</strong></span> text channel. Finally, log in to this website with Discord and access the perks!</p>
												<p>(If you just got your Discord role, then you may need to log out and log back in to this website using your Discord account.)</p>
												<br>
												<?= print_navbar_login_items($expand=true, $center=true, $subperks=true, $label=true) ?>
												<br>
												<a class="btn btn-info mb-2 w-100 shadow" href='/iriam' style="max-width:300px">
													<img style="height:20px;margin-top:-4px" src="https://res.cloudinary.com/browntulstar/image/upload/s--UJNCDZjT--/c_scale,w_200,h_200/f_webp/v1/com.browntulstar/img/iriam-logo.webp?_a=BAAAV6E0">
													About IRIAM
												</a><br>
												<a class="btn btn-light mb-2 w-100" href="/discord" style="max-width:300px">
													<i class="fa-brands fa-discord"></i>
													Join Turtle Pond Server
												</a><br>
												<a class="btn btn-success mb-2 w-100" href="/subs" style="max-width:300px">
													<i class="fa-solid fa-circle-check"></i>
													Access Perks Hub
												</a><br>
												<?php
												} else {
												?>
												<h2>Ready to claim your exclusive rewards?</h2>
												<p>Select a month from the dropdown above to view the rewards for that month. Then, find the reward that you would like to download.</p>
												<br>
												<h3>Looking for more perks?</h3>
												<a class="btn btn-success mb-2 w-100" href="/subs" style="max-width:300px">
													<i class="fa-solid fa-circle-check"></i>
													Access Perks Hub
												</a>
												<?php 
												}
												?>
											</div>
											<div class="tab-pane text-center w-100" id="tab-history">
												<h2>Fan Badge History</h2>
												<p>Powered by Google Drive</p>
												<button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    							data-bs-target="#badgeHistoryModal">View History</button>
											</div>
<?php
											if ($_iriam_access_allowed) {
											foreach ($rewards_table_selection_contents as $content) {
												$content_id = $content['id'];
												$content_label = $content['label'];
												$rewards = $content['rewards'];

												echo "<div class='tab-pane w-100' id='tab-$content_id'>";
													if (count($rewards) > 0) {
														foreach ($rewards as $reward) {
															$cld_signer = new CloudinarySigner();
															$reward_thumbnail = $cld_signer->signUrl($reward['thumbnail']);
															$reward_name = $reward['name'];
															$reward_description = $reward['description'];
															$reward_type = $reward['type'] ?? 'default'; // Default type if not set
															$reward_file_format = $reward['file_format'];
															$reward_file_size = readable_bytes_thousands(intval($reward['file_size'])*1000);
															$download_id = $reward['download_id'];
															$reward_star_banners = "";
															$star_roles_to_check = array();
															$reward_list_only = true;
															if (intval($reward['3star']) == 1) {
																$reward_star_banners = $star3_small_banner;
																$star_roles_to_check[] = $iriam_3star_role_id;
																$reward_list_only = false;
															}
															if (intval($reward['2star']) == 1 || intval($reward['1star']) == 1) {
																$star_roles_to_check[] = $mod_role_id;
																$star_roles_to_check[] = $vip_role_id;
																$reward_list_only = false;
																if (intval($reward['2star']) == 1) {
																	$reward_star_banners = $star2_small_banner;
																	$star_roles_to_check[] = $iriam_2star_role_id;
																}
																if (intval($reward['1star']) == 1) {
																	$reward_star_banners = $star1_small_banner;
																	$star_roles_to_check[] = $iriam_1star_role_id;
																}
															}
															if ($reward_list_only) {
																$reward_download_button = "<p><button class=\"btn btn-light border-dark\" disabled><i class=\"fa-solid fa-circle-xmark\"></i> Unavailable</button></p>";
															} else if (!check_roles($star_roles_to_check)) {
																$reward_download_button = "<p><button class=\"btn btn-light border-dark\" disabled><i class=\"fa-solid fa-circle-xmark\"></i> Insufficient Perks</button></p>";
															} else {
																$reward_download_button = "<p><a class=\"btn btn-info\" href=\"/subs/iriam-rewards/download?type=$reward_type&id=$download_id\">
																<i class=\"fa-solid fa-download\"></i> <strong>Download ($reward_file_format)</strong></a><br>
																<small>File Size: Approx. $reward_file_size</small><br>
																<small>Total Downloads: " . number_format($reward['hits']) . "</small>
																</p>";
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
																					<p>$reward_description</p>
																					$reward_download_button
																					<h5>$reward_star_banners</h5>
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
<div class="modal fade" id="badgeHistoryModal" tabindex="-1" role="dialog" aria-labelledby="badgeHistoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="badgeHistoryModalLabel">Fan Badge History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe style="display:block;width:100%;height:100%" width=100% height=calc(100vh-67px) overflow="scroll"
                    src="https://docs.google.com/document/d/e/2PACX-1vTWOwrwE9F1qwMN5R5BfVOw-id4t2SVUSl5-pEMu8LcbAk5oVtb6zJ2OUXgLHQ83MIS_z7dv2gDM662/pub?embedded=true"></iframe>
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