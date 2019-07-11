<section class="blog-banner">
    <div class="container">

        <div class="line"></div>
        <h2 class="title">Our Blog</h2>
        <h5 class="sub-title">Top feeds</h5>

        <div class="featured_post">
        <?php

            if($featured != false && (empty($search_key) && empty($tag_filter)) )
            {
                $url_name = str_replace(" ", "_", $featured['post_title']);
                $tags = explode(',', $featured['tags']);
                echo '<p><span class="tags">';
                foreach($tags as $tags)
                {
                    echo '<a href="'.base_url.'/index.php/blog/posts/'.$tags.'">'.strtoupper($tags).'</a> ';
                }
                echo '</span><span class="date">'.date('M d, Y',strtotime($featured['post_date'])).'</span></P>';
                echo '<img class="img-fluid  featured_img" src="'.$featured['post_image_url'].'" width="300"  />';
                echo '<p class="title"><a href="'.base_url.'/index.php/blog/view/'.$url_name.'">'.$featured['post_title'].'</a></p>';
                echo '<p class="desc">'.substr(strip_tags($featured['post_body']),0, 250).'...</p>';
                echo '<p class="read_more"><a href="'.base_url.'/index.php/blog/view/'.$url_name.'"><button class="btn btn-lg btn-outline-light">Read More </button></a>';
            }
            elseif(!empty($search_key))
            {
                echo '<p class="title"><a>Search Result For - "'.$search_key.'"</a></p>';
            }
            elseif(!empty($tag_filter))
            {
                echo '<p class="title"><a>Tag Search Result For - "'.strtoupper($tag_filter).'"</a></p>';
            }
            else
            {
                echo '<p class="title"><a>Viewing All Posts</a></p>';
            }

        ?>
        </div>
    </div>
</section> <!-- end s-download -->

<section class="search">
    <div class="container" id="search_form">
        <?php
        $attributes = array('class' => 'user_search_form');
        echo form_open('blog/posts/', $attributes);
        ?>
            <input class="search_box" type="text" value="<?php echo $search_key ?>" name="search_key" placeholder="Search">
            <button class="search_btn" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>  
</section>


<div class="container" id="posts">
    <div class="row">
        <?php 
        if($post != false)
        {
            foreach($post as $post)
            { 
                $url_name = str_replace(" ", "_", $post['post_title']);
                echo '<div class="col-md-4 post_list">';
                echo '<div class="box">';
                echo '</span><span class="date">'.date('M d, Y',strtotime($post['post_date'])).'</span></P>';
                echo '<p  class="title"><a href="'.base_url.'/index.php/blog/view/'.$url_name.'">'.$post['post_title'].'</a><p>';
                echo '<div class="col-4"><hr /></div>'; 
                echo '<div class="image-wrapper"><img class="img-fluid  featured_img" src="'.$post['post_image_url'].'"/></div>';
                echo '<p class="desc">'.substr(strip_tags($post['post_body']),0, 200).'...</p>';

                $tags = explode(',', $post['tags']);

                echo '<p class="tags">';
                if(!empty($post['tags']))
                {
                    foreach($tags as $tags)
                    {
                        echo '<span class="badge badge-dark"><a href="'.base_url.'/index.php/blog/posts/'.$tags.'">'.strtoupper($tags).'</a></span>';
                    }
                }
                echo '</p>';
                echo '<div class="read-more-btn">';
                echo '<a href="'.base_url.'/index.php/blog/view/'.$url_name.'"> <button class="btn btn-outline-dark btn-sm"> READ MORE </button> </a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        else
        {
            echo '<div class="col-md-6 post_list">';
            echo "No Post Found!";
            echo '</div>';
        }
        ?>
    </div>
    <?php echo $links; ?>
</div>