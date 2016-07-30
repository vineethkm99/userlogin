$(document).ready(function(){
    $("#signupform").validate({
        rules: {
            name: "required",
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            },
            cpassword : {
                minlength : 5,
                equalTo : '[name="password"]'
            },
            mobile: {
                required: true,
                minlength: 6
            },
            gender: {
                required: true
            }
        },
        messages: {
            name: "Please enter your name",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            email: "Please enter a valid email address",
            mobile: {
                required: "Please provide a mobile number",
                minlength: "Must be at least 6 characters long"
            },
            gender: "required"
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});