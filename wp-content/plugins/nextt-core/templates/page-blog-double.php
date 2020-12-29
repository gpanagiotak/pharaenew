<?php
/*
Template Name: Page: Blog Page Double
*/
?>

<?php get_header(); ?>
<?php get_template_part( 'interfaces/headers/header2' ); ?>

<div class="container">

    <div class="row">

        <?php
        // the query to set the posts per page to 3
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array('paged' => $paged, 'post_type' => 'post', );
        query_posts($args); ?>
        <!-- the loop -->
        <?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
            <div class="col-md-6 page-blog-double post-<?=the_ID()?>">

                <?php
                if ( has_post_thumbnail() ) {
                    $att_img_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full-size')[0];
                    ?> <img class="img-responsive" src="<?=$att_img_url?>"><?php
                }else{
                    $att_img_url= null;
                }

                ?>

                <h2 class="page-blog-double-title">
                    <a class="post_title" href="<?= the_permalink(); ?>"><?= get_the_title();?></a>
                    <br>
                    <small class="the_date">
                        <span class="post-month"><?php the_time('F');?></span>
                        <span class="post-day"><?php the_time('j');?></span>
                        <span class="post-year"><?php the_time('Y');?></span>
                    </small>
                </h2>

                <?php
                $content = get_the_content();
                $content = apply_filters('the_content', $content );
                echo $content;
                ?>


            </div>

        <?php endwhile; ?>
            <!-- pagination -->
            <?php next_posts_link(); ?>
            <?php previous_posts_link(); ?>
        <?php else : ?>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>