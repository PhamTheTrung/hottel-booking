function editUser(id, fullname, email, phone, address) {
    document.getElementById('user_id').value = id;
    document.getElementById('fullname').value = fullname;
    document.getElementById('email').value = email;
    document.getElementById('phone').value = phone;
    document.getElementById('address').value = address;

    const pw = document.getElementById('password');
    pw.value = '';
    pw.removeAttribute('required');
}
