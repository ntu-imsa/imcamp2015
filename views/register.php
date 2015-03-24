<section class="main style3 secondary">
  <div class="content container">
    <header>
      <h2>報名系統</h2>
      <p>請填寫清楚，讓我們越容易認識你唷 :)</p>
    </header>
    <div class="box container 75%">

        <form method="post" action="./contact">
          <div class="row 50%">
            <div class="6u 12u(narrower)"><input type="text" name="name" placeholder="姓名" /></div>
            <div class="6u 12u(narrower)" style="text-align:left;line-height:3.1em;">性別：
              <label style="display:inline"><input type="radio" name="gender" value="0" id="male" />男</label>
              <label style="display:inline"><input type="radio" name="gender" value="1" id="female" />女</label>
            </div>
            <div class="6u 12u(narrower)"><input type="text" name="school" placeholder="就讀學校" /></div>
            <div class="6u 12u(narrower)">
              <select name="size">
                <option>年級</option>
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
            <div class="6u 12u(narrower)"><input type="tel" name="emergency-tel" placeholder="緊急聯絡人電話" /></div>
            <div class="6u 12u(narrower)"><input type="tel" name="eating" placeholder="特殊飲食需求 (eg. 素食、不吃牛...)" /></div>
            <div class="6u 12u(narrower)"><input type="tel" name="illness" placeholder="特殊疾病、狀況" /></div>
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
