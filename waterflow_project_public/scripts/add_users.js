function validateUserAdd() {
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

    if (document.getElementById("clearance_error").style.display === "none" &&
        document.getElementById("name_error").style.display === "none") {
        document.getElementById("add_user").action = "manage_users";
        document.getElementById("confirmed").click();
    }
}

document.getElementById("confirmed").addEventListener('click', validateUserAdd);

function resetUserValues() {
    document.getElementById("first_name").value = "";
    document.getElementById("last_name").value = "";
    document.getElementById("username").value = "";
    document.getElementById("password").value = "";
    document.getElementById("clearance").value = "";
}

document.getElementById("reset").addEventListener("click", resetUserValues);