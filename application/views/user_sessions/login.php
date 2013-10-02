<div class="content-login">
    <br/>
    <?php if (!empty($message)) { ?>
        <div id="message">
            <?php echo $message; ?>
        </div>
    <?php } ?>
    <form class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo site_url('login') ?>">
        <div class="control-group">
            <label class="control-label" for="inputEmail">Username</label>
            <div class="controls">
                <input type="text" name="login_identity" id="inputEmail" placeholder="Username">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputPassword">Password</label>
            <div class="controls">
                <input type="password" id="inputPassword" placeholder="Password" name="login_password">
            </div>
        </div>
        <input type="hidden" name="login_user" value="1"/>
        <?php
        # Below are 2 examples, the first shows how to implement 'reCaptcha' (By Google - http://www.google.com/recaptcha),
        # the second shows 'math_captcha' - a simple math question based captcha that is native to the flexi auth library. 
        # This example is setup to use reCaptcha by default, if using math_captcha, ensure the 'auth' controller and 'demo_auth_model' are updated.
        # reCAPTCHA Example
        # To activate reCAPTCHA, ensure the 'if' statement immediately below is uncommented and then comment out the math captcha 'if' statement further below.
        # You will also need to enable the recaptcha examples in 'controllers/auth.php', and 'models/demo_auth_model.php'.
        #/*
        if (isset($captcha)) {
            echo "<li>\n";
            echo $captcha;
            echo "</li>\n";
        }
        #*/

        /* math_captcha Example
          # To activate math_captcha, ensure the 'if' statement immediately below is uncommented and then comment out the reCAPTCHA 'if' statement just above.
          # You will also need to enable the math_captcha examples in 'controllers/auth.php', and 'models/demo_auth_model.php'.
          if (isset($captcha))
          {
          echo "<li>\n";
          echo "<label for=\"captcha\">Captcha Question:</label>\n";
          echo $captcha.' = <input type="text" id="captcha" name="login_captcha" class="width_50"/>'."\n";
          echo "</li>\n";
          }
          # */
        ?>
        <div class="control-group">
            <div class="controls">
                <label class="checkbox">
                    <input type="checkbox" id="remember_me" name="remember_me" value="1"> Remember me
                </label>
                <button type="submit" class="btn">Sign in</button>
            </div>
        </div>
    </form>
</div>