
	<div class="one_half">
		<section class="title">
			<h4>Documents</h4>
		</section>
		<section class="item">
<?php if( isset($docs) && !empty($docs) ): ?>
			<div id="documentation-sort">
				<ul class="sortable">
					<?php foreach($docs as $doc): ?>
							<li id="doc_<?php echo $doc['id']; ?>">
								<div>
									<a href="#" rel="<?php echo $doc['id']; ?>"><?php echo $doc['title']; ?></a>
								</div>
					<?php if(isset($doc['children'])): ?>
								<ul>
									<?php $controller->documentation_m->tree_builder($doc); ?>
								</ul>
							</li>
					<?php else: ?>
							</li>
					<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
<?php else: ?>
			<div class="no_data"><?php echo lang('docs:label:no_docs'); ?></div>
<?php endif; ?>
		</section>
	</div>

	<div class="one_half last">
		<section class="title">
			<h4>Details</h4>
		</section>
		<section class="item form_inputs">
			<?php echo form_open_multipart($this->uri->uri_string().'/update', 'class="crud"'); ?>
			<fieldset style="display: none">
				<input type="hidden" name="id" value="" />
				<ul>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="name">Title <span>*</span></label>
						<div class="input"><?php echo form_input('title', set_value('title', NULL), 'class="width-15"'); ?></div>
					</li>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="name">Slug <span>*</span></label>
						<div class="input"><?php echo form_input('slug', set_value('slug', NULL), 'class="width-15"'); ?></div>
					</li>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="name">Parent</label>
						<div class="input"><?php echo $dropdown; ?></div>
					</li>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="name">Keywords</label>
						<div class="input"><?php echo form_input('keywords', set_value('keywords', NULL), 'class="width-15"'); ?></div>
					</li>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="name">Description</label>
						<div class="input"><?php echo form_input('description', set_value('description', NULL), 'class="width-15"'); ?></div>
					</li>
				</ul>
			</fieldset>
			<div class="buttons" style="display: none">
				<button type="submit" name="btnAction" value="update" class="btn blue save">Update</button>
				<a href="#" class="btn green edit">Edit</a>
			</div>
			<?php echo form_close(); ?>
		</section>
	</div>