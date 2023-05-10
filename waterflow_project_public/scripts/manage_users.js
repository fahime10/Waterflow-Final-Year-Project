// highlight a specific user
const userRows = document.getElementsByTagName('tr');

for (let i = 1; i < userRows.length; i++) {
    (function (index) {
        userRows[index].addEventListener("click", function() {

            const allRows = document.querySelectorAll("tr");
            allRows.forEach(row => {
                row.classList.remove("selected");
                row.classList.add("unselected");
                row.style.backgroundColor = "white";
            });

            userRows[index].classList.remove("unselected");
            userRows[index].classList.add("selected");
            userRows[index].style.backgroundColor = "aquamarine";

            document.getElementById("edit_user").disabled = false;
            document.getElementById("delete_user").disabled = false;
        });
    })(i);
}

function returnProjects() {
    document.getElementById("return").action = "project_overview";
    document.getElementById("return_projects").click();
}

document.getElementById("return_projects").addEventListener("click", returnProjects);

function editUser() {
    const allRows = document.querySelectorAll('tr');
    allRows.forEach(row => {
        if(row.style.backgroundColor === "aquamarine") {
            const data = {
                id: row.cells['user_id'].innerHTML,
                first_name: row.cells['first_name'].innerHTML,
                last_name: row.cells['last_name'].innerHTML,
                username: row.cells['username'].innerHTML,
                clearance: row.cells['clearance'].innerHTML
            };

            document.getElementById("edit").action = "edit_user";
            sessionStorage.setItem("user", JSON.stringify(data));
            document.getElementById("edit_user").click();
        }
    });
}

document.getElementById("edit_user").addEventListener("click", editUser);

function deleteUser() {
    const allRows = document.querySelectorAll('tr');
    allRows.forEach(row => {
        if(row.style.backgroundColor === "aquamarine") {
            const data = {
                id: row.cells['user_id'].innerHTML,
                first_name: row.cells['first_name'].innerHTML,
                last_name: row.cells['last_name'].innerHTML,
                username: row.cells['username'].innerHTML,
                clearance: row.cells['clearance'].innerHTML
            };

            document.getElementById("delete").action = "delete_user";
            sessionStorage.setItem("user", JSON.stringify(data));
            document.getElementById("delete_user").click();
        }
    });
}

document.getElementById("delete_user").addEventListener("click", deleteUser);