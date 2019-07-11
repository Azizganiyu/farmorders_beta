    <!-- Pull up button 
    ================================================ -->
    <div class="pull_up">
        <button class="btn btn-lg btn-danger"><i class="fa fa-arrow-circle-up"></i></button>
    </div>

    <!-- Footer 
    ================================================ -->
    <footer>
        <div class='top'>
            <div class='container'>
                <div class='row'>
                    <div class='col-12 col-md-3'>
                        <p class='footer-title'> Pages </p>
                        <ul>
                            <li><a href='<?php echo base_url; ?>/index.php/home'>Home</a></li>
                            <li><a href='<?php echo base_url; ?>/index.php/store'>Shop</a></li>
                            <li><a href='<?php echo base_url; ?>/index.php/blog'>Blog</a></li>
                            <li><a href='<?php echo base_url; ?>/index.php/page/about'>About</a></li>
                            <li><a href='<?php echo base_url; ?>/index.php/page/contact'>Contact</a></li>
                        </ul>
                    </div>
                    <div class='col-12 col-md-3'>
                        <p class='footer-title'> User section </p>
                        <ul>
                            <?php
                                if(isset($this->session->logged_in) && $this->session->logged_in == true)
                                {
                                    echo '<li><a href="'.base_url.'/index.php/account">Account</a></li>';
                                    echo '<li><a href="javascript:void(0)" onclick="logout()" >Logout</a></li>';
                                }
                                else
                                {
                                    echo '<li><a href="javascript:void(0)" onclick="register()" >Register</a></li>';
                                    echo '<li><a href="javascript:void(0)" onclick="login()" >Login</a></li>';
                                }   
                            ?>
                        </ul>
                    </div>
                    <div class='col-12 col-md-3'>
                        <p class='footer-title'> How to contact us </p>
                        <ul>
                            <li><span>Call us on any of these numbers</span></li>
                            <li><span>08123645460</span></li>
                            <li><span>07033968518</span></li>
                            <li><span>08079028695</span></li>
                        </ul>
                    </div>
                    <div class='col-12 col-md-3'>
                        <p class='footer-title'> Stay in touch</p>
                        <ul>
                            <li><a href="#" class="fab fa-facebook"></a></li>
                            <li><a href="https://instagram.com/farmorders_beta.com.ng" class="fab fa-instagram"></a></li>
                            <li><a href="#" class="fab fa-twitter"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class='middle'>
            <img class='img-fluid' src="<?php echo base_url; ?>/images/paystack-badge.png" />
        </div>
        <div class='bottom'>
            <div class='container'>
                <p>© 2019 Farmorders. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Java Script
    ================================================== -->
    <script src="<?php echo base_url; ?>/assets/javascript/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url; ?>/assets/javascript/jquery.form.min.js"></script>
    <script src="<?php echo base_url; ?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url; ?>/assets/javascript/main.script.js"></script>
    <script src="<?php echo base_url; ?>/assets/javascript/store.script.js"></script>
    <script src="<?php echo base_url; ?>/assets/plugins/jquery-modal-master/jquery.modal.js"></script>

</body>