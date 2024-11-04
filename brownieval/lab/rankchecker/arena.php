<?php
$dir = dirname(__DIR__, 3);
$title = "BrownieVAL - Rank Checker";

require $dir . "/templates/header.php";
?>

<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
    <h1 class="text-center">Rank Checker for #BrownieVAL Arena</h1>
    <div class="alert alert-dark">
        <form>
            <div class="form-group">
            <p>Please enter the peak ranks of your players that are playing
                in #BrownieVAL Arena. The ranks listed for each player is the highest
                rank that a player achieved in either Episode 6 or 7, whichever is higher.
                They must have also played at least 10 competitive games for that episode
                which the rank will be used. </p>
            <p>The <strong>Wildcard</strong> player can be used to replace any player on the 
                starting roster as long as the Wildcard player is ranked the same or lower as
                the replaced player.</p>
            <p>For the ranked restrictions, please go to
                the #BrownieVAL Discord server or go to 
                <a href="https://arena.browntulstar.com/rules" target="_blank">
                    the rules page</a>.
            </p>
            </div>
            <div class="form-group" style="line-height:2">
<?php   
            $totalPlayers = 8;
            $ranks = array("-","Iron","Bronze","Silver","Gold","Platinum","Diamond","Ascendant","Immortal","Radiant");
            for ($_k = 1; $_k <= $totalPlayers; ++$_k) {
                $_i = $_k === 8 ? "Wildcard" : $_k;
                echo '<label for="rank'.$_i.'" style="width:150px">Player '.$_i.':  </label>';
                echo '<select style="width:200px" name="rank'.$_i.'" id="rank'.$_i.'">';
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
    <div class="alert alert-success" name="resultsBox" id="resultsBox">
            <h1>Results</h1>
    </div>
</div>

<script>
    function checkRank(rankToCheck, totalNumber) {
        let rankThresholds = {
            "-": 3,
            "PlatinumMinus": 8,
            "DiamondPlus": 3,
            "AscendantPlus": 2,
            "ImmortalPlus": 1,
            "Radiant": 0,
            "Wildcard": 1
        };
        let rankNames = {
            "-": "roster spots left to fill with",
            "PlatinumMinus": "Platinum or below",
            "DiamondPlus": "Diamond or above",
            "AscendantPlus": "Ascendant or above",
            "ImmortalPlus": "Immortal or above",
            "Radiant": "Radiant",
            "Wildcard": "Wildcard"
        }
        let aboveRankRestriction = (totalNumber > rankThresholds[rankToCheck]);
        return (aboveRankRestriction ? "<strong>" : "") 
            + "You have "+totalNumber.toString()+" "+rankNames[rankToCheck]+" player"
            + (totalNumber != 1 ? "s" : "").toString()+", which is <em>"
            + (aboveRankRestriction ? "above" : "within")
            + "</em> the roster restriction of "
            + rankThresholds[rankToCheck] + " player"+ (totalNumber != 1 ? "s" : "").toString()+"."
            + (aboveRankRestriction ? "</strong>" : "");
    }

    function onSubmitAction() {
        const sumReduce = (a, b) => ((a ? a : 0) + (b ? b : 0));
        let rankCounts = {};
        let rankList = document.querySelectorAll('[id^="rank"');
        //console.log(rankList);
        rankList.forEach(function(rank) {
            //console.log(rank.value);
            if (rank.name.includes("Wildcard")) {
                rankCounts["Wildcard"] = rank.value === "-" ? 0 : 1;
            } else {
                rankCounts[rank.value] = (rankCounts[rank.value] + 1) || 1;
            }
        });
        
        rankCounts["PlatinumMinus"] = [
            rankCounts["Iron"],
            rankCounts["Bronze"],
            rankCounts["Silver"],
            rankCounts["Gold"],
            rankCounts["Platinum"]
        ].reduce(sumReduce);
        rankCounts["DiamondPlus"] = [
            rankCounts["Diamond"],
            rankCounts["Ascendant"],
            rankCounts["Immortal"],
            rankCounts["Radiant"]
        ].reduce(sumReduce);
        rankCounts["AscendantPlus"] = [
            rankCounts["Ascendant"],
            rankCounts["Immortal"],
            rankCounts["Radiant"]
        ].reduce(sumReduce);
        rankCounts["ImmortalPlus"] = [
            rankCounts["Immortal"],
            rankCounts["Radiant"]
        ].reduce(sumReduce);
        rankCounts["Radiant"] = [
            rankCounts["Radiant"],
            0
        ].reduce(sumReduce);
        rankCounts["-"] = [
            rankCounts["-"],
            (rankCounts["Wildcard"] === 0) ? 1 : 0,
            0
        ].reduce(sumReduce);
        console.log(rankCounts);

        resultHtml = "<h1>Results</h1><p><strong>BOLD</strong> means requirement not met.</p><p>Wildcard players are not calculated for the ranked restrictions.</p><ul>";
        ["PlatinumMinus","DiamondPlus","AscendantPlus","ImmortalPlus","Radiant","-"].forEach(function (rank) {
            resultHtml += "<li>" + checkRank(rank,rankCounts[rank]) + "</li>";
        })
        resultHtml += "</ul><p>The Wildcard player is not calculated in the results above (except for roster spots to fill). \
Remember that the Wildcard player can be used to replace any player on the starting roster as long as the Wildcard player is ranked the same or lower as the replaced player.";


        let resultsBox = document.getElementById("resultsBox");
        resultsBox.innerHTML = resultHtml;

    }
</script>

<?php 
require $dir . "/templates/footer.php";
?>