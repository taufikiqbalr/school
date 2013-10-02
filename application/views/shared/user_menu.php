<div class="toplinks">
    <div>
        Welcome <a href="<?php echo site_url('users/'.$this->session->userdata('flexi_auth')['user_id'])  ?>"><?php echo $this->session->userdata('flexi_auth')['user_identifier'] ?></a> | <a href="<?php echo site_url('logout') ?>">Log Out</a>
    </div>
</div>