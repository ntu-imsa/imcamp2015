<?php
  $cols = array();
  $cols['text'] = array('name', 'gender', 'school', 'grade', 'size', 'tel', 'emergency', 'emergency_tel', 'eating', 'illness', 'email', 'address', 'hobby', 'experience', 'expect', 'source');
  $cols['photo'] = array('photo_id', 'photo_life');
?>
<section class="main style3 secondary">
  <div class="content container">
<!--    <header>
      <h2>報名系統</h2>
      <p>請填寫清楚，讓我們越容易認識你唷 :)</p>
    </header>
-->
    <div class="box container 80%">
      <?php
        foreach($cols['text'] as $col){
          echo '<div class="row">';
          echo '<div class="3u">'.$col.'</div>';
          echo '<div class="9u" style="text-align:left">'.nl2br($data[$col]).'</div>';
          echo '</div>';
        }
        foreach($cols['photo'] as $col){
          echo '<div class="row">';
          echo '<div class="3u">'.$col.'</div>';
          echo '<div class="9u"><img src="./file?fn='.$data[$col].'" style="width:100%"></div>';
        }
      ?>
    </div>
  </div>
</section>
