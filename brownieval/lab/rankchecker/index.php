<?php
$dir = dirname(__DIR__, 3);
$title = "BrownieVAL - Rank Checker";

require $dir . "/templates/header.php";
?>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 class="text-center">Rank Checker for #BrownieVAL Impact</h1>
    <div class="alert alert-dark">
        <form>
            <div class="form-group">
            <p>Please enter the peak ranks of the starting players that are playing
                in #BrownieVAL Impact. The ranks listed for each player is the highest
                rank that a player achieved in either Episode 7 or 8 or 9, whichever is higher.
                They must have also played at least 10 competitive games for that episode
                which the rank will be used.</p>
            <p>For the detailed ranked restrictions, please go to
                the #BrownieVAL Discord server or go to 
                <a href="https://impact.brownieval.browntulstar.com/rules" target="_blank">
                    the rules page</a>.
            </p>
            </div>
            <h2>Your Next Game's Starting Lineup</h2>
            <p>Enter the player's peak ranks from Episode 7, 8, OR 9, whichever is higher, in the boxes below</p>
            <div class="form-group" style="line-height:2">
<?php   
            $totalPlayers = 5;
            $ranks = array("-","Iron","Bronze","Silver","Gold","Platinum","Diamond","Ascendant","Immortal","Radiant");
            for ($_k = 1; $_k <= $totalPlayers; ++$_k) {
                echo '<label for="rank'.$_k.'" style="width:150px">Player '.$_k.':  </label>';
                echo '<select style="width:200px" name="rank'.$_k.'" id="rank'.$_k.'">';
                for ($_j = 0; $_j < count($ranks); ++$_j) {
                    $rank = $ranks[$_j];
                    echo '<option value="'.$rank.'">'.$rank.'</option>';
                }
                echo '</select><br/>';
            }
?>
            <button type="button" class="btn btn-primary" name="submit" id="submit" onclick=onSubmitAction()>Calculate</button>
            </div>
        </form>
    </div>
    <div class="alert" name="resultsBox" id="resultsBox">
    </div>
</div>

<script>
    function onSubmitAction() {
        const sumReduce = (a, b) => ((a ? a : 0) + (b ? b : 0));
        let totalRankPoints = 0;
        let rankPointsLimit = 31;
        let rosterFilled = true;
        let rankList = document.querySelectorAll('[id^="rank"');
        let rankPoints = {
            "-": 0,
            "Iron": 4,
            "Bronze": 4,
            "Silver": 4,
            "Gold": 4,
            "Platinum": 5,
            "Diamond": 6,
            "Ascendant": 7,
            "Immortal": 9,
            "Radiant": 32
        };
        rankList.forEach(function(rank) {
            if (rank.value === "-") {
                rosterFilled = false;
            }
            totalRankPoints += rankPoints[rank.value] || 0;
        });

        resultHtml = "<h1>Result: " + totalRankPoints + "/" + rankPointsLimit + "</h1>\
        <ul>\
        <li>This lineup for the next game has a roster value of " + totalRankPoints + " points.</li>\
        <li>This lineup must have a roster value of " + rankPointsLimit + " or lower.</li>\
        <li>This lineup is " + ((!rosterFilled) ? "<strong>NOT</strong>" : "") + " filled with 5 players.</li>\
        <li>Therefore, this lineup is " + (((totalRankPoints > rankPointsLimit) || (!rosterFilled)) ? "<strong>NOT</strong>" : "")+ " allowed to play the next game!</ul>";

        let resultsBox = document.getElementById("resultsBox");
        if ((totalRankPoints > rankPointsLimit) || !rosterFilled) {
            resultsBox.classList.remove("alert-success");
            resultsBox.classList.add("alert-danger");
        } else {
            resultsBox.classList.add("alert-success");
            resultsBox.classList.remove("alert-danger");
        }
        resultsBox.innerHTML = resultHtml;

    }
</script>

<?php 
require $dir . "/templates/footer.php";
?>