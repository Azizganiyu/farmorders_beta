<section class="store-banner">
    <div class="container">

    <div class="line"></div>
    <h2 class="title">Our Shop </h2>
    <h5 class="sub-title">Product Detail</h5>
    

</section>
<section>
<div class="container">
    <div class="row">
        <?php
        if($item != false)
        { ?>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-6 product-gallery">
                        <div class="image-preview">
                            <img src="<?php echo $item['product_image_url'] ?>" alt="No Image" />
                        </div>
                        <div class="thumbnails">
                            <div class="thumb active">
                                <img src="<?php echo $item['product_image_url'] ?>" alt="No Image" />
                            </div><?php
                            $gallery = explode('|',$item['product_gallery'] );
                            foreach($gallery as $src)
                            {
                                if(!empty($src))
                                {
                                    echo '<div class="thumb">';
                                    echo '<img src="'.$src.'" alt="No Image" />';
                                    echo '</div>';
                                }
                            }?>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 product-description">
                        <div class="box">
                            <h4 class="name"><?php echo $item['product_name'] ?> </h4>
                            <h4 class="price"><sup>&#8358;</sup><?php echo $item['price'] ?> <span> Free Delivery & returns </span> </h4>
                            <div class="divider"></div>
                            <?php
                            if($item['stock_status'] == 1)
                            {
                                $disabled = '';
                            }
                            else
                            {
                            $disabled = 'disabled';
                            }
                            ?>
                            <form action="<?php echo base_url ?>/index.php/store/cart" method="post">
                                <label> Quantity: </label>
                                <div>
                                    <button type="button" class="qty-btn plus">+</button><input type="text" name="quantity" class="qty-input" readonly="readonly" value="<?php
                                    if(array_key_exists($item['id'],$this->session->cart))
                                    {
                                        echo $this->session->cart[$item['id']]['quantity'];
                                    }
                                    else echo '1';
                                    ?>"><button type="button" class="qty-btn minus">-</button>
                                </div>

                                <input type="hidden" name="id" value="<?php echo $item['id'] ?>" /> <input type="hidden" name="status" value="1" /> <input type="hidden" name="price" value="<?php echo $item['price'] ?>" />

                                <div class="divider"></div>

                                <button type="submit" <?php echo $disabled ?> name="submit"  class="add-to-cart">Add to Cart</button>
                            </form>

                            <div class="divider"></div>

                            <p><label>Availability : </label>
                            <?php 
                            if ($item['stock_status'] == 1)
                            {
                                echo 'In Stock';
                            }
                            else
                            {
                                echo 'Out of Stock';
                            } 
                            ?></p>

                            <p><label>Owner : </label>
                            <?php echo $item['owner']; ?></p>

                            <p><label>Category : </label>
                            <?php 
                            $category = explode('|', $item['product_category']);
                            foreach($category as $list)
                            {
                                if(!empty($list))
                                {
                                    echo '<a href="'.base_url.'/index.php/store/products/'.$list.'">';
                                    echo $list;
                                    echo '</a> ';
                                    echo '| ';
                                }
                            } 
                            ?></p>

                           <div class="divider"></div>

                            <p class="description">
                                <?php echo $item['product_desc']; ?>
                            </p>

                            
                        </div>
                    </div>
                    <div class="col-12 review-header">
                        <h4> Reviews </h4>
                    </div>
                    <div class="col-12 col-md-8 reviews">
                    <?php
                    if($reviews != false)
                    {
                        foreach($reviews as $list)
                        {
                        ?>
                        <div class="row">
                            <div class="col-4 col-md-4">
                                <span class="name"><?php echo $list['name'];?></span>
                                <span class="date"><?php echo $list['date_added'];?></span>
                                <span>
                                <?php
                                if($list['rating'] == 'liked')
                                {
                                    echo '<i class="fa fa-thumbs-up"></i>';
                                }
                                elseif($list['rating'] == 'disliked')
                                {
                                    echo '<i class="fa fa-thumbs-down"></i>';
                                }
                                ?>
                                </span>
                            </div>
                            <div class="col-8 col-md-8 message">
                                <?php echo $list['comment'];?>
                            </div>
                        </div>
                        <?php
                        }
                    }
                    else
                    {
                        echo "<h5>Be the first to rate and comment on this product </h5>";
                    }
                    echo $links;
                    ?>
                    </div>
                    <div class="col-12 col-md-4 review-form">
                        <?php echo form_open('store/reviews/'); ?>
                            <p class="form_title"> Leave a Comment: </p>
                            <input type="hidden" name="id" value=" <?php echo $item['id']; ?> ">
                            <input type="hidden" name="p_name" value=" <?php echo $item['product_name']; ?> ">
                            <span class="text-danger"><?php echo form_error('name');?></span>
                            <input type="text" required name="name" placeholder="Your Name">
                            <span class="text-danger"><?php echo form_error('email');?></span>
                            <input type="text"  required name="email" placeholder="Your Email">
                            <span class="text-danger"><?php echo form_error('message');?></span>
                            <textarea name="comment" required placeholder="Your Message"></textarea>
                            <i class="fa fa-thumbs-up rating-up"> Like</i><i class="fa fa-thumbs-down"> Dislike</i>
                            <input type="hidden" class="rating-input" name="rating" value="liked" />
                            <button type="submit" name="submit" class="btn btn-md btn-dark">Submit</button>
                            <p class="submit-loader"></p>
                        </form>
                    </div>
                </div>
            </div>
        <?php
        }
        else
        {
            echo "No such item found";
        } 
        ?>
    </div>
</div> 