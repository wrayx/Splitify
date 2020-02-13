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
let delBtns = document.querySelectorAll(".del-btn");
let confirmBtns = document.querySelectorAll(".confirm-btn");

let closeBtns = document.querySelectorAll(".close");

for (let i = 0; i < payBtns.length; i++) {
    payBtns[i].addEventListener("click", openModal);
}
for (let i = 0; i < confirmBtns.length; i++) {
    confirmBtns[i].addEventListener("click", openModal);
}
for (let i = 0; i < delBtns.length; i++) {
    delBtns[i].addEventListener("click", openModal);
}
for (let i = 0; i < closeBtns.length; i++) {
    closeBtns[i].addEventListener("click", closeModal);
}
function openModal(e) {
    if (e.target.classList.contains("confirm-btn"))
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