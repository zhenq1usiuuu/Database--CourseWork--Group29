function validateAdmin(form){
    fail = validatename(form.Name.value);
    fail += validateusername(form.Username.value);
    fail += validatepassword(form.Password.value);
    if (fail == "") return true;
    else { alert(fail); return false };
}
function validatename(field) {
    if (field == "") return "No name was entered.\n";
    return "";
}
function validateusername(field) {
    if (field == "") return "No username was entered.\n";
    else if (field.length < 5) return "Usernames must be at least 5 characters.\n";
    else if (/[^a-zA-Z0-9_-]/.test(field)) return "Only a-z, A-Z, 0-9, - and _ allowed in usernames.\n";
    return "";

}
function validatepassword(field) {
    if (field == "") return "No password was entered.\n";
    else if (field.length < 6) return "Passwords must be at least 6 characters.\n";
    else if (/[^a-zA-Z0-9_-]/.test(field)) return "Only a-z, A-Z, 0-9, - and _ allowed in passwords.\n";
    return "";
}
function validaterole(field) {
    if (field == "") return "No role was selected.\n";
    return "";
}
function validateAssessor(form){
    fail = validatename(form.Name.value);
    fail += validateusername(form.Username.value);
    fail += validatepassword(form.Password.value);
    fail += validaterole(form.Role.value);
    if (fail == "") return true;
    else { alert(fail); return false };
}