

<div class="wrap">

     <h2>Hotel Setup</h2>

    <form method="POST" action="">
        <table class="form-table">

            <tr valign="top">
                <th scope="row">
                    <label for="hotel_title"> <?=__('Title', 'nextt')?> </label>
                </th>
                <td>
                    <p class="description"> <?=__('Title', 'nextt')?></p>
                    <input type="text" name="hotel_title" value="<?php echo Hotel_Setup::$view["hotel_title"]; ?>" size="65" />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">
                    <label for="hotel_logo"> <?=__('Hotel Logo', 'nextt')?> </label>
                </th>
                <td>
                    <p class="description"> <?=__('Hotel Logo', 'nextt')?> </p>
                    <img class="hotel_logo_img" height="150" width="150" src="<?php echo Hotel_Setup::$view["hotel_logo"]; ?>">
                    <br>
                    <button type="button" class="hotel_logo_button button-primary" > <?= __('Select Hotel Logo', 'nextt') ?>  </button>
                    <input type="hidden" class="media_win media_logo_val" name="hotel_logo" value="<?php echo Hotel_Setup::$view["hotel_logo"]; ?>" size="65" />
                </td>
            </tr>

<!--            <tr valign="top">-->
<!--                <th>-->
<!--                    <label for="hotel_title"> --><?//=__('Latitude', 'nextt')?><!-- </label><br>-->
<!--                    <label for="hotel_title"> --><?//=__('Longitude', 'nextt')?><!-- </label>-->
<!--                </th>-->
<!--                <td>-->
<!--                    <p class="description"> --><?//=__('Latitude', 'nextt')?><!-- </p>-->
<!--                    <input type="text" name="hotel_lat" value="--><?php //echo Hotel_Setup::$view["hotel_lat"]; ?><!--" size="65" />-->
<!---->
<!--                    <p class="description"> --><?//=__('Longitude', 'nextt')?><!-- </p>-->
<!--                    <input type="text" name="hotel_long" value="--><?php //echo Hotel_Setup::$view["hotel_long"]; ?><!--" size="65" />-->
<!--                </td>-->
<!--            </tr>-->

            <tr valign="top">
                <th scope="row">
                    <label for="hotel_address"><?=__('Address', 'nextt')?></label>
                </th>
                <td>
                    <p class="description"><?=__('Address', 'nextt')?></p>
                    <input type="text" name="hotel_address" value="<?php echo Hotel_Setup::$view["hotel_address"]; ?>" size="65" />
                </td>
            </tr>


            <tr valign="top">
                <th scope="row">
                    <label for="hotel_link_to_map"><?=__('Map Link', 'nextt')?></label>
                </th>
                <td>
                    <p class="description"><?=__('Map Link', 'nextt')?></p>
                    <input type="text" name="hotel_link_to_map" value="<?php echo Hotel_Setup::$view["hotel_link_to_map"]; ?>" size="65" />
                </td>
            </tr>


            <tr valign="top">
                <th scope="row">
                    <label for="hotel_tel_1"><?=__('Telephones', 'nextt')?></label>
                </th>
                <td>
                    <p class="description"><?=__('Tel', 'nextt')?> 1:</p>
                    <input type="text" name="hotel_tel_1" value="<?php echo Hotel_Setup::$view["hotel_tel_1"]; ?>" size="65" />

                    <p class="description"><?=__('Tel', 'nextt')?> 2:</p>
                    <input type="text" name="hotel_tel_2" value="<?php echo Hotel_Setup::$view["hotel_tel_2"]; ?>" size="65" />

                    <p class="description"><?=__('Tel', 'nextt')?> 3:</p>
                    <input type="text" name="hotel_tel_3" value="<?php echo Hotel_Setup::$view["hotel_tel_3"]; ?>" size="65" />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">
                    <label for="hotel_fax_1"><?=__('Fax', 'nextt')?> </label>
                </th>
                <td>
                    <p class="description"><?=__('Fax', 'nextt')?> 1:</p>
                    <input type="text" name="hotel_fax_1" value="<?php echo Hotel_Setup::$view["hotel_fax_1"]; ?>" size="65" />

                    <p class="description"><?=__('Fax', 'nextt')?> 2:</p>
                    <input type="text" name="hotel_fax_2" value="<?php echo Hotel_Setup::$view["hotel_fax_2"]; ?>" size="65" />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">
                    <label for="hotel_email_1"><?=__('Email', 'nextt')?></label>
                </th>
                <td>
                    <p class="description"><?=__('Email', 'nextt')?>  1:</p>
                    <input type="text" name="hotel_email_1" value="<?php echo Hotel_Setup::$view["hotel_email_1"]; ?>" size="65" />

                    <p class="description"><?=__('Email', 'nextt')?>  2:</p>
                    <input type="text" name="hotel_email_2" value="<?php echo Hotel_Setup::$view["hotel_email_2"]; ?>" size="65" />
                </td>
            </tr>



            <tr valign="top">
                <th scope="row">
                    <label for="hotel_gnto"><?=__('MHTE', 'nextt')?></label>
                </th>
                <td>
                    <p class="description"><?=__('MHTE', 'nextt')?></p>
                    <input type="text" name="hotel_gnto" value="<?php echo Hotel_Setup::$view["hotel_gnto"]; ?>" size="65" />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">
                    <label for="hotel_copyright"><?=__('Copyright', 'nextt')?></label>
                </th>
                <td>
                    <p class="description"><?=__('Copyright', 'nextt')?></p>
                    <input type="text" name="hotel_copyright" value="<?php echo Hotel_Setup::$view["hotel_copyright"]; ?>" size="65" />
                </td>
            </tr>



            <tr valign="top">
                <th scope="row">
                    <label for="hotel_short_description"><?=__('Short Description', 'nextt')?></label>
                </th>
                <td>
                    <p class="description"><?=__('Short Description', 'nextt')?>  </p>
                    <textarea cols="65" rows="7" name="hotel_short_description"><?php echo Hotel_Setup::$view["hotel_short_description"]; ?> </textarea>
                </td>
            </tr>


        </table>
        <p>
            <input name="save_hotel_setup" type="submit" value="<?= __('Save Settings', 'nextt') ?>" class="button-primary"/>
        </p>
    </form>

</div>
