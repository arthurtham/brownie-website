<?php
# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);


# Including all the required scripts for demo
require dirname(__DIR__, 2) . "/includes/functions.php";
require dirname(__DIR__, 2) . "/includes/discord.php";
require dirname(__DIR__, 2) . "/config.php";
require dirname(__DIR__, 2) . "/includes/sessiontimer.php";

?>

<html>

<head>
	<title>BrowntulStar - Shoutcasting</title>
	<?php require dirname(__DIR__, 2) . "/templates/header-includes.php" ?>
</head>

<body>
    <?php require dirname(__DIR__, 2) . "/templates/navbar.php" ?>
	<div class="container body-container" style="padding-top:50px;padding-bottom:100px">
        <h1 class="text-center">Shoutcasting Portfolio</h1>
        <p>I am an amateur shoutcaster, with a non-exclusive casting role for Rooyemi's VALORANT tournaments and for Change Thru Games' VALORANT and Tetris tournaments.</p>
        <p>Here's a list of tournaments I've shoutcasted:</p>
        <ul>
            <li>ValorANT Tournament (March 2022)</li>
            <li>Happy Valrootines VALORANT Tournament (February 2022)</li>
            <li>CGT: Friendship Games (February 2022)</li>
            <li>Happy Roolidays VALORANT Tournament (December 2021)</li>
            <li>Change Thru Games: Tetris and VALORANT (2020-present)</li> 
            <li>O Snap Its a VALORANT Tournament (osnapitskat) (August 2020, July 2021, November 2021)</li>
        </ul>
        <hr>
        <p><center>
        <blockquote class="twitter-tweet" data-dnt="true"><p lang="en" dir="ltr">Watch the Instigators take on TLC&#39;s lineups and crossfire on Haven. Who will clutch it out in overtime?<br><br>🎙️ <a href="https://twitter.com/browntulstar?ref_src=twsrc%5Etfw">@browntulstar</a> and <a href="https://twitter.com/AwesomeLioness1?ref_src=twsrc%5Etfw">@AwesomeLioness1</a> <br>📷 <a href="https://twitter.com/Rooyemi_?ref_src=twsrc%5Etfw">@Rooyemi_</a> <br>🎮 <a href="https://twitter.com/PlayVALORANT?ref_src=twsrc%5Etfw">@PlayVALORANT</a> <a href="https://twitter.com/hashtag/VALORANT?src=hash&amp;ref_src=twsrc%5Etfw">#VALORANT</a> <br>📺 <a href="https://t.co/OlwR6TrdPF">https://t.co/OlwR6TrdPF</a><a href="https://twitter.com/hashtag/shoutcasting?src=hash&amp;ref_src=twsrc%5Etfw">#shoutcasting</a> <a href="https://twitter.com/hashtag/tournament?src=hash&amp;ref_src=twsrc%5Etfw">#tournament</a> <a href="https://twitter.com/hashtag/clutch?src=hash&amp;ref_src=twsrc%5Etfw">#clutch</a> <a href="https://t.co/RV0S58htIa">pic.twitter.com/RV0S58htIa</a></p>&mdash; Browntul (@browntulstar) <a href="https://twitter.com/browntulstar/status/1498706260299948036?ref_src=twsrc%5Etfw">March 1, 2022</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        <blockquote class="twitter-tweet" data-dnt="true"><p lang="en" dir="ltr">Nothing like <a href="https://twitter.com/edmvndee?ref_src=twsrc%5Etfw">@edmvndee</a> getting the ace to win <a href="https://twitter.com/_WilsonChang?ref_src=twsrc%5Etfw">@_WilsonChang</a> &#39;s CGT Friendship Games! The Tour de Force and the Headhunter were all he needed.<br><br>🎙️<a href="https://twitter.com/browntulstar?ref_src=twsrc%5Etfw">@browntulstar</a> and <a href="https://twitter.com/Kayvian_koi?ref_src=twsrc%5Etfw">@Kayvian_koi</a> on the call.<a href="https://twitter.com/hashtag/VALORANT?src=hash&amp;ref_src=twsrc%5Etfw">#VALORANT</a> <a href="https://twitter.com/hashtag/chamber?src=hash&amp;ref_src=twsrc%5Etfw">#chamber</a> <a href="https://twitter.com/hashtag/ace?src=hash&amp;ref_src=twsrc%5Etfw">#ace</a> <a href="https://twitter.com/hashtag/tournament?src=hash&amp;ref_src=twsrc%5Etfw">#tournament</a> <br>Stream: <a href="https://t.co/wiaMwfTPZc">https://t.co/wiaMwfTPZc</a><br>Game: <a href="https://twitter.com/PlayVALORANT?ref_src=twsrc%5Etfw">@PlayVALORANT</a> <a href="https://t.co/H5YAIg0KmK">pic.twitter.com/H5YAIg0KmK</a></p>&mdash; Browntul (@browntulstar) <a href="https://twitter.com/browntulstar/status/1495998253237735424?ref_src=twsrc%5Etfw">February 22, 2022</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

        <blockquote class="twitter-tweet" data-dnt="true"><p lang="en" dir="ltr">Looking back at the Happy Roolidays! <a href="https://twitter.com/hashtag/VALORANT?src=hash&amp;ref_src=twsrc%5Etfw">#VALORANT</a> Tourney. Shoutcasting it was a fun learning experience and it&#39;s enhanced by the analysis of the one and only <a href="https://twitter.com/AwesomeLioness1?ref_src=twsrc%5Etfw">@AwesomeLioness1</a> . Thanks to <a href="https://twitter.com/Enlightgg?ref_src=twsrc%5Etfw">@Enlightgg</a> for bringing people with similar interests together!<br><br>(From TTV/Rooyemi <a href="https://twitter.com/Rooyemi_?ref_src=twsrc%5Etfw">@Rooyemi_</a> ) <a href="https://t.co/brDb3Bl6u6">pic.twitter.com/brDb3Bl6u6</a></p>&mdash; Browntul (@browntulstar) <a href="https://twitter.com/browntulstar/status/1474640366036930560?ref_src=twsrc%5Etfw">December 25, 2021</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

        <blockquote class="twitter-tweet" data-dnt="true"><p lang="en" dir="ltr">I miss shoutcasting :(<br>Happy 1-year anniversary of shoutcasting Tetris for <a href="https://twitter.com/ChangeThruGames?ref_src=twsrc%5Etfw">@ChangeThruGames</a> 🥳 <a href="https://t.co/mOELNtibxe">pic.twitter.com/mOELNtibxe</a></p>&mdash; Browntul (@browntulstar) <a href="https://twitter.com/browntulstar/status/1400271125620281344?ref_src=twsrc%5Etfw">June 3, 2021</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

        </center></p>
    </div>
	<?php require dirname(__DIR__, 2) . "/templates/footer.php" ?>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>