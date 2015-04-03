<!-- Contact -->
  <section id="contact" class="main style3 secondary">
    <div class="content container">
      <header>
        <h2>Staff Only!</h2>
        <p>Ask admin for details</p>
      </header>
      <div class="box container 50%">
          <form method="post" action="./admin_portal">
            <div class="row 50%">
              <div class="12u"><input type="text" name="user" placeholder="Username" /></div>
              <div class="12u"><input type="password" name="pwd[]" placeholder="Password" /></div>
              <div class="12u" id="pwd_confirm" style="display:none"><input type="password" name="pwd[]" placeholder="Confirm Password" /></div>
            </div>
            <div class="12u"><label><input type="checkbox" name="register" id="register" value="1">Is Register</label></div><br>
            <script type="text/javascript">
              document.getElementById('register').onclick = function() {
                if(this.checked){
                  document.getElementById('pwd_confirm').style.display = '';
                }else{
                  document.getElementById('pwd_confirm').style.display = 'none';
                }
              };
            </script>
            <div class="row">
              <div class="12u">
                <ul class="actions">
                  <li><input type="submit" value="Go" /></li>
                </ul>
              </div>
            </div>
          </form>
      </div>
    </div>
  </section>
