

<div class="wrap">

	<h2><?= __("Setup Useful Phone Numbers", "nextt")?></h2>

	<form method="POST" action="">
		<table class="form-table">


			<tr valign="top">
				<th>
					<label for="taxi"> <?=__('Taxi', 'nextt')?> </label>
				</th>
				<td>
					<p class="description"> <?=__('Taxi Phone Numbers (separated with commas)', 'nextt')?> </p>
					<input type="text" id="taxi" name="taxi" value="<?php echo Hotel_Useful_Phones::$view["taxi"]; ?>" size="65" />
				</td>
			</tr>


			<tr valign="top">
				<th>
					<label for="doctor"> <?=__('Doctor', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('Doctor Phone Numbers (separated with commas)', 'nextt')?> </p>
					<input type="text" id="doctor" name="doctor" value="<?php echo Hotel_Useful_Phones::$view["doctor"]; ?>" size="65" />
				</td>
			</tr>


			<tr valign="top">
				<th>
					<label for="hospital"> <?=__('Hospital', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('Hospital Phone Numbers (separated with commas)', 'nextt')?> </p>
					<input type="text" id="hospital" name="hospital" value="<?php echo Hotel_Useful_Phones::$view["hospital"]; ?>" size="65" />
				</td>
			</tr>


			<tr valign="top">
				<th>
					<label for="dentist"> <?=__('Dentist', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('Dentist Phone Numbers (separated with commas)', 'nextt')?> </p>
					<input type="text" id="dentist" name="dentist" value="<?php echo Hotel_Useful_Phones::$view["dentist"]; ?>" size="65" />
				</td>
			</tr>


			<tr valign="top">
				<th>
					<label for="municipality"> <?=__('Municipality', 'nextt')?> </label><br>
				</th>
				<td>
					<p class="description"> <?=__('Municipality Phone Numbers (separated with commas)', 'nextt')?> </p>
					<input type="text" id="municipality" name="municipality" value="<?php echo Hotel_Useful_Phones::$view["municipality"]; ?>" size="65" />
				</td>
			</tr>


		</table>
		<p>
			<input name="<?=Hotel_Useful_Phones::$submit_button_name?>" type="submit" value="<?= __('Save Settings', 'nextt') ?>" class="button-primary"/>
		</p>
	</form>

</div>
