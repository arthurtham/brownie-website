jQuery(function ($) {
    'use strict'
    var supportsAudio = !!document.createElement('audio').canPlayType;
    if (supportsAudio) {
        var cacheMedia = {};

        // initialize plyr
        var player = new Plyr('#audio1', {
            controls: [
                'play',
                'progress',
                'current-time',
                'duration',
                'mute',
                'volume',
                'download',
            ]
        });
        // initialize playlist and controls
        var index = 0,
            playing = false,
            mediaPath = '',
            extension = '',
            tracks = myTracks,
            buildPlaylist = $.each(tracks, function(key, value) {
                var trackNumber = value.track,
                    trackName = value.name,
                    trackDuration = value.duration;
                if (trackNumber.toString().length === 1) {
                    trackNumber = '0' + trackNumber;
                }
                $('#plList').append('<li> \
                    <div class="plItem"> \
                        <span class="plNum">' + trackNumber + '.</span> \
                        <span class="plTitle">' + trackName + '</span> \
                        <span class="plLength">' + trackDuration + '</span> \
                    </div> \
                </li>');
            }),
            trackCount = tracks.length,
            npAction = $('#npAction'),
            npTitle = $('#npTitle'),
            npFooter = $('#npFooter'),
            audio = $('#audio1').on('play', function () {
                playing = true;
                var htmlcontents = "<span class=\"bounce\"><i class=\"fa-solid fa-train\"></i> Choo-choo</span>";
                npAction.html(htmlcontents);
            }).on('pause', function () {
                playing = false;
                var htmlcontents = "<span><i class=\"fa-solid fa-train\"></i> Pause</span>";
                npAction.html(htmlcontents);
            }).on('ended', function () {
                var htmlcontents = "<span><i class=\"fa-solid fa-train\"></i> Pause</span>";
                npAction.html(htmlcontents);
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    // audio.play();
                } else {
                    // audio.pause();
                    index = 0;
                    loadTrack(index);
                    // audio.play();
                }
            }).get(0),
            btnPrev = $('#btnPrev').on('click', function () {
                if ((index - 1) > -1) {
                    index--;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            btnNext = $('#btnNext').on('click', function () {
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            li = $('#plList li').on('click', function () {
                var id = parseInt($(this).index());
                if (id !== index) {
                    playTrack(id);
                }
            }),
            loadTrack = async function (id) {
                playing = false;
                if (audio) {
                    audio.pause();
                }
                var htmlcontents = "<span><i class=\"fa-solid fa-spinner\"></i> Loading...</span>";
                npAction.html(htmlcontents);
                var success = false;
                if (cacheMedia["com-browntulstar-tek-"+tracks[id].file]) {
                    audio.src = cacheMedia["com-browntulstar-tek-"+tracks[id].file];
                    success = true;
                } else {
                    var cldMediaUrl = null;
                    try {
                        await $.ajax({
                            url: 'track-signer.php',
                            method: 'POST',
                            data: { 'track-id': tracks[id].file },
                            dataType: 'json',
                            async: false,
                            success: function(response) {
                                if (response.success) {
                                    cldMediaUrl = response.url;
                                } else {
                                    alert('An error occurred. Please try again later.');
                                }
                            },
                            error: function() {
                                alert('An error occurred. Please try again later.');
                            }
                        });
                    } catch {
                        //continue
                    }
                    if (cldMediaUrl) {
                        const response = await fetch(cldMediaUrl);
                        if (response.status === 200) {
                            const blob = await response.blob();
                            audio.src = URL.createObjectURL(blob);
                            cacheMedia["com-browntulstar-tek-"+tracks[id].file] = audio.src;
                            success = true;
                        } else {
                            alert('An error occurred. Please try again later.');
                        }
                    }
                }

                if (success) {
                    $('.plSel').removeClass('plSel');
                    $('#plList li:eq(' + id + ')').addClass('plSel');
                    npTitle.text(tracks[id].name);
                    index = id;
                    updateDownload(id, audio.src);
                    audio.play();
                    var htmlcontents = "<span class=\"bounce\"><i class=\"fa-solid fa-train\"></i> Choo-choo</span>";
                    npAction.html(htmlcontents);                
                } else {
                    var htmlcontents = "<span><i class=\"fa-solid fa-ban\"></i> Error</span>";
                    npAction.html(htmlcontents);
                }
            },
            updateDownload = function (id, source) {
                player.on('loadedmetadata', function () {
                    $('a[data-plyr="download"]').attr('href', source);
                });
            },
            playTrack = function (id) {
                loadTrack(id);
                // audio.play();
            };
        extension = audio.canPlayType('audio/mpeg') ? '.mp3' : audio.canPlayType('audio/ogg') ? '.ogg' : '';
        loadTrack(index);
    } else {
        // no audio support
        $('.column').addClass('hidden');
        var noSupport = $('#audio1').text();
        $('.container').append('<p class="no-support">' + noSupport + '</p>');
    }
});