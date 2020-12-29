

<div class="wrap">

    <h2><?= __("Setup Travel Agents", "nextt")?></h2>

    <form method="POST" action="">
        <table class="form-table">


            <tr valign="top">
                <th>
                    <label for="booking"> <?=__('Booking', 'nextt')?> </label>
                </th>
                <td>
                    <p class="description"> <?=__('Booking http link. Example: http://www.booking.com/your_hotel_name', 'nextt')?> </p>
                    <input type="text" id="booking" name="booking" value="<?php echo Hotel_Travel_Agents::$view["booking"]; ?>" size="65" />
                </td>
            </tr>


            <tr valign="top">
                <th>
                    <label for="tripadvisor"> <?=__('TripAdvisor', 'nextt')?> </label><br>
                </th>
                <td>
                    <p class="description"> <?=__('TripAdvisor http link. Example: http://www.tripadvisor.com/your_hotel_name', 'nextt')?> </p>
                    <input type="text" id="tripadvisor" name="tripadvisor" value="<?php echo Hotel_Travel_Agents::$view["tripadvisor"]; ?>" size="65" />
                </td>
            </tr>


            <tr valign="top">
                <th>
                    <label for="trivago"> <?=__('Trivago', 'nextt')?> </label><br>
                </th>
                <td>
                    <p class="description"> <?=__('Trivago http link. Example: http://www.trivago.com/your_hotel_name', 'nextt')?> </p>
                    <input type="text" id="trivago" name="trivago" value="<?php echo Hotel_Travel_Agents::$view["trivago"]; ?>" size="65" />
                </td>
            </tr>


            <tr valign="top">
                <th>
                    <label for="agoda"> <?=__('Agoda', 'nextt')?> </label><br>
                </th>
                <td>
                    <p class="description"> <?=__('Agoda http link. Example: http://www.agoda.com/your_hotel_name', 'nextt')?> </p>
                    <input type="text" id="agoda" name="agoda" value="<?php echo Hotel_Travel_Agents::$view["agoda"]; ?>" size="65" />
                </td>
            </tr>


        </table>
        <p>
            <input name="<?=Hotel_Travel_Agents::$submit_button_name?>" type="submit" value="<?= __('Save Settings', 'nextt') ?>" class="button-primary"/>
        </p>
    </form>

</div>
