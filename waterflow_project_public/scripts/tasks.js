const data = JSON.parse(sessionStorage.getItem('project'));

function returnProjects() {
    document.querySelectorAll("input").value = "";

    document.getElementById("return").action = "project_overview";
    document.getElementById("return_projects").click();
}

document.getElementById("return_projects").addEventListener("click", returnProjects);

const project_name = data.project;
document.getElementById("title").textContent = "Project title: " + project_name;

const finished = data.project_finished;

if (finished === "Yes") {
    document.getElementById("add_task").disabled = true;
    document.getElementById("edit_task").disabled = true;
    document.getElementById("delete_task").disabled = true;

    document.getElementById("saving_progress").disabled = true;
    document.getElementById("request").textContent = "Project finished";
    document.getElementById("request").disabled = true;
}

// highlight a specific task
const taskRows = document.getElementsByTagName("tr");

for (let i = 1; i < taskRows.length; i++) {
    (function (index) {
        taskRows[index].addEventListener("click", function() {

            const allRows = document.querySelectorAll("tr");
            allRows.forEach(row => {
                row.classList.remove("selected");
                row.classList.add("unselected");
                row.style.backgroundColor = "white";
            });

            taskRows[index].classList.remove("unselected");
            taskRows[index].classList.add("selected");
            taskRows[index].style.backgroundColor = "aquamarine";

            document.getElementById("edit_task").disabled = false;
            document.getElementById("delete_task").disabled = false;
        });
    })(i);
}

function editTask() {
    const allRows = document.querySelectorAll("tr");
    allRows.forEach(row => {
        if(row.style.backgroundColor === "aquamarine") {
            const data = {
                id: row.cells['task_id'].innerHTML,
                project_id_task: row.cells['project_id_task'].innerHTML,
                description: row.cells['description'].innerHTML,
                assigned_to: row.cells['assigned_to'].innerHTML,
                due_date: row.cells['due_date'].innerHTML
            };

            document.getElementById("edit").action = "edit_task";
            sessionStorage.setItem("task", JSON.stringify(data));
            document.getElementById("edit_task").click();
        }
    });
}

document.getElementById("edit").addEventListener("click", editTask);

function deleteTask() {
    const allRows = document.querySelectorAll("tr");
    allRows.forEach(row => {
        if (row.style.backgroundColor === "aquamarine") {
            const data = {
                id: row.cells['task_id'].innerHTML,
                project_id_task: row.cells['project_id_task'].innerHTML,
                description: row.cells['description'].innerHTML,
                assigned_to: row.cells['assigned_to'].innerHTML,
                due_date: row.cells['due_date'].innerHTML
            };

            document.getElementById("delete").action = "delete_task"
            sessionStorage.setItem("task", JSON.stringify(data));
            document.getElementById("delete_task").click();
        }
    });
}

document.getElementById("delete").addEventListener("click", deleteTask);

function viewQuestion() {
    document.getElementById("question").style.display = "block";
}

document.getElementById("request").addEventListener('click', viewQuestion);

function confirm() {
    document.getElementById("project_name").style.display = "block";
    document.getElementById("confirmEnd").style.display = "block";
}

document.getElementById("yes").addEventListener("click", confirm);

function endProject() {
    document.getElementById("end_project").action = "end_project";
    document.getElementById("confirmEnd").click();
}

document.getElementById("confirmEnd").addEventListener("click", endProject);

function refuse() {
    document.getElementById("question").style.display = "none";
}

document.getElementById("no").addEventListener("click", refuse);