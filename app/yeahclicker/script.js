const bodycontainer = document.body;
const yeahbutton = document.getElementById("yeahbutton");
const yeahbuttoncounterspan = document.getElementById("yeahbuttoncounter");
let yeahbuttoncounter = parseInt(localStorage.getItem("yeahbuttonscore")) || 0;
yeahbuttoncounterspan.innerText = yeahbuttoncounter.toLocaleString();

yeahbutton.addEventListener("mouseenter", function(e) {
    yeahbutton.classList.add("yeahbuttonhover");
}); 
yeahbutton.addEventListener("mouseleave", function(e) {
    yeahbutton.classList.remove("yeahbuttonhover");
}); 
bodycontainer.addEventListener("keydown", function(e) {
    if (e.key == " ") {
        yeahbutton.classList.add("yeahbuttonhover");
        onButtonDown();
    }
});
yeahbutton.addEventListener("mousedown", function(e) {
    onButtonDown();
}); 
bodycontainer.addEventListener("keyup", function(e) {
    if (e.key == " ") {
        onButtonUp();
    }});
yeahbutton.addEventListener("mouseup", function(e) {
    onButtonUp();
}); 

function onButtonDown() {
    yeahbutton.classList.add("yeahbuttondown");
}
function onButtonUp() {
    yeahbutton.classList.remove("yeahbuttondown");
    yeahbuttoncounter += 1;
    localStorage.setItem("yeahbuttonscore", yeahbuttoncounter.toString());
    updateYeahButtonPresentation();
}

function updateYeahButtonPresentation() {
    yeahbuttoncounterspan.innerText = yeahbuttoncounter.toLocaleString();
    if (yeahbuttoncounter % 200 >= 100) {
        bodycontainer.classList.add("profile");
        yeahbuttoncounterspan.classList.add("text-white");
    } else {
        bodycontainer.classList.remove("profile");
        yeahbuttoncounterspan.classList.remove("text-white");
    }
}
updateYeahButtonPresentation();