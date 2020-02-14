let groupOptions= document.querySelectorAll(".group-options");
let dropdown = document.querySelector(".dropdown");
let angle = document.querySelector(".fa-angle-down");
let selector = document.querySelector(".selector");
for (let i = 0; i < groupOptions.length; i++) {
    groupOptions[i].addEventListener("click", optionChange);
}

function optionChange(e){
    let optionText = e.target.textContent;
    for (let i = 0; i < groupOptions.length; i++) {
        groupOptions[i].classList.remove("active");
    }
    e.target.classList.add("active");
    selector.firstElementChild.innerHTML = optionText;
    dropdown.style.opacity = "0";
    dropdown.style.visibility = "hidden";
    angle.style.transitionDuration = "0.25s";
    angle.style.transform = "rotate(0Deg)";
}

selector.addEventListener("mouseover", displayDropdown);
// selector.addEventListener("mouseout", hideDropdown);
function displayDropdown(e){
    dropdown.style.opacity = "1";
    dropdown.style.visibility = "visible";
    dropdown.style.transform = "translate(0, 20px)";
    angle.style.transitionDuration = "0.25s";
    angle.style.transform = "rotate(180Deg)";
}
// window.addEventListener("click", hideDropdown);
// selector.addEventListener("click", displayDropdown);
dropdown.addEventListener("mouseout", hideDropdown);
function hideDropdown(e){
    dropdown.style.opacity = "0";
    dropdown.style.visibility = "hidden";
    angle.style.transitionDuration = "0.25s";
    angle.style.transform = "rotate(0Deg)";
}


// Get the pay-modal
let payModal = document.querySelector(".pay-modal");
let confirmModal = document.querySelector(".confirm-modal");
let deleteModal = document.querySelector(".delete-modal");

let payBtns = document.querySelectorAll(".pay-btn");
let cancelBtns = document.querySelectorAll(".cancel-btn");
let delBtns = document.querySelectorAll(".del-btn");
let confirmBtns = document.querySelectorAll(".confirm-btn");

let closeBtns = document.querySelectorAll(".close");
function loopEvtListner(array, listenFor, functionExecute){
    for (let i = 0; i < array.length; i++) {
        array[i].addEventListener(listenFor, functionExecute);
    }
}
loopEvtListner(payBtns, "click", openModal);
loopEvtListner(cancelBtns, "click", closeModal);
loopEvtListner(confirmBtns, "click", openModal);
loopEvtListner(delBtns, "click", openModal);
loopEvtListner(closeBtns, "click", closeModal);
function openModal(e) {
    if (e.target.classList.contains("confirm-btn") || e.target.parentElement.classList.contains("confirm-btn"))
        confirmModal.style.display = "block";
    else if (e.target.classList.contains("pay-btn"))
        payModal.style.display = "block";
    else if (e.target.classList.contains("del-btn"))
        deleteModal.style.display = "block";
}
function closeModal(e) {
    if (confirmModal.style.display === "block")
        confirmModal.style.display = "none";
    else if (payModal.style.display === "block")
        payModal.style.display = "none";
    else if (deleteModal.style.display === "block")
        deleteModal.style.display = "none";
}

let billSubmit = document.querySelector("#bill-form");
billSubmit.addEventListener("submit", sendInputGroup);

// send todo contents to php file
function sendInputGroup(e) {
    e.preventDefault();
    let groupname = document.querySelector("#input-group").textContent;
    let amount = document.querySelector("#amount").value;
    let name = document.querySelector("#name").value;
    // if (trim(name) === "" || trim(groupname) === "" || trim(amount) === "") {
    //     return;
    // }
    let params = "group=" + groupname +"&name="+name+"&amount="+amount;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };
    xhttp.open("POST", "includes/bills.inc.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
    // window.location.reload();
}

function trim(str) {
    str = str.replace(/\s+/g, "");
    return str;
}