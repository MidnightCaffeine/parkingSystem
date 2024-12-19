<?php
use PHPMailer\PHPMailer\PHPMailer;

$output = array();
date_default_timezone_set('Asia/Manila');
session_start();
include 'connection.php';
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';


function generateOTP($length = 6)
{
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= random_int(0, 9); // Generates a random digit from 0 to 9
    }
    return $otp;
}

function send_email($to, $subs, $to_name, $token)
{
    include 'connection.php';
    $mail = new PHPMailer(true);

    try {
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;

        $mail->Username = "midnightcoffee014@gmail.com";
        $mail->Password = "xwskudpwlcgpajmg";
        $mail->SMTPSecure = 'tls';
        $mail->Port = '587';

        $mail->SetFrom('midnightcoffee014@gmail.com', 'School of Information Technology');
        $mail->AddAddress($to);

        $mail->IsHTML(true);
        $mail->Subject = $subs;

        $mail->Body = '<body data-new-gr-c-s-loaded="14.1141.0" style="width: 100%; font-family: open sans, helvetica neue, helvetica, arial, sans-serif; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; padding: 0; margin: 0;"><div dir="ltr" class="es-wrapper-color" lang="en" style="background-color: #eeeeee"><table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;padding: 0;margin: 0;width: 100%;height: 100%;background-repeat: repeat;background-position: center top;background-color: #eeeeee;"><tr style="border-collapse: collapse"><td valign="top" style="padding: 0; margin: 0"><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;"><tr style="border-collapse: collapse"></tr> <tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table class="es-header-body" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;background-color: #FDA63A;width: 600px;" cellspacing="0" cellpadding="0" bgcolor="#044767" align="center"><tr style="border-collapse: collapse"><td align="left" style="margin: 0;padding-top: 35px;padding-left: 35px;padding-right: 35px;padding-bottom: 40px;"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse">   <td class="es-m-txt-c" align="center" style="padding: 0; margin: 0"><h1 style="margin: 0;line-height: 36px;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;font-size: 36px;font-style: normal;font-weight: bold;color: #ffffff;">Tech Warriors</h1></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;background-color: #ffffff;width: 600px;"><tr style="border-collapse: collapse"><td align="left" style="margin: 0;padding-bottom: 25px;padding-top: 35px;padding-left: 35px;padding-right: 35px;"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0"  style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-bottom: 5px;padding-top: 20px;"><h3 style="margin: 0;line-height: 22px;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;font-size: 18px;font-style: normal;font-weight: bold;color: #333333;">Hello ' . $to_name . ',<br /></h3></td></tr><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-bottom: 10px;padding-top: 15px;">   <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 24px;color: #777777;font-size: 16px;"><i></i>Your One-Time PIN (OTP) is: [' . $token . ']. This PIN is valid for the next 5 minutes and will be required to complete your password reset. Do not share this OTP with anyone. If you did not request this OTP, please contact us immediately.<i></i></p></td></tr><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-top: 5px;"><p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;     line-height: 24px;color: #777777;font-size: 16px;" >We are committed to providing you with the best possible solutions and ensuring that you have a positive experience with our system. Thank you for your continued support, and we look forward to serving you in the future. </p></td> </tr></table></td></tr></table>    </td></tr></table></td></tr></table><table cellpadding="0" cellspacing="0" class="es-footer"align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;background-color: transparent;background-repeat: repeat;      background-position: center top;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table  class="es-footer-body"  cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;    background-color: #ffffff;width: 600px;"><tr style="border-collapse: collapse"><td align="left"style="margin: 0;padding-top: 35px;padding-left: 35px;padding-right: 35px;padding-bottom: 40px;"><table width="100%"cellspacing="0"cellpadding="0"style="  mso-table-lspace: 0pt;  mso-table-rspace: 0pt;  border-collapse: collapse;  border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0;margin: 0;padding-bottom: 15px;font-size: 0;"></td></tr><tr style="border-collapse: collapse"><td align="center" style="padding: 0;margin: 0;padding-bottom: 35px;"> <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 21px;color: #333333;font-size: 14px;   " >   <b>School of Information Technology</b> </p> <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 21px;color: #333333;font-size: 14px;" ><b></b><b></b>ASCOT Parking System<br/></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body>';

        $mail->send();


    } catch (Exception $e) {

        echo $mail->ErrorInfo;
    }
}

if (isset($_POST['forget_email'])) {


    $recipient = $_POST['forget_email'];
    $subject = 'One Time Pin';
    $otp = generateOTP();

    $select = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $select->bindParam(':email', $recipient);
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    $current_timestamp = time();

    if ($select->rowCount() > 0) {

        $firstname = $row['firstname'];
        $user_id = $row['user_id'];
        $_SESSION["user_id"] = $row['user_id'];

        $select_token = $pdo->prepare("SELECT * FROM token WHERE user_id = :user_id");
        $select_token->bindParam(':user_id', $user_id);
        $select_token->execute();
        $token_data = $select_token->fetch(PDO::FETCH_ASSOC);
        if ($select_token->rowCount() > 0) {
            $update = $pdo->prepare("UPDATE token SET token_code = :token_code, created_at = :current_timestamp WHERE user_id = :user_id");

            $update->bindparam('token_code', $otp);
            $update->bindparam('current_timestamp', $current_timestamp);
            $update->bindparam('user_id', $user_id);
            $update->execute();
            send_email($recipient, $subject, $firstname, $otp);
        } else {
            $query = "INSERT INTO token(user_id, token_code) values(:user_id, :token_code)";
            $insert = $pdo->prepare($query);
            $insert->bindParam(':user_id', $user_id);
            $insert->bindParam(':token_code', $otp);
            if ($insert->execute()) {
                send_email($recipient, $subject, $firstname, $otp);
            }

        }

        $output["notif"] = 'email sent';
        echo json_encode($output);

    } else {

        header('Content-Type: application/json');
        http_response_code(400); // Set HTTP status code to 400 (Bad Request)
        echo json_encode([
            'success' => false,
            'error' => 'Error'
        ]);
        exit;

    }
}

if (isset($_POST['otp'])) {
    $otp = $_POST['otp'];

    $select = $pdo->prepare("SELECT * FROM token WHERE token_code = :otp");
    $select->bindParam(':otp', $otp);
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    if ($select->rowCount() > 0) {
        $output["notif"] = 'otp verified';
        echo json_encode($output);
    }
}


if (isset($_POST['change_password'])) {
    $password = $_POST['change_password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $update = $pdo->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");

    $update->bindparam(':password', $hashedPassword);
    $update->bindparam(':user_id', $_SESSION["user_id"]);
    $update->execute();

    $output["notif"] = 'pass changed';
    echo json_encode($output);

}


