<div class="col-12 col-md-6">
    <h4> Add new user </h4>
    <h6> Create a new user to take part on your site </h6><br/>
    <?php 
    if(isset($info)){echo '<p>'.$info.'</p>';}
    $attributes = array('class' => 'new_user_form');
    echo form_open('users/new_user', $attributes);
    ?>
    <div class="form-group">
        <div class="text-danger"><?php echo form_error('first_name');?></div>
        <label for="first_name"> First Name </label>
        <input type="text" name="first_name" class="form-control" value="<?php echo set_value('first_name');?>" id="first_name" placeholder="Enter First Name"/>
    </div>
    <div class="form-group">
        <div class="text-danger"><?php echo form_error('last_name');?></div>
        <label for="last_name"> Last Name </label>
        <input type="text" name="last_name" class="form-control" value="<?php echo set_value('last_name');?>" id="last_name" placeholder="Enter Last Name"/>
    </div>
    <div class="form-group">
        <div class="text-danger"><?php echo form_error('user_name');?></div>
        <label for="user_name"> UserName <i>(required)</i>  </label>
        <input type="text" name="user_name" class="form-control" value="<?php echo set_value('user_name');?>" id="user_name" placeholder="Enter UserName"/>
    </div>
    <div class="form-group">
        <div class="text-danger"><?php echo form_error('email');?></div>
        <label for="email"> Email Address <i>(required)</i>  </label>
        <input type="email" name="email" class="form-control" value="<?php echo set_value('email');?>" id="email" placeholder="Enter Email"/>
    </div>
    <div class="form-group">
        <div class="text-danger"><?php echo form_error('password');?></div>
        <label for="password"> Password <i>(required)</i>  </label>
        <input type="password" name="password" class="form-control" value="<?php echo set_value('password');?>" id="password" placeholder="Enter Password"/>
    </div>
    <div class="form-group">
        <div class="text-danger"><?php echo form_error('cpassword');?></div>
        <label for="cpassword"> Confirm Password</label>
        <input type="password" name="cpassword" class="form-control"  id="cpassword" placeholder="Confirm Password"/>
    </div>
    <div class="form-group">
        <label for="role"> Role  </label>
        <select name="role" class="form-control">
            <?php 
            function selected($list)
            {
                if(set_value('role') == $list){echo "selected";}
            }
            ?>
            <option <?php selected('User') ?>>User</option>
            <option <?php selected('Administrator') ?>>Administrator</option>
            <option <?php selected('Editor') ?>>Editor</option>
            <option <?php selected('Author') ?>>Author</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary btn-sm" value="Add User" name="submit" />
    </div>
