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
let deleteModal = document.querySelector(".delete-modal");
let groupDeleteModal = document.querySelector(".group-delete-modal");
let delBtns = document.querySelectorAll(".del-btn");
let groupDelBtns = document.querySelectorAll(".del-group-btn");
let closeBtns = document.querySelectorAll(".close");
let cancelBtns = document.querySelectorAll(".cancel-btn");
function openModal(e) {
    if (e.target.classList.contains("del-btn") || e.target.parentElement.classList.contains("del-btn"))
        deleteModal.style.display = "block";
    if (e.target.classList.contains("del-group-btn") || e.target.parentElement.classList.contains("del-group-btn"))
        groupDeleteModal.style.display = "block";
}
function closeModal(e) {
    if (deleteModal.style.display === "block")
        deleteModal.style.display = "none";
    if (groupDeleteModal.style.display === "block")
        groupDeleteModal.style.display = "none";
}
function loopEvtListner(array, listenFor, functionExecute){
    for (let i = 0; i < array.length; i++) {
        array[i].addEventListener(listenFor, functionExecute);
    }
}
loopEvtListner(delBtns, "click", openModal);
loopEvtListner(groupDelBtns, "click", openModal);
loopEvtListner(closeBtns, "click", closeModal);
loopEvtListner(cancelBtns, "click", closeModal);