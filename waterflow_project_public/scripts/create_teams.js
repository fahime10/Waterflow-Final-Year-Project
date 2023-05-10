let counter = 2;

function confirmTeam() {
    document.getElementById("form").action = "confirm_team";
    document.getElementById("confirm").click();
}

document.getElementById("confirm").addEventListener("click", confirmTeam);

function cancelTeamCreation() {
    document.getElementById("form").reset();
    document.getElementById("form").action = "project_overview";
    document.getElementById("cancel").click();
}

document.getElementById("cancel").addEventListener("click", cancelTeamCreation);

function addUserInput() {
    let internalCounter = counter + 1;
    const label = document.createElement('label');
    label.id = "user_" + (internalCounter).toString();
    label.textContent = "Username: ";
    label.style.padding = "10px 10px 10px 0";

    const input = document.createElement('input');
    input.type = "text";
    input.id = "user_" + (internalCounter).toString();
    input.name = input.id;
    input.maxLength = 20;
    input.required = true;

    label.appendChild(input);

    const latest = document.getElementById('user_' + counter);

    latest.parentNode.insertBefore(label, latest.nextSibling);
    counter++;
}

document.getElementById("add").addEventListener("click", addUserInput);

function deleteUserInput() {
    if (counter > 2) {
        document.getElementById("user_" + counter).remove();
        counter--;
    }
}

document.getElementById("remove").addEventListener("click", deleteUserInput);