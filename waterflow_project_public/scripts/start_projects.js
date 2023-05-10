function resetProjectValues() {
    document.getElementById("project_name").value = "";
    document.getElementById("due_date").value = "";
}

function cancelProjectStart() {
    resetProjectValues();

    document.getElementById("cancel").action = "project_overview";
    document.getElementById("cancel_project").click();
}

document.getElementById("cancel_project").addEventListener("click", cancelProjectStart);