document.addEventListener('DOMContentLoaded', () => {
    const signupForm = document.getElementById('signupForm');

    signupForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const fullName = document.getElementById('fullname').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Here you would normally send the data to the server.
        // For example, you could use the Fetch API to send it asynchronously.
        // After the server responds, handle the successful signup:
        // For demonstration, we're simulating successful signup by logging to the console and redirecting.
        console.log('Full Name:', fullName);
        console.log('Email:', email);
        console.log('Password:', password);

        // Simulate an API call with a timeout
        setTimeout(() => {
            // Replace the URL below with the actual path to your login page
            window.location.href = 'login.html';
        }, 1000); // Redirect after 1 second for demonstration
    });
});
