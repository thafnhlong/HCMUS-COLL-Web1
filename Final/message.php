<?php 
require_once("init.php");
require_once("function.php");

if(!$currentUser)
{
    header('Location: login.php');
    die();
}

function ContentBoxChat($data)
{
    global $currentUser;
    
    if (count($data) > 0){
            
        $item =$data[0];   
        $srcarray[$item['fromid']] = getImage($item['fromid'],0)[1];
        $srcarray[$item['toid']] = getImage($item['toid'],0)[1];
                
        foreach($data as $item)
        {
            $l = $trash = '';
            $st = 'st3';
            if ($item['fromid'] != $currentUser['ID']){
                $l = "ta-right";
                $trash = '<i onclick="removeMess(this)" style="" class="fa fa-trash" aria-hidden="true"></i>';
                $st='';
            }
            echo <<<HTML
                                    <div data-current-id="${item['id']}" class="main-message-box $l">
                                        <div class="message-dt $st">
                                            <div class="message-inner-dt">
                                                <p>${item['content']}</p>    
                                                $trash
                                            </div><!--message-inner-dt end-->
                                            <span>${item['createAt']}</span>
                                        </div><!--message-dt end-->
                                        <div class="messg-usr-img">
                                            <img width="50px;" height="50px;" src="{$srcarray[$item['fromid']]}" alt="">
                                        </div><!--messg-usr-img end-->
                                    </div><!--main-message-box end-->
                                    
HTML;
        }
    }
    die();
}

if (!empty($_GET['op']))
{
    switch($_GET['op']){
        case "load":
            ContentBoxChat(loadMessageToID($currentUser['ID'],$_POST['id'],$_POST['maxid']));
            break;
        case "send":
            sendMessageToID($currentUser['ID'],$_POST['id'],$_POST['content']);
            die;
            break;
        case "hide":
            hideMessageToID($_POST['id'],$currentUser['ID'],$_POST['mesid']);
            die;
            break;
    }
}

include 'header.php'; 

//sendMessageToID($currentUser['ID'],9,"hello");

$shortMessage = loadLastMessage($currentUser['ID']);

//var_dump(loadMessageToID($currentUser['ID'],9));
?>
        <section class="messages-page">
			<div class="container">
				<div class="messages-sec">
					<div class="row">
						<div class="col-lg-4 col-md-12 no-pdd">
							<div class="msgs-list">
								<div class="msg-title">
									<h3>Messages</h3>
									<ul>
										<li><a href="#" title=""><i class="fa fa-cog"></i></a></li>
										<li><a href="#" title=""><i class="fa fa-ellipsis-v"></i></a></li>
									</ul>
								</div><!--msg-title end-->
								<div class="messages-list" style="height:634px;">
									<ul>
<?php

if(!empty($_GET['toid']))
{
    $toid = $_GET['toid'];
    $uid = findUserById($toid);
    
    $isFound = false;
    for($i=0;$i< count($shortMessage);$i++)
    {
        if ($shortMessage[$i]['id'] == $uid['ID']) {
            
            $temp = $shortMessage[0];
            $shortMessage[0] = $shortMessage[$i];
            $shortMessage[$i] = $temp;
            
            $isFound = true;
            break;
        }
    }
    
    if (!$isFound && $uid != null)
    {
        $datatoid['id']=$uid['ID'];
        $datatoid['name']=$uid['Name'];
        $datatoid['content']="Hãy gửi gì đó...";
        $datatoid['createAt']="Now";
        
        $toidarr = array( $datatoid );
        array_splice( $shortMessage, 0, 0, $toidarr );
    }
}

foreach($shortMessage as $meslist):
?>                                    
										<li data-id="<?=$meslist['id']?>">
											<div class="usr-msg-details">
												<div class="usr-ms-img">
													<img width="50px;" height="50px;" src="<?=getImage($meslist['id'],0)[1]?>" alt="">
													<!--<span class="msg-status"></span>-->
												</div>
												<div class="usr-mg-info">
                                                    <h3><a href="profile.php?id=<?=$meslist['id']?>"><?=$meslist['name']?></a></h3>
													<p><?=$meslist['content']?></p>
												</div><!--usr-mg-info end-->
												<span class="posted_time"><?=$meslist['createAt']?></span>
											</div><!--usr-msg-details end-->
										</li>
<?php endforeach;?>
                                    </ul>
								</div><!--messages-list end-->
							</div><!--msgs-list end-->
						</div>
						<div class="col-lg-8 col-md-12 pd-right-none pd-left-none">
							<div class="main-conversation-box">
								<div class="message-bar-head">
									<div class="usr-msg-details">
										<div class="usr-ms-img">
											<img width="50px;" height="50px;" src="" alt="">
										</div>
										<div class="usr-mg-info">
											<h3></h3>
											<p>Online</p>
										</div><!--usr-mg-info end-->
									</div>
									<a href="#" title=""><i class="fa fa-ellipsis-v"></i></a>
								</div><!--message-bar-head end-->
								<div class="messages-line">
                                    
                                </div><!--messages-line end-->
								<div class="message-send-area">
									<form onsubmit="return sendMess()">
										<div class="mf-field">
											<input type="text" name="message" placeholder="Type a message here">
											<button type="submit">Send</button>
										</div>
										<ul>
											<li><a style="visibility: hidden;" href="#" title=""><i class="fa fa-smile-o"></i></a></li>
										</ul>
									</form>
								</div><!--message-send-area end-->
							</div><!--main-conversation-box end-->
						</div>
					</div>
				</div><!--messages-sec end-->
			</div>
		</section><!--messages-page end-->
        
        <div class="se-pre-con"></div>
        
        <script>
            keylock = false
            
            
            currentChatId = null
            old = null
            
            function sendMess(){
                
                $('button[type="submit"]').prop('disabled',true);
                
                var cont = $('input[name=message]').val()
                if (cont != ""){
                    $.post( "message.php?op=send", { id: currentChatId ,content: cont } )
                        .done(function( data ) {
                            $('input[name=message]').val("")
                            $('button[type="submit"]').prop('disabled',false);
                        }
                    )
                }
                return false
            }
            
            function chatto()
            {
                if (old == this) return;
                
                $(".messages-line").mCustomScrollbar("destroy")
                
                var contentbody = $(".messages-line")[0];
                contentbody.style.backgroundImage = "url(images/loading.gif)"
                contentbody.innerHTML = ""
                
                if (old!=null)
                    old.classList.remove('active')
                old = this
                old.classList.add('active')
                
                currentChatId = $(old).data('id')
                
                $(".message-bar-head >> .usr-ms-img img")[0].src = 
                    $(this).find('img')[0].src
                    
                $(".message-bar-head >> .usr-mg-info h3")[0].innerHTML = 
                    $(this).find("h3 a")[0].innerHTML
                    
                LoadContent()
            }
            
            
            function LoadContent(id=-1)
            {
                console.log(id)
                keylock = false
                $.post( "message.php?op=load", { id: currentChatId ,maxid: id } )
                    .done(function( data ) {
                        var contentbody = $(".messages-line")[0]
                        if( id == -1 ){
                            contentbody.innerHTML = '<div data-current-id="0" style="height: 120px;"></div>' + data;
                            contentbody.style.backgroundImage = null
                            $(".messages-line").mCustomScrollbar({axis:"yx",theme:"dark"})    
                        }else{
                            $('.messages-line .mCSB_container').append(data)
                        }
                        
                        if (data != ""){
                            setTimeout(function(){$(".messages-line").mCustomScrollbar("scrollTo","last")},200)  
                        }
                        
                        keylock = true
                    }
                )
            }
            
            
            function removeMess(e)
            {
                var pbox = $(e).parent().parent().parent()
                dataid = pbox.data('current-id')
                
                $.post( "message.php?op=hide", { id: currentChatId ,mesid: dataid } )
                    .done(function( data ) {
                        pbox.html("")
                    }
                )
            }
            
            $( document ).ready(function() {
                $(".messages-list, .messages-line").mCustomScrollbar({
                  axis:"yx",
                  theme:"dark"
                });
                if ($('.messages-list li').length > 0)
                {
                    $('.messages-list li').bind("click",chatto)
                    setTimeout(function(){
                        $('.messages-list li')[0].click()
                    },150)
                }
                setTimeout(function(){
                    setInterval(function(){
                        if (keylock)
                        {
                            maxid = $('.messages-line .mCSB_container').children().last().data('current-id')
                            if (maxid > -1)
                                LoadContent(maxid)
                        }
                    },1000)                
                },500);
            });
            
        </script>
<?php 
include 'footer.php'; 