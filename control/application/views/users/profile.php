<div class="col-12">
    <?php
    if (isset($account_error))
    {
        echo $account_error;
    }
    else{
    ?>
    <h4> <?php echo $account_owner; ?> </h4>
    <h6> Edit your profile data</h6><br/>
    <?php 
    if(isset($info)){echo '<p>'.$info.'</p>';}  
    $attributes = array('class' => 'user_profile_form');
    echo form_open('users/view_user/'.$id, $attributes);
    ?>
        <div class = "row">
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-sm" value="Update" name="submit" />
            </div>
        </div>
        <div class = "row">
            <div class="col-6 col-md-3 profile_form_div text-center">
                <p class="text-center">Profile Photo</p>
                <div class="text-danger"><?php echo form_error('image_url');?></div>
                <p><img  class="profile_page_picture" src="<?php echo $image_url; ?>" alt="No Image Yet?" /><p>
                <input type="button" value="Change" class="btn btn-secondary btn-sm media_select" selecttype="images">
                <input type="hidden"  class="form-control profile_page_picture_url" name="image_url" value="<?php echo $image_url; ?>" placeholder="Enter Image url">
            </div>
            <div class="col-12 col-md-3 offset-md-1  profile_form_div">
                <p class="text-center"> Role  </p>
                <div class="form-group">
                <?php
                if($this->session->role == 'Administrator')
                { ?>
                    <select name="role" class="form-control">
                        <?php 
                        define('ROLE', $user_role);
                        function selected($list)
                        {
                            if($list == ROLE){echo "selected";}
                        }
                        ?>
                        <option <?php selected('User') ?>>User</option>
                        <option <?php selected('Administrator') ?>>Administrator</option>
                        <option <?php selected('Editor') ?>>Editor</option>
                        <option <?php selected('Author') ?>>Author</option>
                    </select>
                <?php
                }
                else
                { ?>
                  <input type="text" readonly='readonly' class="form-control" name="role" value="<?php echo $user_role; ?>">  
                <?php } ?>
                </div>
                <div class="form-group">
                    <div class="text-danger"><?php echo form_error('password');?></div>
                    <input type="button" class="btn btn-secondary password_change btn-sm" value="Change Password" />
                    <div class="password_change_block"><br>
                        <input type="password" name="password" class="form-control password" value="<?php ?>" id="password" placeholder="Enter new password"/>
                        <input type="button" class="btn btn-link btn-sm show_password" value="show"/>
                        <input type="button" class="btn btn-link btn-sm hide_password" value="hide"/>
                        <input type="button" class="btn btn-link btn-sm cancel_password_change" value="Cancel"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-5 profile_form_div">
                <p class="text-center">Personal Data</p>
                <div class="form-group">
                    <div class="text-danger"><?php echo form_error('first_name');?></div>
                    <label for="first_name"> First Name </label>
                    <input type="text" name="first_name" class="form-control" value="<?php if(set_value('first_name')){echo set_value('first_name');}else{ echo $first_name;}?>" id="first_name" placeholder="Enter First Name"/>
                </div>
                <div class="form-group">
                    <div class="text-danger"><?php echo form_error('last_name');?></div>
                    <label for="last_name"> Last Name </label>
                    <input type="text" name="last_name" class="form-control" value="<?php if(set_value('last_name')){echo set_value('last_name');}else{ echo $last_name;}?>" id="last_name" placeholder="Enter Last Name"/>
                </div>
                <div class="form-group">
                    <div class="text-danger"><?php echo form_error('user_name');?></div>
                    <label for="user_name"> UserName <i>(username can not be edited)</i></label>
                    <input type="text" name="user_name" disabled class="form-control" value="<?php echo $user_name;?>" id="user_name" placeholder="Enter UserName"/>
                </div>
                <div class="form-group">
                    <div class="text-danger"><?php echo form_error('display_name');?></div>
                    <label for="display_name"> Display Name <i>(required)</i>  </label>
                    <input type="text" name="display_name" class="form-control" value="<?php if(set_value('display_name')){echo set_value('display_name');}else{ echo $display_name;}?>" id="display_name" placeholder="Enter Display Name"/>
                </div>
                <div class="form-group">
                    <div class="text-danger"><?php echo form_error('email');?></div>
                    <label for="email"> Email Address </label>
                    <input type="email" name="email" class="form-control" value="<?php if(set_value('email')){echo set_value('email');}else{ echo $user_email;}?>" id="email" placeholder="Enter Email Address"/>
                </div>
            </div>
            <div class="col-12 col-md-5 offset-md-1 profile_form_div">
                <p class="text-center">Address Data</p>
                <div class="form-group">
                    <label for="country"> Country </label>
                    <select class="form-control" name="country" id="country">
                    <?php 
                        if(!empty($country)){?>
                    <option selected> <?php if(set_value('country')){echo set_value('country');}else{ echo $country;} ?> </option>
                        <?php } ?>
                    </select>
                    <input type="hidden" name="country_code" class="form-control"  id="country_code"/>
                </div>
                <div class="form-group">
                    <div class="text-danger"><?php echo form_error('phone');?></div>
                    <label for="phone" style="display:block"> Phone Number </label>
                    <input type="tel" name="phone" class="form-control phone" value="<?php if(set_value('phone')){echo set_value('phone');}else{ echo $user_phone;} ?>" id="phone" placeholder=""/>
                    <input type="text" name="phone_code" readonly="readonly" class="form-control phone_code" value="" id="phone_code"/>
                </div>
                <div class="form-group">
                    <div class="text-danger"><?php echo form_error('state');?></div>
                    <label for="state"> State </label>
                    <input type="text" name="state" class="form-control" value="<?php if(set_value('state')){echo set_value('state');}else{ echo $state;} ?>" id="state" placeholder="Enter Your State"/>
                </div>
                <div class="form-group">
                    <div class="text-danger"><?php echo form_error('city');?></div>
                    <label for="city"> City/LGA </label>
                    <input type="text" name="city" class="form-control" value="<?php if(set_value('city')){echo set_value('city');}else{ echo $city;} ?>" id="city" placeholder="Enter your City"/>
                </div>
                <div class="form-group">
                    <div class="text-danger"><?php echo form_error('home');?></div>
                    <label for="home"> Home </label>
                    <input type="text" name="home" class="form-control" value="<?php if(set_value('home')){echo set_value('home');}else{ echo $home;} ?>" id="home" placeholder="Enter your house number/block"/>
                </div>
                <div class="form-group">
                    <div class="text-danger"><?php echo form_error('postal_code');?></div>
                    <label for="postal_code"> Postal Code </label>
                    <input type="text" name="postal_code" class="form-control" value="<?php if(set_value('postal_code')){echo set_value('postal_code');}else{ echo $postal_code;}?>" id="postal_code" placeholder="Enter Your Postal Code"/>
                </div> 
                <div class="form-group">
                    <div class="text-danger"><?php echo form_error('website');?></div>
                    <label for="website"> Website </label>
                    <input type="url" name="website" class="form-control" value="<?php if(set_value('website')){echo set_value('website');}else{ echo $website;}?>" id="website" placeholder="Enter your Website url"/>
                </div>
            </div>
            <div class="col-12 col-md-5 profile_form_div">
                <p class="text-center">Orders</p>
            </div>
            <div class="col-12 col-md-5 offset-md-1 profile_form_div">
                <p class="text-center">Wish-List</p>
            </div>
        </div>
        <div class = "row">
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-sm" value="Update" name="submit" />
            </div>
        </div>
    </form>
</div>
    <?php }  ?>