const data = JSON.parse(sessionStorage.getItem('task'));

const row = document.createElement("tr");

const id = document.createElement("td");
id.textContent = data.id;

const project_id = document.createElement("td");
project_id.textContent = data.project_id_task;

const description = document.createElement("td");
description.textContent = data.description;

const assigned_to = document.createElement("td");
assigned_to.textContent = data.assigned_to;

const due_date = document.createElement("td");
due_date.textContent = data.due_date;

document.getElementById("task_id").value = id.textContent;
document.getElementById("project_id_task").value = project_id.textContent;
document.getElementById("task_description").value = description.textContent;
document.getElementById("task_due_date").value = due_date.textContent;

row.appendChild(id);
row.appendChild(project_id);
row.appendChild(description);
row.appendChild(assigned_to);
row.appendChild(due_date);

document.getElementById("task_to_edit").appendChild(row);

function resetTaskValues() {
    document.getElementById("task_description").value = "";
    document.getElementById("task_due_date").value = "";
}

document.getElementById("reset_task_values").addEventListener("click", resetTaskValues);

function cancelTaskEdit() {
    resetTaskValues();
    document.getElementById("task_id").value = "";

    document.getElementById("cancel_edit_task").formAction = "task_overview";
    document.getElementById("cancel_edit_task").click();
}

document.getElementById("cancel_edit_task").addEventListener("click", cancelTaskEdit);