const data = JSON.parse(sessionStorage.getItem('user'));

const row = document.createElement("tr");
const id = document.createElement("td"); id.textContent = data.id;
const first_name = document.createElement("td"); first_name.textContent = data.first_name;
const last_name = document.createElement("td"); last_name.textContent = data.last_name;
const username = document.createElement("td"); username.textContent = data.username;
const clearance = document.createElement("td"); clearance.textContent = data.clearance;

document.getElementById("user_id").value = id.textContent;

row.appendChild(id);
row.appendChild(first_name);
row.appendChild(last_name);
row.appendChild(username);
row.appendChild(clearance);

document.getElementById("user_to_delete").appendChild(row);

function cancelDeleteUser() {
    document.getElementById("user_id").value = "";

    document.getElementById("cancel").action = "manage_users";
    document.getElementById("cancel_user_delete").click();
}

document.getElementById("cancel_user_delete").addEventListener("click", cancelDeleteUser);