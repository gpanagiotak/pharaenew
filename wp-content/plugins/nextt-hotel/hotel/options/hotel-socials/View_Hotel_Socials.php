

<div class="wrap">

	<h2><?= __("Setup Hotel Social Networks", "nextt")?></h2>

	<form method="POST" action="">
		<table class="form-table">


			<tr valign="top">
				<th>
					<label for="facebook"> <?=__('Facebook', 'nextt')?> </label>
				</th>
				<td>
					<p class="description"> <?=__('Facebook http link. Example: http://www.facebook.com/your_hotel_name', 'nextt')?> </p>
					<input type="text" id="facebook" name="facebook" value="<?php echo Hotel_Socials::$view["facebook"]; ?>" size="65" />
				</td>
			</tr>

			<tr valign="top">
				<th>
					<label for="twitter"> <?=__('Twitter', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('Twitter http link. Example: http://www.twitter.com/your_hotel_name', 'nextt')?> </p>
					<input type="text" id="twitter" name="twitter" value="<?php echo Hotel_Socials::$view["twitter"]; ?>" size="65" />
				</td>
			</tr>


			<tr valign="top">
				<th>
					<label for="instagram"> <?=__('Instagram', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('Instagram http link. Example: http://www.instagram.com/your_hotel_name', 'nextt')?> </p>
					<input type="text" id="instagram" name="instagram" value="<?php echo Hotel_Socials::$view["instagram"]; ?>" size="65" />
				</td>
			</tr>


			<tr valign="top">
				<th>
					<label for="linkedin"> <?=__('Linked in', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('Linked in http link. Example: http://www.linkedin.com/your_hotel_name', 'nextt')?> </p>
					<input type="text" id="linkedin" name="linkedin" value="<?php echo Hotel_Socials::$view["linkedin"]; ?>" size="65" />
				</td>
			</tr>


		</table>
		<p>
			<input name="<?=Hotel_Socials::$submit_button_name?>" type="submit" value="<?= __('Save Settings', 'nextt') ?>" class="button-primary"/>
		</p>
	</form>

</div>
