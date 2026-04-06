//Used to help control account.php.
function toggleField(inputId, btnId, endpoint) {
    const input = document.getElementById(inputId);
    const btn   = document.getElementById(btnId);

    if (input.disabled) {
        btn.dataset.originalLabel = btn.value; // store it right before we change it
        input.disabled = false;
        input.focus();
        btn.value = "Save";
    } else {
        fetch(endpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ value: input.value })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                input.disabled = true;
                btn.value = btn.dataset.originalLabel; // restore it
            } else {
                alert(data.error);
            }
        });
    }
}



// Event listeners
document.getElementById('name-btn').addEventListener('click', () => toggleField('name-input', 'name-btn', 'handlers/change_name.php'));
document.getElementById('email-btn').addEventListener('click', () => toggleField('email-input', 'email-btn', 'handlers/change_email.php'));
document.getElementById('password-btn').addEventListener('click', () => toggleField('password-input', 'password-btn', 'handlers/change_password.php'));

document.getElementById('delete-btn').addEventListener('click', () => {
    if (!confirm('Are you sure? This cannot be undone.')) return;

    fetch('handlers/delete_account.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'home_page.php';
        } else {
            alert(data.error);
        }
    });
});