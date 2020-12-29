

<div class="wrap">

	<h2><?= __("Google Setup", "nextt")?></h2>

	<form method="POST" action="">
		<table class="form-table">


            <tr valign="top">
                <th>
                    <label for="hotel_title"> <?=__('Latitude', 'nextt')?> </label><br>
                    <label for="hotel_title"> <?=__('Longitude', 'nextt')?> </label>
                </th>
                <td>
                    <p class="description"> <?=__('Latitude', 'nextt')?> </p>
                    <input type="text" name="hotel_google_lat" value="<?php echo Hotel_Google_Setup::$view["hotel_google_lat"]; ?>" size="65" />

                    <p class="description"> <?=__('Longitude', 'nextt')?> </p>
                    <input type="text" name="hotel_google_long" value="<?php echo Hotel_Google_Setup::$view["hotel_google_long"]; ?>" size="65" />
                </td>
            </tr>

			<tr valign="top">
				<th scope="row">
					<label for="hotel_address"><?=__('Analytics Key', 'nextt')?></label>
				</th>
				<td>
					<p class="description"><?=__('Analytics Key', 'nextt')?></p>
					<input type="text" name="hotel_google_analytics" value="<?php echo Hotel_Google_Setup::$view["hotel_google_analytics"]; ?>" size="65" />
				</td>
			</tr>




		</table>
		<p>
			<input name="<?=Hotel_Google_Setup::$submit_button_name?>" type="submit" value="<?= __('Save Settings', 'nextt') ?>" class="button-primary"/>
		</p>
	</form>

</div>
