<div class="form-group">
	<label id="label_<?= $fieldName; ?>" for="form_<?= $fieldName; ?>" class="control-label col-lg-4"><?= $fieldLabel; ?></label>
	<div class="col-lg-2">
		<div class="row">
			<div class="col-lg-12">
				<span class="btn btn-info fileinput-button">
		            <i class="glyphicon glyphicon-plus"></i>
		            <span><?= $labelBtn; ?></span>
		            <input type="file" id="form_<?= $fieldName; ?>" name="<?= $fieldName; ?>">
		        </span>
			</div>
	    </div>
	</div>
</div>