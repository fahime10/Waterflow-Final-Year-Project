const data = JSON.parse(sessionStorage.getItem('project'));

const row = document.createElement("tr");
const id = document.createElement("td");
id.textContent = data.id;

const project = document.createElement("td");
project.textContent = data.project;

const project_manager = document.createElement("td");
project_manager.textContent = data.project_manager;

const project_client = document.createElement("td");
project_client.textContent = data.project_client;

const due_date = document.createElement("td");
due_date.textContent = data.due_date;

document.getElementById("project_id").value = id.textContent;
document.getElementById("project_name").value = project.textContent;
document.getElementById("project_client").value = project_client.textContent;
document.getElementById("due_date").value = due_date.textContent;

row.appendChild(id);
row.appendChild(project);
row.appendChild(project_manager);
row.appendChild(project_client);
row.appendChild(due_date);

document.getElementById("project_to_edit").appendChild(row);

function resetProjectValues() {
    document.getElementById("project_name").value = "";
    document.getElementById("due_date").value = "";
}

document.getElementById("reset").addEventListener("click", resetProjectValues);

function cancelEdit() {
    resetProjectValues();

    document.getElementById("cancel").action = "project_overview";
    document.getElementById("cancel_edit").click();
}

document.getElementById("cancel_edit").addEventListener("click", cancelEdit);