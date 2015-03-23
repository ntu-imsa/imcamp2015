<?php
session_start();
require 'includes/config.php';
require 'vendor/autoload.php';
use Mailgun\Mailgun;

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
  if($refer_url == false || $refer_url['host'] != 'ntu.im' && $_SERVER['HTTP_HOST'] != 'localhost'){
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

$app->run();
?>
