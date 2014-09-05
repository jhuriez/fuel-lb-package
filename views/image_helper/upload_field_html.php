<div class=" form-group">
	<label id="label_image" for="form_image" class="control-label col-lg-4"><?= $label; ?></label>
	<div class="col-lg-2">
		<div class="row">
			<div class="col-lg-12">
				<span class="btn btn-success fileinput-button">
		            <i class="glyphicon glyphicon-plus"></i>
		            <span><?= $labelBtn; ?></span>
		            <input id="fileupload-<?= $name; ?>" type="file" name="<?= $name; ?>">
		        </span>
			</div>
	    </div>
	    <div class="row">
	        <br/>
			<div id="progress-<?= $name; ?>" class="progress" style="display: none;">
			  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
			    <span>Upload en cours - 0%</span>
			  </div>
			</div>
		</div>
	</div>
	<div class="col-lg-5 col-lg-offset-1">
		<div class="preview img-thumbnail" style="max-width: 520px;">
			<img id="image-preview-<?= $name; ?>" src="<?= $imagePreview; ?>" style="max-width: 100%; height: auto; max-height: 200px;">
		</div>
	</div>
</div>