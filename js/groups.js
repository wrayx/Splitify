import Modal from './modal.js';

let addMemberBtn = document.querySelector("#add-member-input");
// let groupForm = document.querySelector("#group-form")
addMemberBtn.addEventListener("click", addMemberInput);

// groupForm.addEventListener("submit", createGroup);
function addMemberInput() {
    let form = addMemberBtn.parentElement.parentElement;
    let node = document.createElement("DIV");
    node.classList.add("group");
    node.innerHTML += "<input type=\"text\" name=\"members[]\"  class=\"member-email\" required>\n" +
        "<span class=\"highlight\"></span>\n" +
        "<span class=\"bar\"></span>\n" +
        "<label>Member</label>";
    form.insertBefore(node, addMemberBtn.parentElement);
}

let deleteModals = document.querySelectorAll(".delete-modal");
let groupDeleteModals = document.querySelectorAll(".group-delete-modal");
deleteModals.forEach(deleteModal => {
    let id = Modal.getModalId(deleteModal.id);
    let modal = new Modal('delete', id);
    let proceed = document.querySelector(`#${modal.htmlProceedId()}`);
    modal.addModalEvtListener();
    proceed.addEventListener('click', () => {
        deleteMember(id);
    });
});
groupDeleteModals.forEach(groupDeleteModal => {
    let id = Modal.getModalId(groupDeleteModal.id);
    let modal = new Modal('deletegroup', id);
    let proceed = document.querySelector(`#${modal.htmlProceedId()}`);
    modal.addModalEvtListener();
    proceed.addEventListener('click', () => {
        deleteGroup(id);
    });
});

function deleteMember(id) {
    let groupid = (document.getElementById("delete-modal-trigger-" + id).parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.id).split('-').pop();
    // console.log(groupName);
    let params = `deleteMemberId=${id}&groupid=${groupid}`;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            let modal = new Modal('delete', id);
            let trigger = document.querySelector(`#${modal.htmlTriggerId()}`);
            let row = trigger.parentElement.parentElement;
            let remainingModal = document.querySelector(`#${modal.htmlModalId()}`);
            if (row.parentElement.childElementCount === 1) {
                let card = row.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
                deleteGroup(card.id.split('-').pop());
            } else {
                row.parentElement.removeChild(row);
                remainingModal.parentElement.removeChild(remainingModal);
            }
        }
    };
    xhttp.open("POST", "includes/groups.inc.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
}

function deleteGroup(id) {
    let params = `deleteGroupId=${id}`;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            let modal = new Modal('deletegroup', id);
            let groupCard = document.querySelector(`#group-card-${id}`);
            let remainingModal = document.querySelector(`#${modal.htmlModalId()}`);
            groupCard.parentElement.removeChild(groupCard);
            remainingModal.parentElement.parentElement.removeChild(remainingModal.parentElement);
        }
    };
    xhttp.open("POST", "includes/groups.inc.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
}