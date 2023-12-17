function loginUser() {
    var formData = {
        email: $('#email').val(),
        password: $('#password').val(),
    };

    $.ajax({
        type: 'POST',
        url: 'login.php',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        success: function(response) {
            if (response.success) {
                // Redirect or perform any other action after successful login
                window.location.href = 'dashboard.html';
            } else {
                $('#error-message').text(response.message);
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}
