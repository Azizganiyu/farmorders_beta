<!DOCTYPE html>
<html class="no-js" lang="en">
<head>

    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    ================================================== -->
    <link href="<?php echo base_url; ?>/assets/web-fonts-with-css/css/fontawesome-all.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url; ?>/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>/assets/plugins/jquery-modal-master/jquery.modal.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>/assets/fonts.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>/assets/custom.css">

    <!-- script
    ================================================== -->
    <script src="<?php echo base_url; ?>/assets/javascript/modernizr-2.6.2.min.js"></script>
    <script src="js/pace.min.js"></script>

    <!-- favicons
    ================================================== -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

</head>

<body>

    <!-- preloader
    ================================================== -->
    <div id="loader-wrapper">
		<div id="loader"></div>

		<div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

	</div>
    <div id="login">
        <div class="login-wrapper">
            <a href="javascript:void(0)" class="closebtn" onclick="closeLogin()">&times;</a>
            <div class="google-login">
                <i class="fab fa-google"></i> <span>Continue with google</span>
            </div>
            <p class="form-divider">or</p>
            <form action="<?php echo base_url; ?>/index.php/users/login" method="post">
                <div>
                    <label for="name">Username or Email</label>
                    <input required class="form-control" name="id" id="name" type="text">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input  class="form-control" required name="password" id="password" type="password">
                </div>
                <div class="remember">
                    Remember me <input  name="remember" value="yes" id="password" type="checkbox">
                </div>
                <button type="submit"  class="btn btn-success text-center">Sign-in</button>
            </form> 
            <p id="login-info" style="color:rgb(160, 18, 18);"></p>
            <p>Not yet a user? <span style="color:rgb(12, 180, 12); cursor:pointer;" class="register-link" >register</span></p>
            <p class="forgot-password"><a style="color: rgb(0, 0, 0);" href="#">Forgotten password</a></p>
        </div>
    </div>

    <div id="register"> 
        <div class="register-wrapper">
            <a href="javascript:void(0)" class="closebtn" onclick="closeRegister()">&times;</a>
            <div class="google-login">
                <i class="fab fa-google"></i> <span>Continue with google</span>
            </div>
            <p class="form-divider">or</p>
            <form action="<?php echo base_url; ?>/index.php/users/new_user" method="post">
                <div>
                    <label for="username">Username</label>
                    <input class="form-control" name="username" id="username" type="text">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input class="form-control" name="email" id="email" type="email">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input class="form-control" name=password id="password" type="password">
                </div>
                <button type="submit" name="submit" class="btn btn-primary text-center">Create account</button>
            </form>
            <p id="register-info" style="color:rgb(160, 18, 18);"></p>
            <p>Already a member? <span style="color:rgb(12, 180, 12); cursor:pointer;" class="login-link" >login</span></p>
        </div>
    </div>

    <!-- header 
    ================================================== -->
    <header class="s-header">

    <?php
        define('PAGE', $page);
        function is_active($current_page)
        {
            if($current_page == PAGE){
            echo "active";
            }
        }
    ?>
    <div id="search">
                <div class="main-search">
                    <input type="search" name="main_search" placeholder="Search site here">
                    <div id="search_close"><i class="fa fa-window-close"></i></div> 
                </div>
    </div>
    <div class="container">
        <div class="row">

            <div class="site_id">
                <div class="header-logo">
                    <a class="site-logo" href="home">
                        <img src="<?php echo base_url; ?>/images/logo8.png" alt="Homepage">
                    </a>
                </div>
            </div>
    
            <div class="nav">

                <nav class="main-header-nav-wrap">
                    <ul class="header-main-nav">
                        <li class="<?php is_active('home');?>"><a class="" href="<?php echo base_url; ?>/index.php/home" title="home">Home</a></li>
                        <li class="<?php is_active('store');?>"><a class="" href="<?php echo base_url; ?>/index.php/store" title="shop">Shop</a></li>
                        <li class="<?php is_active('blog');?>"><a class="" href="<?php echo base_url; ?>/index.php/blog" title="blog">Blog</a></li>
                        <li class="<?php is_active('about');?>"><a class="" href="<?php echo base_url; ?>/index.php/page/about" title="about">About</a></li>
                        <li class="<?php is_active('contact');?>"><a class="" href="<?php echo base_url; ?>/index.php/page/contact" title="contact">Contact</a></li>	
                    </ul>

                    <!-- Search btn -->
                    <div class="search-btn">
                        <a id="search-btn" href="javascript:void(0)"><i class="fa fa-search" aria-hidden="true"></i> Search</a>
                    </div>
                    <!-- Signin btn -->
                    <div class="signin-btn">
                    <?php
                        if(isset($this->session->logged_in) && $this->session->logged_in == true)
                        {
                            echo '<a href="'.base_url.'/index.php/account">Account</a>';
                            echo '<a href="javascript:void(0)" onclick="logout()" >Logout</a>';
                        }
                        else
                        {
                            echo '<a href="javascript:void(0)" onclick="login()" >Sign in  or Register</a>';
                        }   
                    ?>
                    </div>
                    <!-- cart btn -->
                    <div class="cart-btn">
                        <a href="<?php echo base_url; ?>/index.php/store/view_cart"><i class="fa fa-shopping-cart"></i></a><span class=" cart-no qty"><?php  echo count($_SESSION['cart']);?></span>
                    </div>
                   
                </nav> <!-- end header-nav-wrap -->

            </div>

            <div class="mobile-menu">

                <div class="cart-btn">
                        <a href="<?php echo base_url; ?>/index.php/store/view_cart"><i class="fa fa-shopping-cart"></i></a><span class=" cart-no qty"><?php  echo count($_SESSION['cart']);?></span>
                </div>

                <div class="menu-toggle">
                    <button type="button" class="toggle-btn" ><i class="fa fa-bars"></i></button>
                </div>


                <nav class="header-nav-wrap">
                    <ul class="header-main-nav">
                        <li class="<?php is_active('home');?>"><a class="" href="<?php echo base_url; ?>/index.php/home" title="home">Home</a></li>
                        <li class="<?php is_active('store');?>"><a class="" href="<?php echo base_url; ?>/index.php/store" title="shop">Shop</a></li>
                        <li class="<?php is_active('blog');?>"><a class="" href="<?php echo base_url; ?>/index.php/blog" title="blog">Blog</a></li>
                        <li><a class="" href="<?php echo base_url; ?>/index.php/page/about" title="about">About</a></li>
                        <li><a class="" href="<?php echo base_url; ?>/index.php/page/contact" title="contact">Contact</a></li>
                        <hr style="border: 1px solid white;">
                        <!-- Signin btn -->
                        <?php
                            if(isset($this->session->logged_in) && $this->session->logged_in == true)
                            {
                                echo '<li><a href="'.base_url.'/index.php/account">Account</a></li>';
                                echo '<li><a href="javascript:void(0)" onclick="logout()" >Logout</a></li>';
                            }
                            else
                            {
                                echo '<li><a href="javascript:void(0)" onclick="login()" >Login</a></li> ';
                            }   
                        ?>
                    </ul>
                </nav> <!-- end header-nav-wrap -->

            </div>

        </div>

    </header> <!-- end header -->
