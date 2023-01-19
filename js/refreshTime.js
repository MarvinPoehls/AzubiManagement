let timeParagraph = document.getElementById("time");

window.setInterval(setTime, 1000);

function setTime() {
    let time = new Date();
    timeParagraph.innerHTML = time.toLocaleString();
}