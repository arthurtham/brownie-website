<?php

$dir = dirname(__DIR__, 3);
$title = "Survey Code - #BrownieVAL";
$_layout_brownievalmode = true;
require $dir . "/templates/header.php";
require __DIR__ . "/surveycode.php";

// Check login
if (!isset($_SESSION['user'])) { 
  echo '<div class="container body-container" style="padding-top:50px;padding-bottom:100px">';
  echo '<h1 class="text-center">#BrownieVAL Survey Code</h1>';
  echo "<div class='alert alert-danger' role='alert'>
  <center>Players, please log in with Discord to access this page.</center>";
  print_navbar_login_items($expand=true, $center=true, $label=true);
  echo "
  </div></div>";
  require $dir . "/templates/footer.php"; 
  die();
} 
// Check user perms 
else if (!
  (check_guild_membership($brownieval_guild_id) && check_roles([$brownieval_player_access_id, $brownieval_admin_access_id])) 
  ) {
    echo '<div class="container body-container" style="padding-top:50px;padding-bottom:100px">';
    echo '<h1 class="text-center">#BrownieVAL Survey Code</h1>';
    echo "<div class='alert alert-danger' role='alert'>
    <center>We can't determine if you're a #BrownieVAL player for the most recent event. We use your Discord roles in the #BrownieVAL server to check this.
    Please contact #BrownieVAL ModMail for support.</center>
    </div></div>";
    require $dir . "/templates/footer.php"; 
    die();
}

?>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
  <h1 class="text-center">#BrownieVAL Survey Code</h1>
  <p class="text-center">Thanks for participating in the event! Please get your survey code below.</p>
  <div class="alert alert-danger">
    <p><strong>Privacy</strong>: Your Discord numerical ID has been hashed to generate this code. 
    This does not make your survey submission anonymous,
    but it helps identify that your reponse is that of a player while obscuring who submitted the feedback.</p>
  </div>
  <p>Your Discord Username: <strong><?=$_SESSION['username'] ?></strong></p>
  <p>Your Discord ID: <strong><?=$_SESSION['user_id'] ?></strong></p>
  <p>Your code (copy this): <br>
    <div class="alert alert-secondary">
        <strong><pre><?=$brownieval_survey_code ?></pre></strong>
        </div>
    </p>
  <p><a target="_blank" href="/r/brownievalsurvey"><button class="btn btn-success">Go To Survey Form</button></a></p>
</div>


<?php
require $dir . "/templates/footer.php"; 
?>