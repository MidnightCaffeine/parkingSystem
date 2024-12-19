$(document).ready(function () {
      $('#sending').hide();
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
    var vehicle_type = $("#vehicle_type").val();
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
      vehicle_type,
    });
  });

  $("#login_form").submit(function (event) {
    event.preventDefault();

    var email = $("#email").val();
    var password = $("#password").val();
    var login = $("#login_button").val();

    $(".login-message").load(
      "lib/php/authentication/login.php",
      {
        email,
        password,
        login
      }
    );
  });


  $("#forgot_pass").submit(function (event) {
    event.preventDefault();

    var forget_email = $("#forget_email").val();
    $('#send_otp').hide();
    $('#sending').show();
    $('#sending').text("Sending OTP please wait");

    $.ajax({
      url: "lib/php/database_handler/forgot_password.php",
      method: "POST",
      data: {
        forget_email,
      },
      dataType: "json",
      success: function (data) {
        $("#forgot_password").modal("hide");
        $("#verify").modal("show");
      },
      error: function (xhr, status, error) {
        $('#send_otp').show();
        // This runs if the server responds with an HTTP error (e.g., 400, 500)
        Swal.fire({
          title: "This email is not associated to an account!",
          text: "Enter a registered email!",
          icon: "error",
          timer: 2000,
          timerProgressBar: true,
          showConfirmButton: false,
        });
      }
    });
  });


  $("#otpForm").submit(function (event) {
    event.preventDefault();

    var otp1 = $("#otp1").val();
    var otp2 = $("#otp2").val();
    var otp3 = $("#otp3").val();
    var otp4 = $("#otp4").val();
    var otp5 = $("#otp5").val();
    var otp6 = $("#otp6").val();

    var otp = otp1 + otp2 + otp3 + otp4 + otp5 + otp6;

    $.ajax({
      url: "lib/php/database_handler/forgot_password.php",
      method: "POST",
      data: {
        otp,
      },
      dataType: "json",
      success: function (data) {
        $("#verify").modal("hide");
        $("#password_change").modal("show");
      },
      error: function (xhr, status, error) {
        $('#send_otp').show();
        // This runs if the server responds with an HTTP error (e.g., 400, 500)
        Swal.fire({
          title: "One Time Pin Incorrect!",
          text: "One Time Pin Either Incorrect or Expired!",
          icon: "error",
          timer: 2000,
          timerProgressBar: true,
          showConfirmButton: false,
        });
      }
    });
  });


  $("#change_pass").submit(function (event) {
    event.preventDefault();

    var change_password = $("#change_password").val();
    var confirm_change = $("#confirm_change").val();

    if(change_password == confirm_change){
      $.ajax({
        url: "lib/php/database_handler/forgot_password.php",
        method: "POST",
        data: {
          change_password,
        },
        dataType: "json",
        success: function (data) {
          $("#password_change").modal("hide");
          Swal.fire({
            icon: "success",
            title: "Password Change Successful!",
            text: "You can now login to your account using the new password"
          });
        },
      });
    }else{
      Swal.fire({
        icon: "error",
        title: "Passwords do not match!",
        text: "Please re-enter your password",
      });
    }

    
  });

});
