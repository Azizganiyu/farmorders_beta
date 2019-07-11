<section class="store-banner">
    <div class="container">

    <div class="line"></div>
    <h2 class="title">Our Shop </h2>
    <h5 class="sub-title"><?php echo $item_title; ?></h5>
    

</section>

<section class="search">
    <div class="container" id="search_form">
        <?php
        $attributes = array('class' => 'user_search_form');
        echo form_open('store/products/', $attributes);
        ?>
            <input class="search_box" type="text" value="<?php echo $search_key ?>" name="search_key" placeholder="Search">
            <button class="search_btn" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>  
</section>

<div class="container">
    <div class="row">
            <?php
            if($products != false)
            {
                foreach($products as $list)
                { 
                    $url_name = str_replace(" ", "_", $list['product_name']);
                ?>
                <div class="product_item col-md-4">
                    <div class="box">
                        <div class="image-wrapper">
                        <a href="<?php echo base_url.'/index.php/store/view_product/'.$url_name; ?>"><img src="<?php echo $list['product_image_url']; ?>" alt="No Image" /></a>
                        </div>
                        <h6 class="product_price">&#8358;<?php echo $list['price']; ?></h6>
                        <h4 class="product_name"><a href="<?php echo base_url.'/index.php/store/view_product/'.$url_name; ?>"><?php echo $list['product_name']; ?></a></h4>
                        <i class="fa fa-shopping-cart add-cart <?php
                        if(array_key_exists($list['id'], $_SESSION['cart']))
                        {
                            echo "carted";
                        }
                        ?>" status="<?php
                        if(array_key_exists($list['id'], $_SESSION['cart']))
                        {
                            echo "1";
                        }
                        else
                        {
                            echo "0";
                        }
                        ?>" id="<?php echo $list['id']; ?>" price="<?php echo $list['price']; ?>"></i>
                    </div>
                </div>
                
                <?php } 
            }
            else
            {
                echo "No Product Found!";
            }
            echo '<div class="col-12" style="margin-top:30px;">';
            echo $links;
            echo '</div>';
            ?>
    </div>
</div>