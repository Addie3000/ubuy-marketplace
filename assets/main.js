//register page password toggle
const togglePassword = document.getElementById('togglePassword');
if (togglePassword) {
    togglePassword.addEventListener('click', function(){
        const pwd= document.getElementById('password');
        pwd.type = pwd.type === 'password'? 'text': 'password';
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');});

}
const toggleConfirm =document.getElementById('toggleConfirm');
if (toggleConfirm) {
    toggleConfirm.addEventListener('click', function() {
        const pwd = document.getElementById('confirmPassword');
        pwd.type = pwd.type === 'password' ? 'text' : 'password';
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');});
}

//Form validation//
const registerForm =document.getElementById('registerForm');
if (registerForm) {
    registerForm.addEventListener('submit',function(e){
        const phone = document.querySelector('input[name="phone"]').value.trim();
        const password= document.getElementById('password').value;
        const confirm = document.getElementById('confirmPassword').value;
        const errorBox = document.getElementById('formError');

    errorBox.textContent='';
    
    // Phone number validation
    const phoneRegex = /^[0-9]{10}$/;
    if (!phoneRegex.test(phone)){
        e.preventDefault();
        errorBox.textContent = 'The phone number must be 10 digits with no spaces';
        return;

    }
    //password length validation
    if(password.length < 8 || password.length > 16){
        e.preventDefault();
        errorBox.textContent = 'Password must be atleast 8-16 characters.';
        return;
    }
    //password match validation
    if (password !== confirm) {
        e.preventDefault();
        errorBox.textContent = 'Passwords do not match. Please try again.';
        return;}
    });
}

//Login password toggle
const loginToggle = document.getElementById('toggleLoginPassword');
if (loginToggle) {
    loginToggle.addEventListener('click', function() {
        const pwd = document.getElementById('loginPassword');
        pwd.type = pwd.type === 'password' ? 'text' : 'password';
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
}




