const projectRows = document.getElementsByTagName("tr");

for (let i = 1; i < projectRows.length; i++) {
    (function (index) {
        projectRows[index].addEventListener('click', function() {

            const allRows = document.querySelectorAll("tr");
            allRows.forEach(row => {
                row.classList.remove("selected");
                row.classList.add("unselected");
                row.style.backgroundColor = "white";
            });

            projectRows[index].classList.remove("unselected");
            projectRows[index].classList.add("selected");
            projectRows[index].style.backgroundColor = "aquamarine";

            document.getElementById("edit_project").disabled = false;
            document.getElementById("delete_project").disabled = false;
            document.getElementById("select_project").disabled = false;
        });
    })(i);
}

function selectProject() {
    const allRows = document.querySelectorAll("tr");
    allRows.forEach(row => {
        if(row.style.backgroundColor === "aquamarine") {
            const data = {
                id: row.cells['project_id'].innerHTML,
                project: row.cells['project'].innerHTML,
                project_finished: row.cells['finished'].innerHTML
            }

            document.getElementById("project_id_task").value = row.cells['project_id'].innerHTML;
            document.getElementById("select").action = "task_overview";
            sessionStorage.setItem("project", JSON.stringify(data));
            document.getElementById("select_project").click();
        }
    });
}

document.getElementById("select_project").addEventListener("click", selectProject);

function editProject() {
    const allRows = document.querySelectorAll("tr");
    allRows.forEach(row => {
        if(row.style.backgroundColor === "aquamarine") {
            const data = {
                id: row.cells['project_id'].innerHTML,
                project: row.cells['project'].innerHTML,
                project_manager: row.cells['project_manager'].innerHTML,
                project_client: row.cells['project_client'].innerHTML,
                due_date: row.cells['due_date'].innerHTML,
                project_finished: row.cells['finished'].innerHTML
            };

            if (data["project_finished"] !== "Yes") {
                document.getElementById("edit").action = "edit_project";
                sessionStorage.setItem("project", JSON.stringify(data));
                document.getElementById("edit_project").click();
            }
        }
    });
}

document.getElementById("edit_project").addEventListener("click", editProject);

function deleteProject() {
    const allRows = document.querySelectorAll("tr");
    allRows.forEach(row => {
        if(row.style.backgroundColor === "aquamarine") {
            const data = {
                id: row.cells['project_id'].innerHTML,
                project: row.cells['project'].innerHTML,
                project_manager: row.cells['project_manager'].innerHTML,
                stakeholder: row.cells['project_client'].innerHTML,
                due_date: row.cells['due_date'].innerHTML
            };

            document.getElementById("delete").action = "delete_project";
            sessionStorage.setItem("project", JSON.stringify(data));
            document.getElementById("delete_project").click();
        }
    });
}

document.getElementById("delete_project").addEventListener("click", deleteProject);