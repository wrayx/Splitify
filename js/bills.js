import Modal from './modal.js';

let groupOptions = document.querySelectorAll(".group-options");
let dropdown = document.querySelector(".dropdown");
let angle = document.querySelector(".fa-angle-down");
let selector = document.querySelector(".selector");
for (let i = 0; i < groupOptions.length; i++) {
    groupOptions[i].addEventListener("click", optionChange);
}

function optionChange(e) {
    let optionText = e.target.textContent;
    for (let i = 0; i < groupOptions.length; i++) {
        groupOptions[i].classList.remove("active");
    }
    e.target.classList.add("active");
    selector.firstElementChild.innerHTML = optionText;
    hideDropdown();
}

selector.addEventListener("click", displayDropdown);

function displayDropdown() {
    dropdown.style.opacity = "1";
    dropdown.style.visibility = "visible";
    dropdown.style.transform = "translate(0, 20px)";
    angle.style.transitionDuration = "0.25s";
    angle.style.transform = "rotate(180Deg)";
}

// window.addEventListener("click", hideDropdown);
// selector.addEventListener("click", displayDropdown);
dropdown.addEventListener("mouseout", hideDropdown);

function hideDropdown() {
    dropdown.style.opacity = "0";
    dropdown.style.visibility = "hidden";
    angle.style.transitionDuration = "0.25s";
    angle.style.transform = "rotate(0Deg)";
}

let billSubmit = document.querySelector("#bill-form");
billSubmit.addEventListener("submit", sendInputGroup);

// send todo contents to php file
function sendInputGroup(e) {
    e.preventDefault();
    let groupname = document.querySelector("#input-group").textContent;
    let amount = document.querySelector("#amount").value;
    let name = document.querySelector("#name").value;
    if (groupname === "Choose a Group") {
        return;
    }
    let params = "group=" + groupname + "&name=" + name + "&amount=" + amount;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
        }
    };
    xhttp.open("POST", "includes/bills.inc.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
    window.location.reload();
}

function trim(str) {
    str = str.replace(/\s+/g, "");
    return str;
}

let payModals = document.querySelectorAll(".pay-modal");
let confirmModals = document.querySelectorAll(".confirm-modal");
let deleteModals = document.querySelectorAll(".delete-modal");
for (let i = 0; i < payModals.length; i++) {
    let modal = new Modal('pay', Modal.getModalId(payModals[i].id));
    modal.addModalEvtListener();
}
for (let i = 0; i < confirmModals.length; i++) {
    let modal = new Modal('confirm', Modal.getModalId(confirmModals[i].id));
    modal.addModalEvtListener();
}
for (let i = 0; i < deleteModals.length; i++) {
    let modal = new Modal('delete', Modal.getModalId(deleteModals[i].id));
    modal.addModalEvtListener();
}