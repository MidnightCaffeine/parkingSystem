$(document).ready(function () {
  $("#registration_form").submit(function (event) {
    event.preventDefault();

    var register_firstname = $("#register_firstname").val();
    var register_lastname = $("#register_lastname").val();
    var register_middlename = $("#register_middlename").val();
    var register_email = $("#register_email").val();
    var department = $("#department").val();
    var year_group = $("#year_group").val();
    var section = $("#section").val();
    var mv_file = $("#mv_file").val();
    var body_number = $("#body_number").val();
    var register_password = $("#register_password").val();
    var confirm_password = $("#confirm_password").val();
    var signUp = $("#signUp").val();

    if (register_password !== confirm_password) {
      Swal.fire({
        icon: "error",
        title: "Passwords do not match!",
        text: "Please re-enter your password",
      });
    }

    $(".form-message").load("lib/php/authentication/register.php", {
      register_firstname,
      register_lastname,
      register_middlename,
      register_email,
      department,
      year_group,
      section,
      mv_file,
      body_number,
      register_password,
      signUp,
    });
  });

  $("#login_form").submit(function (event) {
    event.preventDefault();

    var email = $("#email").val();
    var password = $("#password").val();
    var login = $("#login_button").val();

    $(".form-message").load(
      "lib/php/authentication/login.php",
      {
        email,
        password,
        login
      }
    );
  });
});
