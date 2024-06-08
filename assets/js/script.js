$(document).ready(function() {
    var alterMobileClass = function() {
        if (window.innerWidth < 701) {
            // $('#center-block').removeClass("align-items-center");
        } else {
            // $('#center-block').addClass("align-items-center");
        }
        if (window.innerWidth <= 991) {
            $('.home-div-span').removeClass("align-items-center");
        } else {
            $('.home-div-span').addClass("align-items-center");
        }
    }
    $(window).resize(function() {
        alterMobileClass();
    });
    alterMobileClass();

    $("#navbarAbout-menu > li").click(function(e) {
        $("#navbarSupportedContent").attr("class", "navbar-collapse collapse");
    });

    var navbarsubstimeout = null;
    $('#navbarSubs-button').click(function(e) {
        e.preventDefault();
        clearTimeout(navbarsubstimeout);
        $("#navbarSubs").removeClass('navbar-highlight');
        setTimeout(function () { 
        $("#navbarSupportedContent").attr("class", "navbar-collapse collapse show");
        $("#navbarSubs").addClass("navbar-highlight");
        }, 100);
        navbarsubstimeout = setTimeout(function () { 
            $("#navbarSubs").removeClass('navbar-highlight');
        }, 1100);
        $('#navbarSubs-button').html("<i class=\"fa-solid fa-circle-check\"></i> View Sub Perks in Navbar");
    });
});