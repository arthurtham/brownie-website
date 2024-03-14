<!-- Adapted from Mark Hillard's Responsive Audio Player https://codepen.io/markhillard/pen/jOOKxM -->
<link rel="stylesheet" href="/subs/karaoke/style.css?v=2024-3-14">
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
<script src="https://cdn.plyr.io/3.7.2/plyr.polyfilled.js"></script>
<script src="/subs/karaoke/tracks.js"></script>
<script src="/subs/karaoke/script.js"></script>
<div style="overflow-x:auto">
<div class="container-player shadow" style="border-radius:20px;min-width:300px">
    <div class="column add-bottom">
        <div id="mainwrap">
            <div id="nowPlay">
              <span id="npTitle"></span><span id="npAction"></span>
            </div>
            <div id="audiowrap">
                <div id="audio0">
                    <audio id="audio1" preload controls>Your browser does not support HTML5 Audio! 😢</audio>
                </div>
                <div id="tracks">
                    <a id="btnPrev">&larr;</a><a id="btnNext">&rarr;</a>
                </div>
            </div>
            <div id="plwrap">
                <ul id="plList"></ul>
            </div>
        </div>
    </div>
    <div id="player-footer" class="column add-bottom center">
        <p><h2>Tank Engine Karaoke</h2></p><br/>
    </div>
</div>
</div>