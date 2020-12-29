

<div class="wrap">

	<h2><?= __("Setup Hotel Distances", "nextt")?></h2>

	<form method="POST" action="">
		<table class="form-table">


			<tr valign="top">
				<th>
					<label for="bakery"> <?=__('Bakery', 'nextt')?> </label>
				</th>
				<td>
					<p class="description"> <?=__('Bakery', 'nextt')?> </p>
					<input type="text" id="bakery" name="bakery" value="<?php echo Hotel_Distances::$view["bakery"]; ?>" size="65" />
				</td>
			</tr>

			<tr valign="top">
				<th>
					<label for="pharmacy"> <?=__('Pharmacy', 'nextt')?> </label>
				</th>
				<td>
					<p class="description"> <?=__('Pharmacy', 'nextt')?> </p>
					<input type="text" id="pharmacy" name="pharmacy" value="<?php echo Hotel_Distances::$view["pharmacy"]; ?>" size="65" />
				</td>
			</tr>

			<tr valign="top">
				<th>
					<label for="health_center"> <?=__('Health Center', 'nextt')?> </label>
				</th>
				<td>
					<p class="description"> <?=__('health Center', 'nextt')?> </p>
					<input type="text" id="health_center" name="health_center" value="<?php echo Hotel_Distances::$view["health_center"]; ?>" size="65" />
				</td>
			</tr>

			<tr valign="top">
				<th>
					<label for="dentist"> <?=__('Dentist', 'nextt')?> </label>
				</th>
				<td>
					<p class="description"> <?=__('Dentist', 'nextt')?> </p>
					<input type="text" id="dentist" name="dentist" value="<?php echo Hotel_Distances::$view["dentist"]; ?>" size="65" />
				</td>
			</tr>

			<tr valign="top">
				<th>
					<label for="grocery_store"> <?=__('Grocery Store', 'nextt')?> </label>
				</th>
				<td>
					<p class="description"> <?=__('Grocery Store', 'nextt')?> </p>
					<input type="text" id="grocery_store" name="grocery_store" value="<?php echo Hotel_Distances::$view["grocery_store"]; ?>" size="65" />
				</td>
			</tr>

			<tr valign="top">
				<th>
					<label for="super_market"> <?=__('Super Market', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('Super Market', 'nextt')?> </p>
					<input type="text" id="super_market" name="super_market" value="<?php echo Hotel_Distances::$view["super_market"]; ?>" size="65" />
				</td>
			</tr>


			<tr valign="top">
				<th>
					<label for="restaurant"> <?=__('Restaurant', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('Restaurant', 'nextt')?> </p>
					<input type="text" id="restaurant" name="restaurant" value="<?php echo Hotel_Distances::$view["restaurant"]; ?>" size="65" />
				</td>
			</tr>


			<tr valign="top">
				<th>
					<label for="city_center"> <?=__('City Center', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('City Center', 'nextt')?> </p>
					<input type="text" id="city_center" name="city_center" value="<?php echo Hotel_Distances::$view["city_center"]; ?>" size="65" />
				</td>
			</tr>

			<tr valign="top">
				<th>
					<label for="cafe_bar"> <?=__('Cafe/Bar', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('Cafe/Bar', 'nextt')?> </p>
					<input type="text" id="cafe_bar" name="cafe_bar" value="<?php echo Hotel_Distances::$view["cafe_bar"]; ?>" size="65" />
				</td>
			</tr>

			<tr valign="top">
				<th>
					<label for="beach"> <?=__('Beach', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('Beach', 'nextt')?> </p>
					<input type="text" id="beach" name="beach" value="<?php echo Hotel_Distances::$view["beach"]; ?>" size="65" />
				</td>
			</tr>

			<tr valign="top">
				<th>
					<label for="taxi"> <?=__('Taxi', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('Taxi', 'nextt')?> </p>
					<input type="text" id="taxi" name="taxi" value="<?php echo Hotel_Distances::$view["taxi"]; ?>" size="65" />
				</td>
			</tr>

			<tr valign="top">
				<th>
					<label for="bus"> <?=__('Bus Station', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('Bus Station', 'nextt')?> </p>
					<input type="text" id="bus" name="bus" value="<?php echo Hotel_Distances::$view["bus"]; ?>" size="65" />
				</td>
			</tr>

			<tr valign="top">
				<th>
					<label for="atm"> <?=__('A.T.M.', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('A.T.M.', 'nextt')?> </p>
					<input type="text" id="atm" name="atm" value="<?php echo Hotel_Distances::$view["atm"]; ?>" size="65" />
				</td>
			</tr>


		</table>
		<p>
			<input name="<?=Hotel_Distances::$submit_button_name?>" type="submit" value="<?= __('Save Settings', 'nextt') ?>" class="button-primary"/>
		</p>
	</form>

</div>
