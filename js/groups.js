import Modal from './modal.js';
let addMemberBtn = document.querySelector("#add-member-input");
// let groupForm = document.querySelector("#group-form")
addMemberBtn.addEventListener("click", addMemberInput);
// groupForm.addEventListener("submit", createGroup);
function addMemberInput() {
    let form = addMemberBtn.parentElement.parentElement;
    let node = document.createElement("DIV");
    node.classList.add("group");
    node.innerHTML += "<input type=\"text\" name=\"member-email[]\"  class=\"member-email\" required>\n" +
        "<span class=\"highlight\"></span>\n" +
        "<span class=\"bar\"></span>\n" +
        "<label>Member</label>";
    form.insertBefore(node, addMemberBtn.parentElement);
}

let deleteModals = document.querySelectorAll(".delete-modal");
let groupDeleteModals = document.querySelectorAll(".group-delete-modal");
for (let i = 0; i < deleteModals.length; i++) {
    let modal = new Modal('delete', Modal.getModalId(deleteModals[i].id));
    modal.addModalEvtListener();
}
for (let i = 0; i < groupDeleteModals.length; i++) {
    let modal = new Modal('deletegroup', Modal.getModalId(groupDeleteModals[i].id));
    modal.addModalEvtListener();
}
