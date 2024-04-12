function validateEmail() {
    var email = document.getElementById('email').value;
    var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email pattern check

    if (pattern.test(email)) {
        // Normally, you would submit the form or redirect the user here.
        console.log('Email is valid!');
        alert('Thank you for signing up!');
    } else {
        alert('Please enter a valid email address.');
    }
}
