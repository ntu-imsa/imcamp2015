<?php
  $cols = array();
  $cols['text'] = array('regstat', 'admission', 'name', 'school', 'grade', 'email');
  $cols['text_chn'] = array('報名狀態', '錄取狀態', '姓名', '學校', '年級', 'Email');
?>
<section class="main style3 secondary">
  <div class="content container">
    <header>
      <h2>報名系統</h2>
      <p>以下是您的報名資料</p>
    </header>
    <div class="box container 80%">
      <?php
        foreach($cols['text'] as $cid => $col){
          echo '<div class="row">';
          echo '<div class="3u">'.$cols['text_chn'][$cid].'</div>';
          echo '<div class="9u" style="text-align:left">'.nl2br($data[$col]).'</div>';
          echo '</div>';
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
