const data = JSON.parse(sessionStorage.getItem('project'));

const row = document.createElement("tr");
const id = document.createElement("td"); id.textContent = data.id;
const project = document.createElement("td"); project.textContent = data.project;
const project_manager = document.createElement("td"); project_manager.textContent = data.project_manager;
const stakeholder = document.createElement("td"); stakeholder.textContent = data.stakeholder;
const due_date = document.createElement("td"); due_date.textContent = data.due_date;

row.appendChild(id);
row.appendChild(project);
row.appendChild(project_manager);
row.appendChild(stakeholder);
row.appendChild(due_date);

document.getElementById("project_to_delete").appendChild(row);

document.getElementById("project_id").value = id.textContent;

function cancelDelete() {
    document.getElementById("project_id").value = "";
}

document.getElementById("cancel_delete").addEventListener("click", cancelDelete);