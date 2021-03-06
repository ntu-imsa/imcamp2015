<section class="main style3 secondary">
  <div class="content container">
    <header>
      <h2>報名系統</h2>
      <p>請填寫清楚，讓我們越容易認識你唷 :)</p>
    </header>
    <div class="box container 75%">

        <form method="post" action="./register" enctype="multipart/form-data">
          <div class="row 50%">
            <div class="6u 12u(narrower)"><input type="text" name="name" placeholder="姓名" /></div>
            <div class="6u 12u(narrower)">
              <select name="gender">
                <option>性別▽</option>
                <option value="0">男</option>
                <option value="1">女</option>
              </select>
            </div>
          </div>
          <div class="row 50%">
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
          </div>
          <div class="row 50%">
            <div class="3u">大頭照：</div>
            <div class="7u"><input name="id" type="file"></div>
            <div class="3u">個人生活照：</div>
            <div class="7u"><input name="life" type="file"></div>
          </div>
          <div class="row 50%">
            <div class="6u 12u(narrower)"><input type="text" name="school" placeholder="就讀學校" /></div>
            <div class="6u 12u(narrower)">
              <select name="grade">
                <option>年級▽</option>
                <option value="1">一年級</option>
                <option value="2">二年級</option>
                <option value="3">三年級</option>
                <option value="4">其他</option>
              </select>
            </div>
          </div>
          <div class="row 50%">
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
          </div>
          <div class="row 50%">
            <div class="6u 12u(narrower)"><input type="text" name="emergency" placeholder="緊急聯絡人 (eg. 胡抽抽/爸爸)" /></div>
            <div class="6u 12u(narrower)"><input type="tel" name="emergency_tel" placeholder="緊急聯絡人電話" /></div>
          </div>
          <div class="row 50%">
            <div class="6u 12u(narrower)"><input type="text" name="eating" placeholder="特殊飲食需求 (eg. 素食、不吃牛...)" /></div>
            <div class="6u 12u(narrower)"><input type="text" name="illness" placeholder="特殊疾病、狀況" /></div>
          </div>
          <div class="row 50%">
            <div class="12u"><input type="email" name="email" placeholder="聯絡 Email" /></div>
            <div class="12u"><input type="text" name="address" placeholder="通訊地址" /></div>
          </div>
          <div class="row 50%">
            <div class="12u"><textarea name="hobby" placeholder="個人興趣或特質" rows="6"></textarea></div>
            <div class="12u"><textarea name="experience" placeholder="特殊經歷(社團活動、工作經驗或其他特殊事蹟等,限國高中時期)" rows="6"></textarea></div>
            <div class="12u"><textarea name="expect" placeholder="報名動機及期待收穫" rows="6"></textarea></div>
            <div class="12u">你從何處得知臺大資管營：<br>
              <nobr><label><input type="checkbox" name="source[]" value="aza"> 杜鵑花節攤位 </label></nobr><wbr>
              <nobr><label><input type="checkbox" name="source[]" value="search"> 網路搜尋 </label></nobr><wbr>
              <nobr><label><input type="checkbox" name="source[]" value="fb"> Facebook 專頁 </label></nobr><wbr>
              <nobr><label><input type="checkbox" name="source[]" value="schoolweb"> 學校網站 </label></nobr><wbr>
              <nobr><label><input type="checkbox" name="source[]" value="sposter"> 學校海報 </label></nobr><wbr>
              <nobr><label><input type="checkbox" name="source[]" value="cposter"> 補習班海報 </label></nobr><wbr>
              <nobr><label><input type="checkbox" name="source[]" value="inclass"> 入班宣傳 </label></nobr><wbr>
              <input type="text" name="source[]" placeholder="其他">
            </div>
            <div class="row">
              <div class="12u"><label><input type="checkbox" name="group_discount" id="group_discount" value="1">申請三人團報優惠</label><br>
                和好朋友揪團報名資管營吧！只要湊滿三人，錄取後即可得到 200 元報名費減免唷。
              </div>
            </div>
            <div class="row container 75%" id="group_upload" style="display:none">
              <div class="12u"><input name="gp" type="text" placeholder="夥伴姓名"></div>
            </div>
            <div class="12u"><label><input type="checkbox" name="special_discount" id="special_discount" value="1">申請家境清寒報名費減免</label></div>
            <div class="row container 75%" id="special_upload" style="display:none">
              <div class="12u">為協助家境清寒學生能參與本次活動，<br>上傳相關證明文件並錄取後，得以2000元報名費參與本次活動。</div>
              <div class="4u">相關證明文件：</div>
              <div class="6u"><input name="sp" type="file"></div>
            </div>
            <script type="text/javascript">
              document.getElementById('special_discount').onclick = function() {
                if(this.checked == true){
                  document.getElementById('special_upload').style.display = '';
                }else{
                  document.getElementById('special_upload').style.display = 'none';
                }
              };
              document.getElementById('group_discount').onclick = function() {
                if(this.checked == true){
                  document.getElementById('group_upload').style.display = '';
                }else{
                  document.getElementById('group_upload').style.display = 'none';
                }
              };
            </script>
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
            <div class="3u">安全性驗證：</div>
            <div class="9u">
              <div class="g-recaptcha" data-sitekey="6LcMCAQTAAAAAC5pXpq0Dloi3DkKX5cycWoN23Av"></div>
            </div>
            <div class="12u" style="color:orange">
              送出前請確認以上表單填寫完整!
            </div>
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
