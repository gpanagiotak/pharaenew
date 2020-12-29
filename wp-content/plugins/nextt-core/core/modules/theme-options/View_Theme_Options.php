<div class="wrap">
	<h2> <?= $this->find_inputs_by_slug( null )['title']; ?> </h2>

	<form method="POST" action="">
		<table class="form-table">

			<?php foreach ( $this->find_inputs_by_slug( null )['inputs'] as $input ): ?>

				<?php if ( $input['type'] == 'text' ): ?>
					<tr valign="top">
						<th>
							<label for="<?=$input['properties']['text-id']?>"> <?= $input['title'] ?> </label>
						</th>
						<td>
							<p class="description"> <?= $input['description'] ?> </p>
							<input type="text" id="<?=$input['properties']['text-id']?>" name="<?=$input['properties']['text-id']?>" value="<?=$input['properties']['value']?>" size="65" />
						</td>
					</tr>
				<?php endif; ?>

				<?php if ( $input['type'] == 'checkbox'): ?>
					<tr>
						<th>
							<label for="<?=$input['properties']['text-id']?>"><?= $input['title']?></label>
						</th>
						<td>
							<p class="description">
								<input type="checkbox" id="<?=$input['properties']['text-id']?>" name="<?=$input['properties']['text-id']?>" value="<?=$input['properties']['defvalue']?>" size="65" <?php if($input['properties']['value']): echo "checked"; endif; ?> />
								<?= $input['description']?>
							</p>
						</td>
					</tr>
				<?php endif; ?>

				<?php if($input['type'] == 'color'): ?>
					<tr valign="top">
						<th>
							<label for="<?=$input['properties']['text-id']?>"> <?= $input['title'] ?> </label>
						</th>
						<td>
							<p class="description"> <?= $input['description'] ?> </p>
							<input type="text" id="<?=$input['properties']['text-id']?>" name="<?=$input['properties']['text-id']?>" value="<?=$input['properties']['value']?>" size="65" class="meta-color"/>
						</td>
					</tr>
				<?php endif; ?>

				<?php if ( $input['type'] == 'radio'): ?>
					<tr>
						<th>
							<label for="<?=$input['properties']['text-id']?>"><?= $input['title']?></label>
						</th>
						<td>
							<?php foreach($input['inputs'] as $radio):?>
								<p class="description">
									<input type="radio" id="<?=$input['properties']['text-id']?>" name="<?=$input['properties']['text-id']?>" value="<?=$radio['value']?>" size="65" <?php if($input['properties']['value'] == $radio['value']): echo "checked"; endif; ?> />
									<?= $input['description']?>
								</p>
							<?php endforeach;?>
						</td>
					</tr>
				<?php endif; ?>

				<?php if ( $input['type'] == 'image' ): ?>
					<tr valign="top">
						<th>
							<label for="<?=$input['properties']['text-id']."-input"?>"> <?= $input['title'] ?> </label>
						</th>
						<td>
							<p class="description"> <?= $input['description'] ?> </p>
							<input type="hidden" id="<?=$input['properties']['text-id']."-input"?>" name="<?=$input['properties']['text-id']?>" value="<?=$input['properties']['value']?>" size="65" />
							<img class="<?= 'image-container-'.$input['properties']['text-id'] ?>" height="150" width="150" src="<?=$input['properties']['value']?>">
							<input type="button" id="<?=$input['properties']['text-id'].'-button'?>" class="button"
							value="Upload an Image"/>
						</td>
					</tr>
				<?php endif; ?>

				<?php if ( $input['type'] == 'select'): ?>
					<tr>
						<th>
							<label for="<?=$input['properties']['text-id']?>"><?= $input['title']?></label>
						</th>
						<td>

								<p class="description">
									<?= $input['description']?>
								</p>

								<select name="<?=$input['properties']['text-id']?>">
									<?php foreach($input['inputs'] as $option):?>
										<option type="radio" id="<?=$input['properties']['text-id']?>"  value="<?=$option['value']?>" size="65" <?php if($input['properties']['value'] == $option['value']): echo "selected"; endif; ?> ><?= $option['description']?></option>
									<?php endforeach;?>
								</select>

						</td>
					</tr>
				<?php endif; ?>

			<?php endforeach; ?>



		</table>
		<p>
			<input name="<?=$this->find_inputs_by_slug( null )['slug']?>" type="submit" value="<?= __('Save Settings', 'nextt') ?>" class="button-primary"/>
		</p>
	</form>

</div>