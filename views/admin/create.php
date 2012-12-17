
	<section class="title">
		<h4>Create</h4>
	</section>
	<section class="item form_inputs">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
			<fieldset>
				<ul>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="name">Title <span>*</span></label>
						<div class="input"><?php echo form_input('title', set_value('title', ( isset($input['title']) ? $input['title'] : NULL )), 'class="width-15"'); ?></div>
					</li>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="name">Slug <span>*</span></label>
						<div class="input"><?php echo form_input('slug', set_value('slug', ( isset($input['slug']) ? $input['slug'] : NULL )), 'class="width-15"'); ?></div>
					</li>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="name">Parent</label>
						<div class="input"><?php echo $dropdown; ?></div>
					</li>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="name">Keywords</label>
						<div class="input"><?php echo form_input('keywords', set_value('keywords', ( isset($input['keywords']) ? $input['keywords'] : NULL )), 'class="width-15"'); ?></div>
					</li>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="name">Description</label>
						<div class="input"><?php echo form_input('description', set_value('description', ( isset($input['description']) ? $input['description'] : NULL )), 'class="width-15"'); ?></div>
					</li>
				</ul>
			</fieldset>
			<div class="buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
			</div>
		<?php echo form_close(); ?>
	</section>