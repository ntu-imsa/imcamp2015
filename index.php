<?php
session_start();
require 'includes/config.php';
require 'includes/rb.php';
require 'vendor/autoload.php';
use Mailgun\Mailgun;

R::setup( 'mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS );

$app = new \Slim\Slim(
  array('templates.path' => './views')
);

$app->hook('slim.before.dispatch', function () use ($app) {
//  echo $app->request()->getPathInfo();
	$app->render('header.php', array("nav" => "public"));
});

$app->hook('slim.after.dispatch', function () use ($app) {
	$app->render('footer.php');
});

$app->get('/', function() use($app) {
  $app->render('index.php');
});

$app->post('/contact', function() use($app) {
  require 'includes/akismet.fuspam.php';
  $required_parameters = array("name", "email", "subject", "message");
  $error = array();
  foreach($required_parameters as $para){
    if(!isset($_POST[$para]) || $_POST[$para] == ''){
      $error['title'] = "QAQ";
      $error['message'] = "表單填寫不完整";
    }
  }
  $refer_url = parse_url($_SERVER['HTTP_REFERER']);
  if($refer_url == false || $refer_url['host'] != 'ntu.im' && $_SERVER['REMOTE_ADDR'] != '127.0.0.1'){
    $error['title'] = "QAQ";
    $error['message'] = "表單填寫不完整";
  }

  if(empty($error)){

    $comment = array(
      "blog" => "http://ntu.im/camp/",
      "user_ip" => $_SERVER["REMOTE_ADDR"],
      "user_agent" => $_SERVER["HTTP_USER_AGENT"],
      "referrer" => $_SERVER["HTTP_REFERER"],
      "permalink" => "http://ntu.im/camp/2015/",
      "comment_type" => "",
      "comment_author" => $_POST['name'],
      "comment_author_email" => $_POST['email'],
      "comment_author_url" => "",
      "comment_content" => $_POST['subject']." ".$_POST['message']
    );
    $ak_result = fuspam($comment, "check-spam", AKISMET_KEY);

    switch($ak_result){
      case "true":
        // spam
        echo "Spam check failed";
        break;
      case "false":
        // thank you
        $mg = new Mailgun(MAILGUN_KEY);
        $domain = "ntu.shouko.tw";
        $mg->sendMessage($domain, array(
          'from'    => 'imcamp2015@ntu.shouko.tw',
          'to'      => 'camp2015@ntu.im',
          'subject' => $_POST['subject'],
          'h:Reply-To' => $_POST['email'],
          'text'    => "From: ".$_POST['name']."<".$_POST['email'].">, ".$_SERVER["REMOTE_ADDR"]."\nUser-Agent:".$_SERVER["HTTP_USER_AGENT"]."\n\n".$_POST['message']
          )
        );

        $app->render('message.php', array('title' => 'Thank You!', 'message' => '感謝您的填寫，我們將盡快回覆<br><div class="row">
          <div class="12u">
            <ul class="actions">
              <li><a href="./" class="button">回首頁</a></li>
            </ul>
          </div>
        </div>'));
        break;
      default:
        break;
    }
  }else{
    $app->render('message.php', $error);
  }

});

$app->get('/register', function() use($app) {
  $app->render('register.php');
  /*
  $app->render('message.php', array('title' => 'Coming Soon!', 'message' => '報名系統將於 4/1 開放，敬請期待唷～<br><div class="row">
    <div class="12u">
      <ul class="actions">
        <li><a href="./" class="button">回首頁</a></li>
      </ul>
    </div>
  </div>'));
  */
});

$app->post('/register', function() use($app) {
  print_r($_POST);
  $error = array();

  /*
   Requirements of each parameter
   0: required text
   1: required integer
   2: optional
  */

  $para_req = array(
    'name' => 0,
    'gender' => 1,
    'bd_y' => 1,
    'bd_m' => 1,
    'bd_d' => 1,
    'rocid' => 0,
    'school' => 0,
    'grade' => 1,
    'size' => 0,
    'tel' => 0,
    'emergency' => 0,
    'emergency_tel' => 0,
    'eating' => 2,
    'illness' => 2,
    'email' => 0,
    'address' => 0,
    'hobby' => 0,
    'experience' => 0
  );

  $reg = R::dispense('reg');

  foreach($para_req as $para_key => $para_val){
    if(isset($_POST[$para_key])){
      $flag = 0;
      switch($para_val){
        case 0:
          $flag = $_POST[$para_key] == '' ? 1 : 0 ;
          break;
        case 1:
          $flag = $_POST[$para_key] != abs($_POST[$para_key]) ? 1 : 0 ;
          break;
        default:
      }
      if($flag == 1){
        $error['title'] = 'QAQ';
        break;
      }else{
        $reg[$para_key] = $_POST[$para_key];
      }
    }else{
      $error['title'] = 'QAQ';
    }
  }

  if(empty($error)){
    $files = array('id', 'life');
    $legal_exts = array('jpg', 'jpeg', 'png', 'gif');
    foreach($files as $fn){
      $original_name = explode('.', strtolower($_FILES[$fn]['name']));
      $ext = $original_name[count($original_name)-1];
      if( ! ( isset($_FIELS['$fn']) && $_FILES[$fn]['error'] == 0 && in_array($ext, $legal_exts) && $_FILES[$fn]['size'] <= 5*1024*1024 ) ){
        $error['title'] = 'QAQ';
        $error['message'] = '照片接受的格式為 JPG, PNG, GIF<br>檔案大小請勿超過 5 MB<br><div class="row">
          <div class="12u">
            <ul class="actions">
              <li><a href="javascript:history.back()" class="button">回上頁</a></li>
            </ul>
          </div>
        </div>';
      }else{
        $upload_name = time().'_'.rand(100,999).'.'.$ext;
        move_uploaded_file($_FILES[$fn]['tmp_name'], 'uploads/'.$upload_name);
        $reg['photo_'.$fn] = $upload_name;
      }
    }
    $reg['reg_time'] = R::isoDateTime();
  }

  $message = array();

  if(empty($error)){
    R::store($reg);
    $message['title'] = '報名成功！';
    $message['message'] = '感謝您的報名，請靜待通知喔～<br><div class="row">
        <div class="12u">
          <ul class="actions">
            <li><a href="./" class="button">回首頁</a></li>
          </ul>
        </div>
      </div>';
  }else if(!isset($error['message'])){
    $error['message'] = '表單有錯誤喔<br><div class="row">
      <div class="12u">
        <ul class="actions">
          <li><a href="javascript:history.back()" class="button">回上頁</a></li>
        </ul>
      </div>
    </div>';
    $message = $error;
  }else{
    $message = $error;
  }
  $app->render('message.php', $message);
});

$app->get('/thankyou', function() use($app) {
  $app->render('message.php', array('title' => 'Thank You!', 'message' => '感謝您的填寫，我們將盡快回覆<br><div class="row">
    <div class="12u">
      <ul class="actions">
        <li><a href="./" class="button">回首頁</a></li>
      </ul>
    </div>
  </div>'));
});

$app->run();
?>
