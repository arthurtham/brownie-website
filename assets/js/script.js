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