<section class="main style3 secondary">
  <div class="content container">
    <div class="box container 80%">
    <h3>Billing Data</h3>
    <form method="POST">
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
        $stat['paid'][0] = 0;
        $stat['paid'][1] = 0;
        $stat['confirmed'] = 0;
        $stat['waiting'] = 0;
        foreach($rows as $row){
          echo '<tr>';
          foreach($cols as $col){
            echo '<td>';
            if($col == 'id'){
              echo '<a href="./admin_reg_detail?id='.$row[$col].'">'.$row[$col].'</a>';
            }else if($col == 'status'){
              if($row[$col] == '0'){
                echo '<input type="checkbox" name="bid[]" value="'.$row['bid'].'">';
              }else{
                echo $row[$col];
              }
            }else{
              echo $row[$col];
            }
            echo '</td>';
            if($col == 'gender'){
              $stat['gender'][$row[$col]]++;
            }
          }
          if($row['status'] == 1){
            $stat['paid'][$row['gender']]++;
            $stat['confirmed'] += $row['should_pay'];
          }else if($row['status'] == '0'){
            $stat['waiting'] += $row['should_pay'];
          }
          echo '</tr>';
        }
        echo '<tr><td></td><td></td><td></td><td>T: '.count($rows).' / M: '.$stat['gender'][0].' / F: '.$stat['gender'][1].'</td><td></td><td>Paid: '.($stat['paid'][0] + $stat['paid'][1]).' / M: '.$stat['paid'][0].' / F: '.$stat['paid'][1].'</td><td>Confirmed: '.$stat['confirmed'].'</td></tr>';
        echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>Waiting : '.$stat['waiting'].'</td></tr>';
      ?>
    </table>
    <input type="submit" value="Confirm Paid" />
    </form>
  </div>
  </div>
</section>
