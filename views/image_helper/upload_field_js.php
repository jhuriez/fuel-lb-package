		// Upload slide image
	    $("#fileupload-<?= $name; ?>").fileupload({
	    	url: "<?= $url ?>",
	        dataType: 'json',
	        previewMaxHeight: 500,
	        previewMaxWidth: 500,
	        autoUpload: <?= ($autoUpload) ? 'true' : 'false'; ?>,
	        add: function (e, data) {
	        	imagePreview(data.fileInput[0], "image-preview-<?= $name; ?>");
	        	<?php if( ! $autoUpload): ?>
		        	$("#<?= $idAdd; ?>").hide();
		        	$("#<?= $idAdd; ?>_fake").show();
		        	// On bloque à une seule image pour l'upload
	        		$("#<?= $idAdd; ?>_fake").off('click');
		        	$("#<?= $idAdd; ?>_fake").on('click', function(e) {
		        		e.preventDefault();
		        		$("#<?= $idAdd; ?>_fake").val('Upload de l\'image en cours').attr('disabled', 'disabled');
		        		data.submit();
		        		$("#<?= $idAdd; ?>_fake").off('click');
		        	});
	        	<?php else: ?>
	        		data.submit();
	        	<?php endif; ?>
	        },
	        progressall: function (e, data) {
		        var progress = parseInt(data.loaded / data.total * 100, 10);
		        $("#progress-<?= $name; ?>.progress").show();
		        $("#progress-<?= $name; ?> .progress-bar").css(
		            'width',
		            progress + '%'
		        ).attr('aria-valuenow', progress).find('span').html('Upload en cours - ' + progress + '%');
		    },
	        done: function (e, data) {
        		$("#<?= $idAdd; ?>_fake").val("<?= $labelUpload; ?>").attr('disabled', false).hide();
	        	$("#progress-<?= $name; ?> .progress-bar span").html('Upload terminé - 100%')
	        	$("#<?= $idReceipt; ?>").val(data.result[0]);
				<?php if($autoSubmit): ?>
		        	$("#<?= $idAdd; ?>").show().click();
		        <?php else: ?>
		        	$("#<?= $idAdd; ?>").show();
				<?php endif; ?>
	        }
	    });