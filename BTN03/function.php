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
function createUser($displayName, $email, $password,$phonenumber,$address) {
    global $pdo;
    global $BASE_URL;
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $code = generateRandomString(16);
    $stmt = $pdo->prepare("INSERT INTO user (Name, Email, Pass, Status, Code, CodeForgot, PhoneNumber, Address ) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->execute(array($displayName, $email, $hashPassword, 0, $code,0,$phonenumber,$address));
    $id = $pdo->lastInsertId();
    sendEmail($email, $displayName, 'Kích hoạt tài khoản', "Mã kích hoạt tài khoản của bạn là  <a href=\"$BASE_URL/activate.php?code=$code\">$BASE_URL/activate.php?code=$code</a>");
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
function userPost($user,$content)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT post(Content,UserID) values (?,?)");
    $stmt->execute(array($content,$user['ID']) );
    return $pdo->lastInsertId();
}
function loadPost($page)
{
    global $pdo;
    global $numPostOfPage;
    $stmt = $pdo->prepare("SELECT p.Content,p.Time,p.ID,u.Name,u.ID uid FROM post p JOIN user u ON u.ID=p.UserID ORDER BY p.Time DESC LIMIT ?, ?");
    $stmt->bindValue(1, $numPostOfPage*($page-1), PDO::PARAM_INT);
    $stmt->bindValue(2, $numPostOfPage, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getCountPost()
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) num FROM post");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function countLike($post)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) SoLuong FROM `like` WHERE PostID = ?");
    $stmt->execute(array($post));
    return $stmt->fetch(PDO::FETCH_ASSOC)['SoLuong'];
}
function isLike($id,$post)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM `like` WHERE UserID = ? and PostID = ?");
    $stmt->execute(array($id,$post));
    return $stmt->fetch(PDO::FETCH_ASSOC) != null;
}
function likePost($id,$post)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT `like`(UserID,PostID) VALUES(?,?)");
    $stmt->execute(array($id,$post));
}
function unlikePost($id,$post)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM `like` WHERE UserID = ? and PostID = ?");
    $stmt->execute(array($id,$post));
}

function loadComment($post)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT c.*,u.Name,u.id uid FROM `comment` c JOIN `user` u ON c.UserID=u.ID WHERE c.PostID = ?");
    $stmt->execute(array($post));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function countComment($post)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) SoLuong FROM `comment` WHERE PostID = ?");
    $stmt->execute(array($post));
    return $stmt->fetch(PDO::FETCH_ASSOC)['SoLuong'];
}
function postComment($id,$post,$content)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT `comment`(UserID,PostID,Content) VALUES(?,?,?)");
    $stmt->execute(array($id,$post,$content));
}

/*Frendship*/
function sendRequest($id,$target)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT friendship(id,target) values (?,?)");
    $stmt->execute(array($id,$target) );
    return $pdo->lastInsertId();
}
function deleteRequest($id,$target)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM friendship WHERE id=? and target=?");
    $stmt->execute(array($id,$target) );
}
function isRequest($id,$target)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM friendship WHERE id=? and target=?");
    $stmt->execute(array($id,$target) );
    return $stmt->fetch(PDO::FETCH_ASSOC) != null;
}
function getFriends($id)
{
    global $pdo;
    $stmt = $pdo->prepare("select u.* from friendship f1, friendship f2 JOIN user u ON u.id = f2.id where f1.id = f2.target and f1.target = f2.id and f1.id = ?");
    $stmt->execute(array($id) );
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
function getImage($id,$type=2)
{
    $src = "./images/";
    $alternative = "";
    switch($type)
    {
        case 0: // avatar
            $src .= "avatar/";
            break;
        case 1: //cover
            $src .= "cover/";
            break;
        default: //image
            $src .= "post/";
            break;
    }
    $srcreal = $src. $id .'.jpg';
    if (file_exists($srcreal))
        return [true,$srcreal];
    return [false,$src .'0.jpg'];
}

/* cập nhật họ tên số điện thoại */
function updateProfile($name,$phone,$id)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE user SET Name= ?,PhoneNumber=? where ID=?");
    return $stmt->execute(array($name,$phone,$id));
}

/* kiểm tra xem email đã tồn tại chưa */
function checkEmail($Email)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM user WHERE Email=?");
    $stmt->execute(array($Email));
    $tmp=$stmt->fetch(PDO::FETCH_ASSOC);
    if($tmp!=null)
    {
        return true;
    }
    else
    {
        return false;
    }
}

/* gửi email để kích hoạt lại mật khẩu */
function SendMailFogetPasss($name,$email)
    {
        global $pdo,$BASE_URL;
        $code=generateRandomString(16);
        $stmt = $pdo->prepare("UPDATE user SET CodeForgot=? where Email=?");
        $stmt->execute(array($code,$email));
        $pdo->lastInsertId();
        sendEmail($email,$name,'Thiết lập lại mật khẩu',"Mã kích hoạt tài khoản của bạn là <a href=\"$BASE_URL/checkCodeForgot.php?code=$code\">$BASE_URL/checkCodeForgot.php?code=$code</a>");
    }

/* câp nhật mật khẩu mới qua email */
function UpdatePass($email,$pass)
    {
        global $pdo;
        $haspass=password_hash($pass,PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE user SET Pass=? where Email=?");
        $stmt->execute(array($haspass,$email));
        $pdo->lastInsertId();
    }

/* Đổi mật khẩu */
function ChangePass($pass,$id)
    {
        global $pdo;
        $haspass=password_hash($pass,PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE user SET Pass=? where ID=?");
        return $stmt->execute(array($haspass,$id));
    }

/* Lấy các contetn đã đăng trên trang cá nhân */
function GetStatusByUserID($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM post where UserID=?  ORDER BY Time DESC");
    $stmt->execute(array($id));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* update mô tả bản thân */
function updateAboutMe($temp,$id)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE user SET AboutMe=? where ID=?");
    $stmt->execute(array($temp,$id));
    $pdo->lastInsertId();
}

/* update số điện thoại */
function updatePhoneNumber($temp,$id)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE user SET PhoneNumber=? where ID=?");
    $stmt->execute(array($temp,$id));
    $pdo->lastInsertId();
}
/* update email  */
function updateEmail($temp,$id)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE user SET Email=? where ID=?");
    $stmt->execute(array($temp,$id));
    $pdo->lastInsertId();
}

/* update facebook */
function updateFaceBook($temp,$id)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE user SET FaceBook=? where ID=?");
    $stmt->execute(array($temp,$id));
    $pdo->lastInsertId();
}

/* update địa chỉ */
function updateAddress($temp,$id)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE user SET Address=? where ID=?");
    $stmt->execute(array($temp,$id));
    $pdo->lastInsertId();
}

/* cập nhật công việc */
function updateJob($temp,$id)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE user SET Job=? where ID=?");
    $stmt->execute(array($temp,$id));
    $pdo->lastInsertId();
}

/* cập nhật tên */
function updateName($temp,$id)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE user SET Name=? where ID=?");
    $stmt->execute(array($temp,$id));
    $pdo->lastInsertId();
}

/* cập nhật mật khẩu mới */
function updatePassByAccount($pass,$id)
{
    global $pdo;
    $haspass=password_hash($pass,PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE user SET Pass=? where ID=?");
    return $stmt->execute(array($haspass,$id));
}

/* lấy danh sách đã gửi lời mời kết bạn */
function getlistsendaddFriend($target)
{
    global $pdo;
    $stmt = $pdo->prepare("
    select u.* from friendship f1 join user u on f1.id = u.id
    where f1.target = ? 
    and not exists ( select * from friendship f2 where f2.id = f1.target and f2.target = f1.id)
    ");
    $stmt->execute(array($target));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
/* lấy list user */
function getUsers($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM user WHERE ID!=?");
    $stmt->execute(array($id));
    return $stmt;
}
