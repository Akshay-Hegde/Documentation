
	<div class="one_half">
		<section class="title">
			<h4>Preview</h4>
		</section>
		<section class="item">
			<div class="preview">
				<?php echo $preview; ?>
			</div>
		</section>
	</div>

	<div class="one_half last">
		<section class="title">
			<h4>Edit <?php echo $title; ?></h4>
		</section>
		<section class="item form_inputs">
			<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
				<textarea name="document" style="min-height: 300px" rows="60" cols="95"><?php echo $document; ?></textarea>
				<br /><br />
				<button type="submit" name="btnAction" value="update" class="btn blue save">Update</button>
				<a href="/admin/documentation" class="btn gray cancel">Cancel</a>
			<?php echo form_close(); ?>
		</section>
	</div>