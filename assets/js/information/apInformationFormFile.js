$('#user-id-all')
document.getElementById('user-id-all').addEventListener('click', onClicktoggleCheckbox);

function onClicktoggleCheckbox(e) {
    let checkOrNotCheck = document.getElementById('user-id-all').checked;
    let checkedUser = [];
    document.querySelectorAll('.form-target-check-user input').forEach(function (e) {
        e.checked = checkOrNotCheck;
        if (e.checked) {
            checkedUser.push(e.dataset.id);
        }
        document.getElementById('choseUsers').value = checkedUser;
        }
    )  
}

function saveCheckedUser() {
    let checkedUser = [];
    document.querySelectorAll('.form-target-check-user input').forEach(function (e) {
        if (e.checked) {
            checkedUser.push(e.dataset.id);
        }
    })
    document.getElementById('choseUsers').value = checkedUser;
    console.log(checkedUser);
}
console.log(document.getElementById('choseUsers').value);

document.querySelectorAll('.form-target-check-user input').forEach(function (e) {
e.addEventListener('click', saveCheckedUser);
})

saveCheckedUser();