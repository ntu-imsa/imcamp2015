<?php
  $cols = array();
  $cols['text'] = array('name', 'school', 'grade', 'email', 'status_text');
  $cols['text_chn'] = array('姓名', '學校', '年級', 'Email', '狀態');
?>
<section class="main style3 secondary">
  <div class="content container">
    <header>
      <h2>報名系統</h2>
      <p>以下是您的報名資料</p>
    </header>
    <div class="box container 80%">
      <?php
        if(time() > ANNOUNCE_TIME){
          switch($data['status']){
            case "-1":
              $data['status_text'] = '已放棄';
              break;
            case "0":
              $data['status_text'] = '候補中';
              break;
            case "1":
              $data['status_text'] = '錄取';
              break;
          }
        }else{
          $data['status_text'] = '報名成功，結果未公佈';
        }
        foreach($cols['text'] as $cid => $col){
          echo '<div class="row">';
          echo '<div class="3u">'.$cols['text_chn'][$cid].'</div>';
          echo '<div class="9u" style="text-align:left">'.nl2br($data[$col]).'</div>';
          echo '</div>';
        }
        if(time() > ANNOUNCE_TIME && $data['status'] == 1){
          // registrant admitted
          if(empty($data_bill)){
            // not paid
            $_SESSION['should_pay'] = PRICE - $data['discount'];
            echo '<div class="row">';
            echo '<div class="3u">匯款帳號</div>';
            echo '<div class="9u" style="text-align:left">'.BANK_INFO.'</div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="3u">應繳金額</div>';
            echo '<div class="9u" style="text-align:left">'.$_SESSION['should_pay'].($data['discount'] !== 0 ? ' ( 優惠方案: '.implode(',', $data['discount_text']).' )' : '' ).'</div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="3u">匯款資訊</div>';
            echo '<div class="6u 9u(narrower)"><form method="POST"><textarea name="info" placeholder="請填入匯款資訊，如帳號後五碼、匯款人姓名、以及轉帳時間" rows="3"></textarea><input type="submit" value="確認" /></form></div>';
            echo '</div>';
          }else if($data_bill['status'] == 0){
            // paid, not confirmed
            echo '<div class="row">';
            echo '<div class="3u">匯款資訊</div>';
            echo '<div class="6u 9u(narrower)">'.nl2br($data_bill['info']).'</div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="3u">繳費狀態</div>';
            echo '<div class="9u" style="text-align:left">待確認</div>';
            echo '</div>';
          }else if($data_bill['status'] == 1){
            // paid, confirmed
            echo '<div class="row">';
            echo '<div class="3u">繳費狀態</div>';
            echo '<div class="9u" style="text-align:left">繳費已確認，期待營期與你相見 :)</div>';
            echo '</div>';
          }
        }
      ?>
    </div>
    <br><br>
    <div class="12u">
      <ul class="actions">
        <li><a href="./logout" class="button">登出</a></li>
      </ul>
    </div>
  </div>
</section>
