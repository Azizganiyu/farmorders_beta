<?php
if(!empty($post['post_image_url']))
{ ?>
    <style>
        section.blog-view{
            background-image: linear-gradient( rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('<?php echo $post['post_image_url'] ?>');
            background-size:cover;
            background-repeat:no-repeat;
            background-position: center, center;
            height: auto;
        }
    </style>
<?php } ?>
<section class="blog-view">
    <div class="container">
        <div class="single_post">
        <?php

        if($post != false)
        {
            if(!empty($post['tags']))
            {
                $tags = explode(',', $post['tags']);
                echo '<p class="tags">Tags: ';
                foreach($tags as $tags)
                {
                    echo '<a href="'.base_url.'/index.php/blog/posts/'.$tags.'">'.strtoupper($tags).'</a> ';
                }
                echo '</p>';
            }
            echo '<p class="title">'.$post['post_title'].'</p>';
            echo '<p class="date">'.date('M d, Y',strtotime($post['post_date'])).'</P>';
            echo '<p class="author"><span class="by">by </span>'.$post['post_author'].'</P>';
            echo '<div class="post-image"><img src="'.$post['post_image_url'].'" alt=" " /></div>';
        }
        ?>
        </div>
    </div>
</section>

<section>
    <div class="container" id="single_post_body">
        <?php echo $post['post_body']; ?>
    </div>
</section>

<div class="container" id="nav_post">
    <div class="row">
        
            <?php 
            if($prev_post != false)
            {
                echo '<div class="prev_post col-12 col-sm-6 col-md-4">';
                echo '<span><a href="'.base_url.'/index.php/blog/view/'.$prev_post['id'].'"> Previous Post </a></span>';
                echo '<p><a class="title" href="'.base_url.'/index.php/blog/view/'.$prev_post['id'].'">'.$prev_post['post_title'].'</a></p>';
                echo '</div>';
            }
             
            if($next_post != false)
            {
                echo '<div class="next_post col-12 col-sm-6 col-md-4">';
                echo '<span><a href="'.base_url.'/index.php/blog/view/'.$next_post['id'].'"> Next Post </a></span>';
                echo '<p><a class="title" href="'.base_url.'/index.php/blog/view/'.$next_post['id'].'">'.$next_post['post_title'].'</a></p>';
                echo '</div>';
            }
            ?> 
        <div class="view all_btnt col-12 col-sm-6 col-md-4">
        <a href="<?php echo base_url; ?>/index.php/blog" ><button class="btn btn-lg btn-outline-dark">View All Post </button></a>
        </div>
    </div>
</div>
<div  class="container-fluid" id="comment">
    <div class="container comments">
    <?php
    if ($comments != false)
    {
        foreach($comments as $comment)
        {
            echo '<div class="row">';
            echo '<div class="col-2 col-md-1">';
            echo '<p><img src="'.$comment['image_url'].'"/></p>';
            echo '</div>';
            echo '<div class="col-10 col-md-11">';
            echo '<span class="comment_name">'.$comment['name'].'</span>';
            echo '<span class="comment_date">'.date('M d, Y @ H:m',strtotime($comment['date'])).'</span>';
            echo '<p class="comment_message">'.$comment['message'].'</p>';
            echo '</div>';
            echo '</div>';
        }
    }
    else
    {
        echo "Be the first to comment on this";
    }
    ?>
    </div>
    <div class="container forms">
        <?php echo form_open('blog/view/'.$post['id']); ?>
            <p class="form_title"> Leave a Comment </p>
            <input type="hidden" name="id" value="<?php echo $post['id']; ?> ">
            <input type="hidden" name="parent_id" value="0">
            <span class="text-danger"><?php echo form_error('name');?></span>
            <input type="text" required name="name" placeholder="Your Name">
            <span class="text-danger"><?php echo form_error('email');?></span>
            <input type="text"  required name="email" placeholder="Your Email">
            <input type="text" name="website" placeholder="Your Website">
            <span class="text-danger"><?php echo form_error('message');?></span>
            <textarea name="message" required placeholder="Your Message"></textarea>
            <button type="submit" name="submit_comment" class="btn btn-md btn-dark">Submit</button>
        </form>
    </div>
</div>