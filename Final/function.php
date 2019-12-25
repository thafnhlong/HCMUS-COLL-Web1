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

/* send email thông báo gửi lời mời kết bạn */
function sendEmailAddFr($name,$email,$text,$id)
{
    global $BASE_URL;
    sendEmail($email,$name,'Thông báo bạn có lời mời kết bạn',"<a href=\"$BASE_URL/profile.php?id=$id\">$text </a> đã gửi cho bạn lời mời kết bạn");
    //sendEmail($email,$name,'Thông báo bạn có lời mời kết bạn'," đã gửi cho bạn lời mời kết bạn !!");
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
function userPost($user,$content,$pri)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT post(Content,UserID,Privacy) values (?,?,?)");
    $stmt->execute(array($content,$user['ID'],$pri));
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
function friendPost($page,$id)
{
    global $pdo;
    global $numPostOfPage;
    $stmt = $pdo->prepare(@"
        select distinct p.Privacy,p.Content,p.Time,p.ID,u.Name,u1.ID uid,u1.Name 
        from friendship f1, friendship f2, post p join user u1 on u1.id = p.userid, user u 
        where u.id = ? and ( (p.userid=u.id) or ( exists(select * from follow where id=u.id and target=p.userid) and ( p.privacy = 2 or (f1.id = f2.target and f2.id = f1.target and u.id = f1.id and p.userid = f2.id and p.privacy = 1) )))
        order by p.Time desc limit ?, ?
    ");
    $stmt->bindValue(1, $id, PDO::PARAM_INT);                         
    $stmt->bindValue(2, $numPostOfPage*($page-1), PDO::PARAM_INT);
    $stmt->bindValue(3, $numPostOfPage, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function friendCountPost($id)
{
    global $pdo;
    $stmt = $pdo->prepare(@"
        select count(distinct (p.id)) num 
        from friendship f1, friendship f2, post p join user u1 on u1.id = p.userid, user u 
        where u.id = ? and ( (p.userid=u.id) or ( exists(select * from follow where id=u.id and target=p.userid) and ( p.privacy = 2 or (f1.id = f2.target and f2.id = f1.target and u.id = f1.id and p.userid = f2.id and p.privacy = 1) )))
    ");
    $stmt->execute(array($id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
/* cập nhật lại trạng thái bài đăng */
function updatePrivacy($postid,$privacy,$uid)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE post SET Privacy=? WHERE ID=? and userid= ?");
    $stmt->execute(array($privacy,$postid,$uid));
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

/* Message */
function loadLastMessage($id){
    global $pdo;
    $stmt = $pdo->prepare(@"
select data.id,u.name,data.content,DATE_FORMAT(data.createAt,'%e-%c %h:%i %p') createAt
from (select case when m.fromid=? then m.toid else m.fromid end id, concat(substring(m.content,1,25) ,' ','...') content, m.createAt from message m where id = (select max(id) from message where (fromid = m.toid and toid = m.fromid) or (fromid = m.fromid and toid = m.toid))
and (m.toid = ? or m.fromid = ?) ) data join user u on data.id = u.id
order by createAt desc
    "
    );
    $stmt->execute(array($id,$id,$id));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function loadMessageToID($id,$toid,$maxid){
    global $pdo;
    $stmt = $pdo->prepare("select m.* from message m where m.id > ? and  ((fromid = ? and toid = ?) or (fromid = ? and toid = ? and m.status=true))");
    $stmt->execute(array($maxid,$id,$toid,$toid,$id));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function sendMessageToID($id,$toid,$content){
    global $pdo;
    $stmt = $pdo->prepare("select u1.email,u2.name from user u1,user u2 where u2.id=? and u1.id=?;insert message(fromid,toid,content) values (?,?,?)");
    $stmt->execute(array($id,$toid,$id,$toid,$content));//,$toid,$id));
    
    if ($info = $stmt->fetch(PDO::FETCH_ASSOC)){
        global $BASE_URL;
        sendEmail($info['email'],$info['email'],"Có tin nhắn từ {$info['name']}","{$content}\n\n<br/><br/>Để nhắn tin lại vui lòng nhấp vào <a href='{$BASE_URL}/message.php?toid={$id}'> đường link này </a>");
    }
}
function hideMessageToID($id,$toid,$mesid){
    global $pdo;
    $stmt = $pdo->prepare("update message set status=false where fromid = ? and toid = ? and id = ?");
    $stmt->execute(array($id,$toid,$mesid));
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

/* thêm dữ liệu vào bảng follow */
function sendfollowing($id,$target)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT follow(ID,Target) values (?,?)");
    $stmt->execute(array($id,$target) );
    return $pdo->lastInsertId();
}

/* xóa dữ liệu trong bảng follow */
function deletefollow($id,$target)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM follow WHERE ID=? and Target=?");
    $stmt->execute(array($id,$target) );
}
/* xác định đã theo dõi chưa */
function isfollow($id,$target)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM follow WHERE ID=? and Target=?");
    $stmt->execute(array($id,$target) );
    return $stmt->fetch(PDO::FETCH_ASSOC) != null;
}
/* đếm số lượng người mình đang theo dõi */
function countFollowing($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT Count(*) num FROM follow WHERE ID=?");
    $stmt->execute(array($id));
    $num=$stmt->fetch(PDO::FETCH_ASSOC);
    if ($num == null)
        return 0;
    return $num['num'];
}

/* đếm số lượng người  đang theo dõi mình */
function countFollower($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT Count(*) num FROM follow WHERE Target=?");
    $stmt->execute(array($id));
    $num=$stmt->fetch(PDO::FETCH_ASSOC);
    if ($num == null)
        return 0;
    return $num['num'];
}