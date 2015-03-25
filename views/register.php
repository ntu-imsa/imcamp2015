<section class="main style3 secondary">
  <div class="content container">
    <header>
      <h2>報名系統</h2>
      <p>請填寫清楚，讓我們越容易認識你唷 :)</p>
    </header>
    <div class="box container 75%">

        <form method="post" action="./register">
          <div class="row 50%">
            <div class="6u 12u(narrower)"><input type="text" name="name" placeholder="姓名" /></div>
            <div class="6u 12u(narrower)">
              <select name="gender">
                <option>性別▽</option>
                <option value="0">男</option>
                <option value="1">女</option>
              </select>
            </div>
            <?php
              $cols = array(
                array("bd_y", "出生年", 1995, 2005),
                array("bd_m", "月", 1, 12),
                array("bd_d", "日", 1, 31)
              );
              foreach($cols as $col){
                echo '<div class="2u 4u(narrower)"><select name="'.$col[0].'">';
                echo '<option>'.$col[1].'▽</option>';
                for($i = $col[2]; $i <= $col[3]; $i++){
                  echo '<option value="'.$i.'">'.$i.'</option>';
                }
                echo '</select></div>';
              }
            ?>
            <div class="6u 12u(narrower)"><input type="text" name="rocid" placeholder="身分證字號 (保險用)" /></div>
            <div class="6u 12u(narrower)"><input type="text" name="school" placeholder="就讀學校" /></div>
            <div class="6u 12u(narrower)">
              <select name="grade">
                <option>年級▽</option>
                <option value="1">一年級</option>
                <option value="2">二年級</option>
                <option value="3">三年級</option>
              </select>
            </div>
            <div class="6u 12u(narrower)">
              <select name="size">
                <option>營服尺寸▽</option>
                <option value="XS">XS</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="2L">2L</option>
              </select>
            </div>
            <div class="6u 12u(narrower)"><input type="tel" name="tel" placeholder="聯絡電話" /></div>
            <div class="6u 12u(narrower)"><input type="text" name="emergency" placeholder="緊急聯絡人姓名/關係" /></div>
            <div class="6u 12u(narrower)"><input type="tel" name="emergency_tel" placeholder="緊急聯絡人電話" /></div>
            <div class="6u 12u(narrower)"><input type="text" name="eating" placeholder="特殊飲食需求 (eg. 素食、不吃牛...)" /></div>
            <div class="6u 12u(narrower)"><input type="text" name="illness" placeholder="特殊疾病、狀況" /></div>
            <div class="12u"><input type="email" name="email" placeholder="聯絡 Email" /></div>
            <div class="12u"><input type="text" name="address" placeholder="通訊地址" /></div>
            <div class="12u"><textarea name="hobby" placeholder="個人興趣或特質" rows="6"></textarea></div>
            <div class="12u"><textarea name="experience" placeholder="特殊經歷(社團活動、工作經驗或其他特殊事蹟等,限國高中時期)" rows="6"></textarea></div>
            <div class="12u"><textarea name="hobby" placeholder="報名動機及期待收穫" rows="6"></textarea></div>
          </div>
<!--
姓名		性別
出生年月日		身份證字號
就讀學校		年級
營服尺寸(XS,S,M,L,XL,2L)		聯絡電話
緊急聯絡人姓名及關係		緊急聯絡人電話
血型		是否吃素
特殊飲食需求		特殊疾病
常用email
通訊地址
-->
          <div class="row">
            <div class="12u">
              <ul class="actions">
                <li><input type="submit" value="送出" /></li>
              </ul>
            </div>
          </div>
        </form>
    </div>
  </div>
</section>
