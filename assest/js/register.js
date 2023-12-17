function registerUser() {
    var formData = {
        name: $('#name').val(),
        email: $('#email').val(),
        password: $('#password').val(),
        role: $('#role').val(),
        address: $('#address').val(),
        mobile: $('#mobile').val(),
    };

    $.ajax({
        type: 'POST',
        url: 'register.php',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        success: function(response) {
            alert(response.message);
            if (response.success) {
                // Redirect or perform any other action after successful registration
            }
        },
        error: function(error) {
            console.log(error);
        }
    });

    RegForm.style.transform = "translatex(300px)";
    LoginForm.style.transform = "translatex(300px)";
    Indicator.style.transform = "translate(0px)";
}
