function submitForm() {
    if (validateForm()) {
        const formData = new FormData(document.getElementById('userForm'));
        const userData = {};
        formData.forEach((value, key) => {
            userData[key] = value;
        });
        document.getElementById('submitMessage').innerText = "Submit button clicked...";
        postData(userData);
    }
}

function validateForm() {
    const firstName = document.getElementById('firstName').value.trim();
    const lastName = document.getElementById('lastName').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const city = document.getElementById('city').value.trim();

    const phoneRegex = /^[0-9]{10}$/;
    if (!phone.match(phoneRegex)) {
        alert("Please enter a valid phone number in the format: [0-9] 10 Numbers");
        return false;
    }

    return true;
}

async function postData(data) {
    try {
        const response = await fetch('backend.php', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        });
        
        // Check HTTP status code
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        
        const result = await response.json();
        if (result.success) {
            document.getElementById('submitMessage').innerText = "Data submitted successfully!";
            document.getElementById('userForm').reset();
        } else {
            document.getElementById('submitMessage').innerText = "An error occurred while submitting the data.";
        }
    } catch (error) {
        console.error('Error:', error.message);
        document.getElementById('submitMessage').innerText = "An error occurred while communicating with the server.";
    }
}

