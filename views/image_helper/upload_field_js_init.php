		function initView()
		{
			// On clone le bouton "<?= $idAdd; ?>" pour en faire un fake
			var fakeSubmit = $("#<?= $idAdd; ?>").clone();
			fakeSubmit.attr('id', "<?= $idAdd; ?>_fake").attr('type', 'button').val("<?= $labelUpload; ?>").hide();
			$("#<?= $idAdd; ?>").after(fakeSubmit);
		}
		initView();

		function imagePreview(input, target) {
			if (input.files && input.files[0]) {
				var filerdr = new FileReader();
				filerdr.onload = function(e) {
					$('#' + target).attr('src', e.target.result);
				}
				filerdr.readAsDataURL(input.files[0]);
			}
		}