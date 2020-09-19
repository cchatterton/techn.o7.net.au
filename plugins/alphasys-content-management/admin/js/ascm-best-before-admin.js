jQuery(document).ready(function($) {
	if(typeof ascm_bestbefore_scheduleoptions_param != 'undefined'){

		//console.log(ascm_bestbefore_scheduleoptions_param);
		$('#ascm_bestbefore_scheduleoptions h2').prepend('<img id="ascm_logo" src="'+ascm_bestbefore_scheduleoptions_param.logourl+'">');

		$('#ascm_bestbefore_specific_expdate').datepicker({
			dateFormat : 'mm/dd/yy'
		});
	}


	ToggleSpecificDate();
	$('input[type=radio][name=ascm_bestbefore_expdate_type]').on('change',function(){
		ToggleSpecificDate();
	});
	function ToggleSpecificDate(){
		if ($('input[type=radio][name=ascm_bestbefore_expdate_type]:checked').val() == 'specificdate') {
			$('#ascm_bestbefore_specific_expdate').attr('required');
			$('#ascm_bestbefore_specific_expdate_cont').css('display', 'block');
		}else{
			$('#ascm_bestbefore_specific_expdate').removeAttr('required');
			$('#ascm_bestbefore_specific_expdate_cont').css('display', 'none');
		}
	}

	if(typeof ascm_modsettings_bestbefore_param != 'undefined') {
		//  JS for running the expire post batch process
		$('#ascm-bestbefore-runexpirepostbatch-btn').on('click', function () {

			$('#ascm-bestbefore-runexpirepostbatch-btn').addClass('ascm-bestbefore-runexpirepostbatch-btn-disabled');
			console.log('Executing Best Before Expire Post Batch');

			$.ajax({
				type: 'POST',
				url:  ascm_modsettings_bestbefore_param.url,
				data: {
					'action':'run_expire_post_batch',
					'action_type': 'excute',
					nonce: ascm_modsettings_bestbefore_param.nonce,
				},
				success: function(resp) {
					console.log(resp);
				},
				error: function(resp) {
					console.log( resp );
					setTimeout(function(){
						$('#ascm-bestbefore-runexpirepostbatch-btn').removeClass('ascm-bestbefore-runexpirepostbatch-btn-disabled');
					}, 500);
				}
			});

		});

		ExecuteEveryTwoSeconds();

		function ExecuteEveryTwoSeconds() {
			setTimeout(function(){
				FetchExpirePostBatchProcess();
				ExecuteEveryTwoSeconds();
			}, 3000);
		}

		function FetchExpirePostBatchProcess() {
			$.ajax({
				type: 'POST',
				url:  ascm_modsettings_bestbefore_param.url,
				data: {
					'action':'run_expire_post_batch',
					'action_type': 'fetch',
					nonce: ascm_modsettings_bestbefore_param.nonce,
				},
				success: function(resp) {
					//console.log(resp);
					var batch_status = ( typeof resp.bestbefore_batch.batch_status != 'undefined' ) ? resp.bestbefore_batch.batch_status : '';

					var batch_progress = ( typeof resp.bestbefore_batch.batch_progress != 'undefined' ) ? resp.bestbefore_batch.batch_progress : '';
					batch_progress = (batch_progress != '') ? batch_progress : '0.00%'

					var num_of_records = ( typeof resp.bestbefore_batch.num_of_records != 'undefined' ) ? resp.bestbefore_batch.num_of_records : '';
					var process_started = ( typeof resp.bestbefore_batch.process_started != 'undefined' ) ? resp.bestbefore_batch.process_started : '';
					if (process_started == ''){
						var process_started_date = '';
					} else{
						var process_started_date = new Date(process_started*1000);
					}
					var process_ended = ( typeof resp.bestbefore_batch.process_ended != 'undefined' ) ? resp.bestbefore_batch.process_ended : '';
					if (process_ended == ''){
						var process_ended_date = '';
					} else{
						var process_ended_date = new Date(process_ended*1000);
					}


					if (batch_status == 'ongoing'){
						$('#ascm-mod-settings-expirepost-loading-cont-bestbefore').removeClass('ascm-hidden');

						$('#ascm-bestbefore-runexpirepostbatch-btn').addClass('ascm-bestbefore-runexpirepostbatch-btn-disabled');

						$('#ascm-bestbefore-myBar-progress-label').text(batch_progress);
						$('#ascm-bestbefore-myBar').css('width',batch_progress);

						$('#ascm-bestbefore-expirepost-batch-status-label').text(batch_status.toUpperCase());
						$('#ascm-bestbefore-expirepost-batch-numpost-label').text(num_of_records);
						$('#ascm-bestbefore-expirepost-batch-started-label').text(process_started_date);
						$('#ascm-bestbefore-expirepost-batch-ended-label').text(process_ended_date);


					}else{
						$('#ascm-mod-settings-expirepost-loading-cont-bestbefore').addClass('ascm-hidden');
						$('#ascm-bestbefore-runexpirepostbatch-btn').removeClass('ascm-bestbefore-runexpirepostbatch-btn-disabled');

						$('#ascm-bestbefore-myBar-progress-label').text(batch_progress);
						$('#ascm-bestbefore-myBar').css('width',batch_progress);

						$('#ascm-bestbefore-expirepost-batch-status-label').text(batch_status.toUpperCase());
						$('#ascm-bestbefore-expirepost-batch-numpost-label').text(num_of_records);
						$('#ascm-bestbefore-expirepost-batch-started-label').text(process_started_date);
						$('#ascm-bestbefore-expirepost-batch-ended-label').text(process_ended_date);
					}
				},
				error: function(resp) {
					console.log( resp );
					$('#ascm-mod-settings-expirepost-loading-cont-bestbefore').addClass('ascm-hidden');
					$('#ascm-bestbefore-runexpirepostbatch-btn').removeClass('ascm-bestbefore-runexpirepostbatch-btn-disabled');
				}
			});
		}
	}

});