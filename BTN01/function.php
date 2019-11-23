<?php
require_once("config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
    
/*pdo*/
$pdo = new PDO($DB_TYPE.'='.$DB_HOST.';'.$DB_NAME_TYPE.'='.$DB_NAME.$DB_OPTIONAL,$DB_USER,$DB_PASSWORD);
/* tim user = email */
function findUserByEmail($email) {
  global $pdo;
  $stmt = $pdo->prepare("SELECT * FROM user WHERE Email = ?");
  $stmt->execute(array($email));
  return $stmt->fetch(PDO::FETCH_ASSOC);
}
/* tim ID */

function findUserById($id) {
  global $pdo;
  $stmt = $pdo->prepare("SELECT * FROM user WHERE ID = ?");
  $stmt->execute(array($id));
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

/* tao moi user */
function createUser($displayName, $email, $password) {
    global $pdo;
    global $BASE_URL;
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $code = generateRandomString(16);
    $stmt = $pdo->prepare("INSERT INTO user (Name, Email, Pass, Status, Code, CodeForgot, Image, PhoneNumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array($displayName, $email, $hashPassword, 0, $code,0,0,0));
    $id = $pdo->lastInsertId();
    sendEmail($email, $displayName, 'Kích hoạt tài khoản', "Mã kích hoạt tài khoản của bạn là <a href=\"$BASE_URL/activate.php?code=$code\">$BASE_URL/activate.php?code=$code</a>");
    return $id;
}
/* active user*/
function activateUser($code) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM user WHERE Code = ? AND Status = ?");
    $stmt->execute(array($code, 0));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && $user['Code'] == $code) {
      $stmt = $pdo->prepare("UPDATE user SET Code = ?, Status = ? WHERE ID = ?");
      $stmt->execute(array('', 1, $user['ID']));
      return true;
    }
    return false;
}
/* Send mail */
function sendEmail($to, $name, $subject, $content) {
    global $EMAIL_FROM, $EMAIL_NAME, $EMAIL_PASSWORD;
  
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
  
    //Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->CharSet    = 'UTF-8';
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $EMAIL_FROM;                     // SMTP username
    $mail->Password   = $EMAIL_PASSWORD;                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to
  
    //Recipients
    $mail->setFrom($EMAIL_FROM, $EMAIL_NAME);
    $mail->addAddress($to, $name);     // Add a recipient
  
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $content;
    // $mail->AltBody = $content;
  
    $mail->send();
}

/* tạo chuỗi ngẫu nhiên */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/*Newfeed*/
function userPost($user,$content,$image)
{
    global $pdo;   
    $stmt = $pdo->prepare("INSERT post(Content,UserID,IMGContent) values (?,?,?)");
    $stmt->execute(array($content,$user['ID'], $image) );
    return $pdo->lastInsertId();
}
function loadPost()
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT p.Content,p.Time,p.ID,u.Name,u.ID uid FROM post p JOIN user u ON u.ID=p.UserID ORDER BY p.Time DESC ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*util*/
function checkImageType($type)
{
    $allowed = array("image/jpeg", "image/gif", "image/png");
    if(!in_array($type, $allowed))
        return false;
    return true;
}
function getImagePost($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT IMGContent FROM post WHERE ID=?");
    $stmt->execute(array($id));
    $image = $stmt->fetch(PDO::FETCH_ASSOC);
    return $image['IMGContent'];
}
function getImageUser($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT Image FROM user WHERE ID=?");
    $stmt->execute(array($id));
    $image = $stmt->fetch(PDO::FETCH_ASSOC);
    return $image['Image'];
}