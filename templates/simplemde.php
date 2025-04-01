<?php 
if (is_null($simplemde_element_name)) {
    $simplemde_element_name = "";
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>

let simplemde = new SimpleMDE({ 
    element: document.getElementById("<?=$simplemde_element_name ?>"),
    forceSync: true
});

function toggleFooter(visible) {
    if (visible) {
        $("#admin-mode-footer").removeClass("d-none");
    } else {
        $("#admin-mode-footer").addClass("d-none");
    }
}
// add an event listener for the window that runs on mouse click or keyboard press
document.addEventListener("click", function() {
    toggleFooter(!simplemde.isFullscreenActive());
});
document.addEventListener("keydown", function() {
    toggleFooter(!simplemde.isFullscreenActive());
});
</script>