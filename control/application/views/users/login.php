<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow"> <!-- control panel should not be indexed by search engines -->
  <link href="<?php echo base_url; ?>assets/web-fonts-with-css/css/fontawesome-all.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url; ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url; ?>assets/custom.css">
</head>
<body class="<?php echo $page; ?>">
    <div class="<?php echo $page;?>-module">
        <div class="container">
            <div class="login_module col-10 offset-1 col-md-6 offset-md-3">
                <?php
                if($this->input->get('re_direct') != null)
                {
                    $hidden = array('redirect'=>$this->input->get('re_direct')); //hidden attribute to redirect to desired page after login
                }
                else{
                    $hidden = array('redirect'=>'');
                }
                $attributes = array('class' => 'login_form', 'id' => 'login_form');
                echo form_open('users/login', $attributes, $hidden); ?>
                    <?php //echo validation_errors();?>
                    <div class="form-group">
                        <div class="text-danger"><?php echo form_error('id');?></div>
                        <input type="text" name="id" class="form-control" placeholder="Username or Email"  value="<?php echo set_value('id');?>" />
                    </div>
                    <div class="form-group">
                    <div class="text-danger"><?php echo form_error('password');?></div>
                        <input type="password" name="password" class="form-control" placeholder="Password"  value="<?php echo set_value('password');?>" />
                    </div>
                    <div class="form-group login_btn">
                        <input type="submit" name="submit" class=" btn btn-outline-primary" value="Login" />
                    </div>
                    <div class="form-group">
                        <input type="button" name="submit" class=" btn btn-link" value="Forgot-Password" />
                    </div>
                    <?php if(isset($info)){echo '<div class="text-danger">'.$info.'</div>';} ?>
                </form>
            </div>
        </div>
    </div>
</body>
<footer>
    <script src="<?php echo base_url; ?>assets/javascript/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url; ?>assets/javascript/jquery.form.min.js"></script>
    <script src="<?php echo base_url; ?>assets/javascript/menu.script.js"></script>
    <script src="<?php echo base_url; ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url; ?>assets/javascript/user.script.js"></script>
</footer>
