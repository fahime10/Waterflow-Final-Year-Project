const data = JSON.parse(sessionStorage.getItem('user'));

const row = document.createElement("tr");
const id = document.createElement("td"); id.textContent = data.id;
const first_name = document.createElement("td"); first_name.textContent = data.first_name;
const last_name = document.createElement("td"); last_name.textContent = data.last_name;
const username = document.createElement("td"); username.textContent = data.username;
const clearance = document.createElement("td"); clearance.textContent = data.clearance;

document.getElementById("user_id").value = id.textContent;
document.getElementById("first_name").value = first_name.textContent;
document.getElementById("last_name").value = last_name.textContent;
document.getElementById("username").value = username.textContent;
document.getElementById("clearance").value = clearance.textContent;

row.appendChild(id);
row.appendChild(first_name);
row.appendChild(last_name);
row.appendChild(username);
row.appendChild(clearance);

document.getElementById("user_to_edit").appendChild(row);

function validateUserEdit() {
    let first_name = document.getElementById("first_name").value;
    let last_name = document.getElementById("last_name").value;
    let clearance = document.getElementById("clearance").value;

    // validate full name
    if ((!first_name.match("^[A-Za-z]") || first_name === '') ||
        (!last_name.match("^[A-Za-z]") || last_name === '') ) {
        document.getElementById("name_error").style.display = "block";
    } else {
        document.getElementById("name_error").style.display = "none";
    }

    // validate clearance value
    if (clearance < 1 || clearance > 5 || isNaN(clearance)) {
        document.getElementById("clearance_error").style.display = "block";
    } else {
        document.getElementById("clearance_error").style.display = "none";
    }

    if(document.getElementById("name_error").style.display === "none" &&
        document.getElementById("clearance_error").style.display === "none") {

        document.getElementById("edit_user").action = "manage_users";
        document.getElementById("confirmed").click();
    }
}

document.getElementById("confirmed").addEventListener("click", validateUserEdit);

function resetUserValues() {
    document.getElementById("first_name").value = "";
    document.getElementById("last_name").value = "";
    document.getElementById("username").value = "";
    document.getElementById("password").value = "";
    document.getElementById("clearance").value = "";
}

document.getElementById("reset_user_edit_values").addEventListener("click", resetUserValues);

function cancelEditUser() {
    resetUserValues();

    document.getElementById("user_id"). value = "";
}

document.getElementById("cancel_user_edit").addEventListener("click", cancelEditUser);