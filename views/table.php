<section class="main style3 secondary">
  <div class="content container">
    <div class="box container 80%">
    <h3>Registration Data</h3>
    <table style="margin: 50px 0; overflow: auto">
      <tr>
      <?php
        foreach($cols as $col){
          echo '<th>'.$col.'</th>';
        }
      ?>
      </tr>
      <?php
        $stat = array('gender' => array());
        $stat['gender'][0] = 0;
        $stat['gender'][1] = 0;
        foreach($rows as $row){
          echo '<tr>';
          foreach($cols as $col){
            if($col == 'id'){
              echo '<td><a href="./admin_reg_detail?id='.$row[$col].'">'.$row[$col].'</a></td>';
            }else{
              echo '<td>'.$row[$col].'</td>';
            }
            if($col == 'gender'){
              $stat['gender'][$row[$col]]++;
            }
          }
          echo '</tr>';
        }
        echo '<tr><td></td><td></td><td></td><td>T: '.count($rows).' / M: '.$stat['gender'][0].' / F: '.$stat['gender'][1].'</td></td>';
      ?>
    </table>
  </div>
  </div>
</section>
