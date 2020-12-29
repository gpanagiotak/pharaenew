<?php
/*
Template Name: Page: Inner Horizontal Line
*/
?>

<?php get_header(); ?>
<?php get_template_part( 'interfaces/headers/header2' ); ?>
<?php get_template_part( 'interfaces/titles/full-title-image' ); ?>

<div class="container horizontal-line">

    <div class="page-horizontal-line-title">

        <?php if(get_post_meta( get_the_ID(), 'sub_title_inner', true )): ?>

            <h2><?=get_post_meta( get_the_ID(), 'sub_title_inner', true );?></h2>

        <?php else: ?>

            <h2><?php the_title() ?></h2>

        <?php endif; ?>

    </div>
    <hr class="hr_normal">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry">
                <?php the_content(); ?>
                <?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
            </div>
        </article>
    <?php endwhile; endif; ?>



</div>


<?php get_footer(); ?>
