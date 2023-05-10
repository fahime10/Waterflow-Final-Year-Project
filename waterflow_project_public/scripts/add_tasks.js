const data = JSON.parse(sessionStorage.getItem('project'));
const project_id = document.getElementById("project_id_task");
project_id.value = data.id;

function resetTaskValues() {
    document.getElementById("task_description").value = "";
    document.getElementById("task_due_date").value = "";
    document.getElementById("task_assigned").value = "";
}

function cancelTaskAdd() {
    resetTaskValues();

    document.getElementById("cancel_task").formAction = "task_overview";
    document.getElementById("cancel_task").click();
}

document.getElementById("cancel_task").addEventListener("click", cancelTaskAdd);