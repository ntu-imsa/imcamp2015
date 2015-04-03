<?php
  $cols = array();
  $cols['text'] = array('name', 'gender', 'school', 'grade', 'size', 'tel', 'emergency', 'emergency_tel', 'eating', 'illness', 'email', 'address', 'hobby', 'experience', 'expect');
?>
<section class="main style3 secondary">
  <div class="content container">
<!--    <header>
      <h2>報名系統</h2>
      <p>請填寫清楚，讓我們越容易認識你唷 :)</p>
    </header>
-->
    <div class="box container 75%">
      <table>
        <?php
          foreach($cols['text'] as $col){
            echo '<tr>';
            echo '<td>'.$col.'</td>';
            echo '<td>'.$data[$col].'</td>';
            echo '</tr>';
          }
        ?>
      </table>
    </div>
  </div>
</section>
