<?php get_header(); ?>
<?php get_template_part('interfaces/headers/header2'); ?>


<div style="height: 500px; clear: both;"></div>
<div class="room-container">

    <?php if(have_posts()) : while (have_posts()) : the_post(); ?>

        <!-- THUMBNAIL -->
        <?php if ( has_post_thumbnail() ): $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail_size' );
            $url = $thumb['0'] ?>
            <img src="<?= $url ?>" class="img-responsive" width="100%" height="100%">
        <?php endif; ?>

        <img src="<?= nextt_hotel_get_room_info(get_the_ID())['room_image'][0] ?>">

        <div class="room-post-title-box">
            <h1 class="room-post-title">
                <?= get_the_title() ?>
            </h1>
            <div class="room-page-title">
                <div class="room-page-title-text">
                    <?= nextt_hotel_get_room_info(get_the_ID())['room_title'][0] ?>
                </div>
                <div class="room-page-subtitle-text">
                    <?= nextt_hotel_get_room_info(get_the_ID())['room_subtitle'][0] ?>

                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="room-content entry">
                <?php the_content(); ?>
                <?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number',)); ?>
            </div>
        </article>

        <div class="room-facilities">
            <?php foreach (nextt_hotel_get_room_info(get_the_ID()) as $facility): ?>
                <?= $facility['description']; ?>
                <?= $facility['text']; ?>
            <?php endforeach; ?>
        </div>

        <?=
        do_shortcode('[wally cover="http://localhost/nextt/wp-content/uploads/2015/06/Santorini-Greece-low.jpg" category="'.nextt_hotel_get_room_info( $the_query->post->ID )['room_gallery'][0] .'" button="asdf" display="categories" ][/wally]');
//        do_shortcode('[wally cover="http://localhost/nextt/wp-content/uploads/2015/06/Santorini-Greece-low.jpg" category="'.Getter::get_room_info( $the_query->post->ID )['room_gallery'][0] .'" button="asdf" display="block" ][/wally]');
        ?>

    <?php endwhile; endif; ?>
    <?php wp_reset_postdata(); ?>


    <?php $args= array('post_type' => array( 'room' ),'order' => 'ASC');$the_query = new WP_Query( $args ); ?>

    <?php while ( $the_query->have_posts() ): ?>

        <?php $the_query->the_post(); ?>

        <a href="<?= get_permalink() ?>">

            <!-- THUMBNAIL -->
            <?php if ( has_post_thumbnail() ): $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $the_query->post->ID ), 'thumbnail_size' );
                $url = $thumb['0'] ?>
                <img src="<?= $url ?>" class="img-responsive" width="100%" height="100%">
            <?php endif; ?>

            <h1><?= $post->post_title ?></h1>
            <!-- TITLE AND SUBTITLE -->
            <h2>
                <?= nextt_hotel_get_room_info( $the_query->post->ID )['room_title'][0] ?>
                <small>
                    <?= nextt_hotel_get_room_info( $the_query->post->ID )['room_subtitle'][0] ?>
                </small>
            </h2>
        </a>

        <!-- IMAGE -->
        <img src="<?= nextt_hotel_get_room_info( $the_query->post->ID )['room_image'][0] ?>"
             class="img-responsive">


    <?php endwhile; ?>


    <?php wp_reset_postdata(); ?>


</div>


<?php get_footer() ?>

<?php

// ROOM INFO
echo "<pre>";
//print_r(nextt_hotel_get_room_info(the_ID()));
echo "</pre>";

// ROOM FACILITIES
//echo "<pre>";
//print_r(Getter::get_room_facilities(the_ID()));
//echo "</pre>";


?>
