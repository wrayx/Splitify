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
        "<label>Member's E-mail</label>";
    form.insertBefore(node, addMemberBtn.parentElement);
}

// send todo contents to php file
// function createGroup(e) {
//     e.preventDefault();
//     let name = document.querySelector("#group-name").value;
//     let email = document.querySelector(".member-email").value;
//     if (trim(name) === "" || trim(email) === "") {
//         return;
//     }
//     let params = "name=" + name + "&email=" + email;
//     let xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//             if (this.responseText == "success") {
//                 // let todoListId = trim(todoSpace).toLowerCase();
//                 // let todolist = document.getElementById("todoList-" + todoListId);
//                 // let node = document.createElement("LI");
//                 // node.appendChild(document.createTextNode(todoContent));
//                 // node.innerHTML +=
//                 //     '<span class="todo-del-btn"><i class="fas fa-backspace"></i></span>';
//                 // todolist.appendChild(node);
//                 // todoListForm.reset();
//                 // enableTicks();
//                 // enableDelBtn();
//
//                 let node = document.createElement("DIV");
//                 node.classList.add("card");
//                 node.innerHTML = "";
//                 let row = document.createElement("TR");
//                 let cell = document.createElement("TD");
//                 cell.innerText = "3";
//                 row.appendChild(cell);
//                 cell.innerText = name;
//                 row.appendChild(cell);
//                 cell.innerText = email;
//             } else {
//                 console.log(this.responseText);
//                 console.log("That one already exist..");
//                 // Swal.fire({
//                 //     icon: "info",
//                 //     title: "The name alredy exist..",
//                 //     showConfirmButton: false,
//                 //     timer: 1500,
//                 //     customClass: "sweetalert-sm"
//                 // });
//             }
//         }
//     };
//     xhttp.open("POST", "includes/groups.inc.php", true);
//     xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     xhttp.send(params);
// }

function trim(str) {
    str = str.replace(/\s+/g, "");
    return str;
}
