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
        foreach($rows as $row){
          echo '<tr>';
          foreach($cols as $col){
            if($col == 'id'){
              echo '<td><a href="./admin_reg_detail?id='.$row[$col].'">'.$row[$col].'</a></td>';
            }else{
              echo '<td>'.$row[$col].'</td>';
            }
          }
          echo '</tr>';
        }
      ?>
    </table>
  </div>
  </div>
</section>
