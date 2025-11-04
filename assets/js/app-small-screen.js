function smallScreenWarning() {
    let windowWidth = 800;
    if (window.innerWidth < windowWidth) {
        document.getElementById("small-screen-warning").innerHTML = `
        <div class="modal fade" id="smallScreenModal" tabindex="-1" aria-labelledby="smallScreenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallScreenModalLabel">Screen Too Small</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                The screen size of your device is smaller than `+windowWidth+`px wide. 
                For the best experience, please use a desktop browser with a larger browser window.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
            </div>
            </div>
        </div>
        </div>
        `;
        const smallScreenModal = new bootstrap.Modal(document.getElementById('smallScreenModal'));
        smallScreenModal.show();
    }
}
window.onload = smallScreenWarning;