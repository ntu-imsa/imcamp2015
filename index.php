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
	if(!isset($_GET['fn'])){
    $nav = 'public';
    if(isset($_SESSION['user'])){
      $nav = 'admin';
    }
    $app->render('header.php', array("nav" => $nav));
  }
});

$app->hook('slim.after.dispatch', function () use ($app) {
  if(!isset($_GET['fn'])){
	   $app->render('footer.php');
   }
});

$app->get('/', function() use($app) {
  $app->render('index.php');
});

$app->get('/contact', function() use($app) {
  $app->render('contact.php');
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
  $current_time = time();
  if($current_time < REG_START){
    $app->render('countdown.php', array(
      'title' => '開放報名倒數中',
      'stop_callback_js' => 'window.location.reload();',
      'time' => REG_START - $current_time
    ));
  }else if($current_time > REG_END){
    $app->render('message.php', array('title' => 'Thank you!', 'message' => '報名時間已經結束～<br><div class="row">
      <div class="12u">
        <ul class="actions">
          <li><a href="./" class="button">回首頁</a></li>
        </ul>
      </div>
    </div>'));
  }else{
    $app->render('register.php');
  }
});

$app->post('/register', function() use($app) {

  if(time() > REG_END) exit();

  // Check reCaptcha result
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( array( "secret" => RECAPTCHA_KEY, "response" => isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : exit() , "remoteip" => $_SERVER['REMOTE_ADDR']) ));
  $result = json_decode(curl_exec($ch), 1);
  curl_close($ch);

//  print_r($_POST);
  $error = array();

  if(!isset($result['success']) || $result['success'] !== true){
    $error['title'] = 'QAQ';
  }

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
    'experience' => 0,
    'expect' => 0
  );

  $reg = R::dispense('reg');

  // Make sure all values are legal
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
        $reg[$para_key] = htmlspecialchars($_POST[$para_key]);
      }
    }else{
      $error['title'] = 'QAQ';
    }
  }

  if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $error['title'] = 'QAQ';
  }

  // File upload handling
  if(empty($error)){
    $files = array('id', 'life');
    $legal_exts = array('jpg', 'jpeg', 'png', 'gif');
    foreach($files as $fn){
      $original_name = explode('.', strtolower($_FILES[$fn]['name']));
      $ext = $original_name[count($original_name)-1];
      if( ! ( isset($_FILES[$fn]) && $_FILES[$fn]['error'] == 0 && in_array($ext, $legal_exts) && $_FILES[$fn]['size'] <= 8*1024*1024 ) ){
        error_log('IM Camp: File upload error, name: '.$_FILES[$fn]['name'].', error: '.$_FILES[$fn]['error'].', size: '.$_FILES[$fn]['size'], 0);
        $error['title'] = 'QAQ';
        $error['message'] = '照片接受的格式為 JPG, PNG, GIF<br>檔案大小請勿超過 5 MB<br><div class="row">
          <div class="12u">
            <ul class="actions">
              <li><a href="javascript:history.back()" class="button">回上頁</a></li>
            </ul>
          </div>
        </div>';
      }else{
        $upload_name = time().'_'.$fn.'_'.rand(100,999).'.'.$ext;
        move_uploaded_file($_FILES[$fn]['tmp_name'], 'uploads/'.$upload_name);
        $reg['photo_'.$fn] = $upload_name;
      }
    }

    if(isset($_POST['special_discount']) && $_POST['special_discount'] == 1){
      $fn = 'sp';
      $original_name = explode('.', strtolower($_FILES[$fn]['name']));
      $ext = $original_name[count($original_name)-1];
      if( ! ( isset($_FILES[$fn]) && $_FILES[$fn]['error'] == 0 && $_FILES[$fn]['size'] <= 5*1024*1024 ) ){
        $error['title'] = 'QAQ';
        $error['message'] = '檔案大小請勿超過 5 MB<br><div class="row">
          <div class="12u">
            <ul class="actions">
              <li><a href="javascript:history.back()" class="button">回上頁</a></li>
            </ul>
            </div>
          </div>';
      }else{
        $upload_name = time().'_'.$fn.'_'.rand(100,999).'.'.$ext;
        move_uploaded_file($_FILES[$fn]['tmp_name'], 'uploads/'.$upload_name);
        $reg['special_discount'] = 1;
        $reg[$fn] = $upload_name;
      }
    }

    $reg['source'] = !empty($_POST['source']) ? implode(',', $_POST['source']) : '' ;
    $reg['ua'] = $_SERVER['HTTP_USER_AGENT'];
    $reg['ip'] = $_SERVER['REMOTE_ADDR'];
    $reg['reg_time'] = R::isoDateTime();
  }

  $message = array();

  if(empty($error)){
    R::store($reg);
    // send thankyou mail
    date_default_timezone_set('Asia/Taipei');
    $mg = new Mailgun(MAILGUN_KEY);
    $domain = "ntu.shouko.tw";
    $envelope = array(
      'from'    => '2015 台大資管營 <imcamp2015@ntu.shouko.tw>',
      'to'      => $_POST['email'],
      'subject' => '2015 台灣大學資訊管理營 報名成功通知信',
      'h:Reply-To' => 'camp2015@ntu.im',
      'text'    => $_POST['name']." 同學你好，\n\n台大資管營已經於 ".date("Y/m/d H:i:s")." 收到你的報名表\n感謝你的報名，我們將於 5/10 報名截止後儘速通知你錄取結果 :)\n\n期待與你相見\n\n2015 台灣大學資訊管理營"
    );
    $mg->sendMessage($domain, $envelope);

    $message['title'] = '報名成功！';
    $message['message'] = '感謝您的報名，請靜待通知喔～<br><div class="row">
        <div class="12u">
          <ul class="actions">
            <li><a href="./" class="button">回首頁</a></li>
          </ul>
        </div>
      </div>';
    // To track convertion rate using GA, succcess message is not rendered right in this page
    $_SESSION['reg_success'] = 1;
    $app->response->redirect('./register_thankyou');
    $app->halt(302);
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

$app->get('/login', function() use($app) {
  $app->render('message.php', array('title' => 'Coming Soon!', 'message' => '報名系統將於 4/1 開放，敬請期待唷～<br><div class="row">
    <div class="12u">
      <ul class="actions">
        <li><a href="./" class="button">回首頁</a></li>
      </ul>
    </div>
  </div>'));
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

$app->get('/admin_portal', function() use($app) {
  if(!isset($_SESSION['user'])){
    $app->render('admin_portal_guest.php');
  }else{
    // logged in user
    $reg = R::findAll('reg');
    if(!empty($reg)){
      $cols = array('id','name','gender','school','grade','size','tel','email');
      $app->render('table.php', array('cols' => $cols, 'rows' => $reg));
    }else{
      $app->render('message.php', array('title' => 'QAQ!', 'message' => 'No registered user yet!'));
    }
  }
});

$app->get('/register_thankyou', function() use($app) {
  if(isset($_SESSION['reg_success'])){
    unset($_SESSION['rec_success']);
    $message = array();
    $message['title'] = '報名成功！';
    $message['message'] = '感謝您的報名，請靜待通知喔～<br>
      別忘了追蹤我們的 <a href="//facebook.com/ntuimcamp" target="_blank">Facebok 粉專</a>，取得最即時的訊息！
		  <div class="not-narrower">
					<div class="fb-page" data-href="https://www.facebook.com/ntuimcamp" data-width="500" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"></div>
			</div>
			<div class="only-narrower">
					<div class="fb-page" data-href="https://www.facebook.com/ntuimcamp" data-width="320" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"></div>
			</div><br>
      <div class="row">
        <div class="12u">
          <ul class="actions">
            <li><a href="./" class="button">回首頁</a></li>
          </ul>
        </div>
      </div>
      <div id="fb-root"></div>
      <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&appId=520188428109474&version=v2.3";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, \'script\', \'facebook-jssdk\'));</script>';
    $app->render('message.php', $message);
  }else{
    $app->response->redirect('./');
    $app->halt(302);
  }
});

$app->post('/admin_portal', function() use($app) {
  if(isset($_POST['register']) && $_POST['register'] == 1){
    // register
    if(!(isset($_POST['user']) && isset($_POST['pwd'])) || $_POST['pwd'][0] !== $_POST['pwd'][1]){
      $app->halt(400);
    }else{
      $reg_data = R::dispense('staff');
      $reg_data['user'] = $_POST['user'];
      $reg_data['pwd'] = hash('sha256', $_POST['pwd'][0]);
      $reg_data['type'] = 0;
      R::store($reg_data);
      $app->render('message.php', array('title' => 'Success!', 'message' => 'Ask admin to activate your account.'));
    }
  }else{
    // login
    $staff = R::findOne( 'staff', ' user = ? ', [ $_POST['user'] ] );
    if($staff != NULL){
      if($staff['pwd'] == hash('sha256', $_POST['pwd'][0]) && $staff['type'] != 0){
        // success
        $_SESSION['user'] = $staff['user'];
        $app->response->redirect('./admin_portal');
        $app->halt(302);
      }
    }
    $app->render('message.php', array('title' => 'Staff Only!', 'message' => 'Unauthorized Access!'));
  }
});

$app->get('/admin_reg_detail', function() use($app) {
  if(!isset($_SESSION['user'])){
    $app->response->redirect('./admin_portal');
    $app->halt(302);
  }else{
    if(isset($_GET['id'])){
      $reg = R::load('reg', $_GET['id']);
      if(!empty($reg)){
        $app->render('admin_reg_detail.php', array('data' => $reg));
      }else{
        $app->render('message.php', array('title' => 'Oops!', 'message' => 'Not Found!'));
      }
    }
  }
});

$app->get('/file', function() use($app) {
  if(!isset($_SESSION['user'])){
    $app->halt(401);
  }else if(isset($_GET['fn']) && $_GET['fn'] !== ''){
    // TODO refine this section
    if(strpos('/', $_GET['fn']) === false && strpos('\\', $_GET['fn']) === false){
      $fn = './uploads/'.$_GET['fn'];
      if(file_exists($fn)){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $fn);
        $app->response->headers->set("Content-Type", $mime);
        echo file_get_contents($fn);
      }else{
        $app->halt(404);
      }
    }
  }
});

$app->get('/logout', function() use($app) {
  session_destroy();
  $app->response->redirect('./');
});

$app->run();
?>
