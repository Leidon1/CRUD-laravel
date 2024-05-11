document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.getElementById('name');
    const lastNameInput = document.getElementById('last_name');
    const usernameInput = document.getElementById('username');
    const generatedUsernameInfo = document.getElementById('generated-username');

    // Generate and display the username initially
    generateUsername();

    // Event listeners for input fields
    nameInput.addEventListener('blur', generateUsername);
    lastNameInput.addEventListener('blur', generateUsername);
    usernameInput.addEventListener('blur', validateUsername);

    // Function to generate the username based on name and last name
    function generateUsername() {
        const name = nameInput.value.trim();
        const lastName = lastNameInput.value.trim();

        if (name.length > 0 && lastName.length > 0) {
            fetch('/generate-username', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({name: name, last_name: lastName}) // Pass name and last name in the request body
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        // Handle error response from the server
                        console.error('Error:', data.error);
                    } else {
                        // Update the username input field with the fetched username
                        usernameInput.value = data.username;
                        generatedUsernameInfo.innerText = "Suggested username: " + data.username;
                    }
                })
                .catch(error => {
                    // Handle fetch error
                    console.error('Fetch error:', error);
                });
        } else {
            usernameInput.value = "";
            generatedUsernameInfo.innerText = "";
        }
    }


    // Function to validate the username
    function validateUsername() {
        const username = usernameInput.value.trim();
        const name = nameInput.value.trim();
        const lastName = lastNameInput.value.trim();

        if (username.length > 0 && name.length > 0 && lastName.length > 0) {
            fetch('/check-username', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({name: name, last_name: lastName, username: username})
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        generatedUsernameInfo.innerText = data.error;
                    } else {
                        generatedUsernameInfo.innerText = username + " is available";
                    }
                })
                .catch(error => {
                    generatedUsernameInfo.innerText = "An error occurred while checking the username.";
                    console.error('Error:', error);
                });
        } else {
            generatedUsernameInfo.innerText = "";
        }
    }
});
