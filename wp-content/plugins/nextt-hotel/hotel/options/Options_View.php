<div id="wpbody" role="main">

    <div id="wpbody-content" aria-label="Main content" tabindex="0">

        <div class="wrap">

            <h2> <?= __('Hotel Connect', 'nextt') ?>    </h2>

            <?php if (Getter::get_hotel_facilities()): ?>
            <?php else: ?>
            <?php endif; ?>


            <div class="theme-browser rendered">

                <div class="themes">

                    <div
                        <?php if (Getter::get_hotel_options()): ?>
                            class="theme"
                        <?php else: ?>
                            class="theme active"
                        <?php endif; ?>
                        tabindex="0">

                        <div class="theme-screenshot">
                            <img src="<?=get_stylesheet_directory_uri()."/screenshot.png"?>" alt="">
                        </div>

                        <span class="more-details" id="Nextt-Child-action"> <?= __('Hotel Setup', 'nextt') ?> </span>


                        <?php if (Getter::get_hotel_options()): ?>

                            <h3 class="theme-name nextt_active_done">
                                <span><?= __('Complete', 'nextt') ?>:</span> <?= __('Step', 'nextt') ?> 1


                            </h3>

                            <div class="theme-actions">
                                <a class="button button-default"
                                   href="<?= get_admin_url(null, 'admin.php?page=hotel_setup', null) ?>">
                                    <?= __('Edit', 'nextt') ?>
                                </a>
                            </div>

                        <?php else: ?>

                            <h3 class="theme-name nextt_active_incomplete">
                                <span><?= __('Incomplete', 'nextt') ?>:</span> <?= __('Step', 'nextt') ?> 1
                            </h3>


                            <div class="theme-actions nextt_theme_options_boxes">

                                <a class="button button-secondary customize load-customize hide-if-no-customize"
                                   href="<?= get_admin_url(null, 'admin.php?page=hotel_setup', null) ?>">
                                    <?= __('Complete', 'nextt') ?>
                                </a>

                            </div>
                        <?php endif; ?>
                    </div>


                    <div
                        <?php if (Getter::get_hotel_facilities()): ?>
                            class="theme"
                        <?php else: ?>
                            class="theme active"
                        <?php endif; ?>
                        tabindex="0">

                        <div class="theme-screenshot">
                            <img src="<?=get_stylesheet_directory_uri()."/screenshot.png"?>" alt="">
                        </div>

                        <span class="more-details"
                              id="Nextt-Child-action"> <?= __('Hotel Facilities', 'nextt') ?> </span>


                        <?php if (Getter::get_hotel_facilities()): ?>

                            <h3 class="theme-name nextt_active_done">
                                <span><?= __('Complete', 'nextt') ?>:</span> <?= __('Step', 'nextt') ?> 2
                            </h3>

                            <div class="theme-actions">

                                <a class="button button-default"
                                   href="<?= get_admin_url(null, 'admin.php?page=hotel_facilities', null) ?>">
                                    <?= __('Edit', 'nextt') ?>
                                </a>
                            </div>
                        <?php else: ?>
                            <h3 class="theme-name nextt_active_incomplete">
                                <span><?= __('Incomplete', 'nextt') ?>:</span> <?= __('Step', 'nextt') ?> 2
                            </h3>


                            <div class="theme-actions nextt_theme_options_boxes">

                                <a class="button button-secondary customize load-customize hide-if-no-customize"
                                   href="<?= get_admin_url(null, 'admin.php?page=hotel_facilities', null) ?>">
                                    <?= __('Complete', 'nextt') ?>
                                </a>

                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (class_exists(Nextt_Hotel_Room_Type\Room_Types_Manager::class)): ?>

                        <?php
                        $room_type_params = array(
                            'post_type' => array(\Nextt_Hotel_Room_Type\Room_Types_Manager::$post_type_key),
                            'order' => 'ASC'
                        );
                        $room_type_posts = new WP_Query($room_type_params);
                        ?>

                        <div
                            <?php if ($room_type_posts->have_posts()): ?>
                                class="theme"
                            <?php else: ?>
                                class="theme active"
                            <?php endif; ?>
                            tabindex="0">

                            <div class="theme-screenshot">
                                <img src="<?=get_stylesheet_directory_uri()."/screenshot.png"?>" alt="">
                            </div>

                            <span class="more-details" id="Nextt-Child-action"> <?= __('Room Types', 'nextt') ?> </span>


                            <?php if ($room_type_posts->have_posts()): ?>

                                <h3 class="theme-name nextt_active_done">
                                    <span><?= __('Complete', 'nextt') ?>:</span> <?= __('Step', 'nextt') ?> 3
                                </h3>

                                <div class="theme-actions">
                                    <a class="button button-default"
                                       href="<?= get_admin_url(null, 'edit.php?post_type=room', null) ?>">
                                        <?= __('Edit', 'nextt') ?>
                                    </a>
                                </div>

                            <?php else: ?>

                                <h3 class="theme-name nextt_active_incomplete">
                                    <span><?= __('Incomplete', 'nextt') ?>:</span> <?= __('Step', 'nextt') ?> 3
                                </h3>


                                <div class="theme-actions nextt_theme_options_boxes">

                                    <a class="button button-secondary customize load-customize hide-if-no-customize"
                                       href="<?= get_admin_url(null, 'edit.php?post_type=room', null) ?>">
                                        <?= __('Complete', 'nextt') ?>
                                    </a>

                                </div>

                            <?php endif; ?>
                        </div>

                    <?php endif; ?>

                </div>


            </div>

            <br class="clear"></div>

        <div class="theme-overlay"></div>

    </div>
    <!-- .wrap -->


    <div class="clear"></div>
</div>
<!-- wpbody-content -->
<div class="clear"></div>
</div>
