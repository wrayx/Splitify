import Modal from './modal.js';

const groupOptions = document.querySelectorAll(".group-options");
const dropdown = document.querySelector(".dropdown");
const angle = document.querySelector(".fa-angle-down");
const selectorTrigger = document.querySelector("#input-group");
const selector = document.querySelector(".selector");
for (let i = 0; i < groupOptions.length; i++) {
    groupOptions[i].addEventListener("click", (e) => {
        optionChange(e);
        hideDropdown();
    });
}
// dropdown.addEventListener("mouseout", hideDropdown);
selectorTrigger.addEventListener("click", displayDropdown);
angle.addEventListener("click", displayDropdown);

// window.addEventListener("click", hideDropdown, true);

function optionChange(e) {
    hideDropdown();
    let optionText = e.target.textContent;
    groupOptions.forEach(groupOption => {
        groupOption.classList.remove("active");
    });
    e.target.classList.add("active");
    selector.firstElementChild.innerHTML = optionText;
    document.getElementById("input-group-name").setAttribute("value", document.querySelector("#input-group").textContent);
}

function displayDropdown() {
    dropdown.style.opacity = "1";
    dropdown.style.visibility = "visible";
    dropdown.style.transform = "translate(0, 20px)";
    angle.style.transitionDuration = "0.25s";
    angle.style.transform = "rotate(180Deg)";
}

function hideDropdown() {
    dropdown.style.opacity = "0";
    dropdown.style.visibility = "hidden";
    dropdown.style.transform = "translate(0, 0px)";
    angle.style.transitionDuration = "0.25s";
    angle.style.transform = "rotate(0Deg)";
}

// let billSubmit = document.querySelector("#bill-submit");
// billSubmit.addEventListener("click", () => {
//
// });

// send todo contents to php file
function sendInputBill(e) {

    // e.preventDefault();
    // let groupname = document.querySelector("#input-group").textContent;
    // let amount = document.querySelector("#amount").value;
    // let name = document.querySelector("#name").value;
    // let paid = document.querySelector('#bill-self-paid').checked;
    // if (groupname === "Choose a Group") {
    //     return;
    // }
    // let params = `group=${groupname}&name=${name}&amount=${amount}&paid=${paid}`;
    // let xhttp = new XMLHttpRequest();
    // xhttp.onreadystatechange = function () {
    //     if (this.readyState === 4 && this.status === 200) {
    //         console.log(this.responseText);
    //         window.location.reload();
    //         if (this.responseText == 'param-invalid') {
    //             addAlert(1, "Please input in the correct format");
    //             return;
    //         } else if (this.responseText == 'param-missing') {
    //             addAlert(1, 'Please complete all fields');
    //             return;
    //         }
    //     }
    // };
    // xhttp.open("POST", "includes/bills.inc.php");
    // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // xhttp.send(params);
    // window.location.reload();
}

function trim(str) {
    str = str.replace(/\s+/g, "");
    return str;
}

let payModals = document.querySelectorAll(".pay-modal");
let confirmModals = document.querySelectorAll(".confirm-modal");
let deleteModals = document.querySelectorAll(".delete-modal");
payModals.forEach(payModal => {
    let id = Modal.getModalId(payModal.id);
    let modal = new Modal('pay', id);
    let proceed = document.querySelector(`#${modal.htmlProceedId()}`);
    modal.addModalEvtListener();
    proceed.addEventListener("click", function () {
        payBill(id);
    });
});
confirmModals.forEach(confirmModal => {
    let id = Modal.getModalId(confirmModal.id);
    let modal = new Modal('confirm', id);
    let proceed = document.querySelector(`#${modal.htmlProceedId()}`);
    modal.addModalEvtListener();
    proceed.addEventListener("click", function () {
        confirmBill(id);
    });
});
deleteModals.forEach(deleteModal => {
    let id = Modal.getModalId(deleteModal.id);
    let modal = new Modal('delete', id);
    let proceed = document.querySelector(`#${modal.htmlProceedId()}`);
    modal.addModalEvtListener();
    // if they proceed to delete the bill, we will remove the bill
    // from both database and the website
    proceed.addEventListener("click", function () {
        deleteBill(id);
    });
});

function deleteBill(id) {
    let params = "deleteId=" + id;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            let modal = new Modal('delete', id);
            let trigger = document.querySelector(`#${modal.htmlTriggerId()}`);
            let rowNum = trigger.parentElement.getAttribute("rowspan");
            let row = trigger.parentElement.parentElement;
            let remainingModal = document.querySelector(`#${modal.htmlModalId()}`);
            while (rowNum > 1) {
                row.parentElement.removeChild(row.nextElementSibling);
                rowNum--;
            }
            row.parentElement.removeChild(row);
            remainingModal.parentElement.parentElement.removeChild(remainingModal.parentElement);
        }
    };
    xhttp.open("POST", "includes/bills.inc.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
}

function payBill(id) {
    let params = "paySplitBillId=" + id;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            let modal = new Modal('pay', id);
            let trigger = document.querySelector(`#${modal.htmlTriggerId()}`);
            let remainingModal = document.querySelector(`#${modal.htmlModalId()}`);
            let row = trigger.parentElement.parentElement;
            row.parentElement.removeChild(row);
            remainingModal.parentElement.removeChild(remainingModal);
        }
    };
    xhttp.open("POST", "includes/bills.inc.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
}

function confirmBill(id) {
    let params = "paySplitBillId=" + id;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            window.location.reload();
        }
    };
    xhttp.open("POST", "includes/bills.inc.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
}

// function addAlert(type, message) {
//     let node = document.createElement("DIV");
//     node.classList.add('alert');
//     if (type === 0) {
//         node.classList.add('info');
//     }
//     node.innerHTML = "<span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\"><i class=\"fas fa-times\"></i></span>" + message;
//     document.querySelector('.container').insertBefore(node, document.querySelector(".card"));
// }