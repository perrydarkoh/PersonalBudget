document.addEventListener('DOMContentLoaded', () => {
    const signupForm = document.getElementById('signupForm');

    signupForm.addEventListener('submit', function(event) {
        event.preventDefault(); 

        const fullName = document.getElementById('fullname').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        
        console.log('Full Name:', fullName);
        console.log('Email:', email);
        console.log('Password:', password);

        setTimeout(() => {
            window.location.href = 'login.php';
        }, 1000); 
    });
});
