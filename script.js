
function confirmSubmit() {
    if(confirm("Are you sure you want to submit?")){
        window.location.href = "save_result.php";
    }
}


function goBackConfirm() {
    if(confirm("Go back to student selection?")){
        window.location.href = "select_student.php";
    }
}
function validateForm() {

    let inputs = document.querySelectorAll("input[type='number']");
    
    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value === "") {
            alert("Please fill in all marks before submitting!");
            inputs[i].focus(); // 跳到没填的地方
            return false; // 阻止提交
        }
    }

    // 评论也检查
    let comment = document.getElementById("comment").value;
    if (comment.trim() === "") {
        alert("Please enter your comments!");
        return false;
    }

    // 最后确认
    return confirm("Are you sure you want to submit?");
}