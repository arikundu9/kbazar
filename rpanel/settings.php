<?php
include 'check_login.php';
$title="Settings :: KBazar.";
include 'header.php';
?>
<body>
	<?php	//include 'head.php';
			include 'nav.php'; 
			include 'msg.php';
	?>
	
	<div style="position:fixed;top:0;left:0;width:100%;height:100%;z-index:1053;background:#ffffff75;display:none;" id="loading">
		<div class="d-flex justify-content-center align-items-center w-100 h-100" style="">
			<div class="xspinner-border spinner-grow" style="width: 6rem; height: 6rem;" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
	</div>

	<div id="mg" align="center"></div>
	
	<div id="notice_panel"></div>
	
	<main role="main" class="container mt-2">
		<div class="row justify-content-center">
			<div class="col-12 col-sm-8 col-md-6 col-lg-6 col-xl-6 mb-2">
				<div class="card p-0 main-container">
					<div class="card-header p-1">
						<h5 class="card-title mb-0 text-center">Settings</h5>
					</div>
					<div class="card-body">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text">Store Name: </div>
								</div>
								<input type="text" class="form-control" value="Name of the Store" id="sname" placeholder="Name of the Store">
							</div>
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><small>Change Password: </small></div>
								</div>
								<input type="password" class="form-control" id="passwordn" placeholder="New Password" disabled>
								<input type="password" class="form-control" id="passwordr" data-toggle="popover" data-trigger="manual" data-placement="top" title="Password Mismatch" data-content="Repeated Password is not matching with the New Password" placeholder="Repeat Password" disabled>
								<div class="input-group-append">
									<div class="input-group-text">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input" id="password_lock">
											<label class="custom-control-label" for="password_lock"></label>
										</div>
									</div>
								</div>
								</div>
							<div id="prog" class="progress border border-secondary rounded-pill mt-1" style="height: 20px;display:none;">
								<div id="pbar" class="progress-bar progress-bar-striped progress-bar-animated bg-danger bg-info" role="progressbar" style="width: 0%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<small>Must include at least one digit, one uppercase, one lowercase and one special symbol. Should be of minimum lenght 8.</small>
							<div class="input-group mt-2">
								<div class="input-group-prepend">
									<div class="input-group-text">Phone: </div>
								</div>
								<input type="number" class="form-control" value="" id="phone" placeholder="Your Contact">
							</div>
							<small>10 Digits Only</small>
							<!--<br>
							<label for="customRange2">Example range</label>
							<input type="range" class="custom-range border border-secondary rounded-pill px-2 bg-secondary" min="0" max="5" value="1" id="customRange2">-->
						</form>
					</div>
					<div class="card-footer d-flex align-content-center flex-wrap justify-content-between p-2">
						<button type="button" class="btn btn-primary w-100" id="save_btn">
							<div class="spinner-border spinner-border-sm mr-1" style="display:none;margin-bottom:1px !important;" id="save_spinner" role="status">
								<span class="sr-only">Loading...</span>
							</div>Save Changes
						</button>
					</div>
				</div>
			</div>
		</div>
	</main>
	
	<?php //include 'foot.php';?>
</body>
<?php include 'footer.php';?>
<script>
	var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    var mediumRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
	var toast=100;

	
	$(document).ajaxStart(function(){
		$("#loading").show();
	});

	$(document).ajaxComplete(function(){
		$("#loading").hide();
	});

	$(document).ready(function(){
		$.getJSON('./ajax/settings.ajax.php',{
			cmd: 'GetSettings'
		})
		.done(function(response){
			if(response.header.login==true){
				$('#sname').val(response.body.store_name);
				$('#phone').val(response.body.phone);
				//console.log(response.body.phone);
			}
			else{
				window.location.replace('./index.php');
			}
		})
		.fail(function( jqxhr, textStatus, error ){
			var err = textStatus + ", " + error;
			console.log( "Request Failed: " + err );
		});
	});

	$('#password_lock').on('change',function(){
		if($(this).is(':checked')){
			$('#passwordn,#passwordr').attr("disabled", false);
			$('#prog').show();
		}
		else{
			$('#passwordn,#passwordr').attr("disabled", true);
			$('#prog').hide();
		}
	});
	
	$('#save_btn').on('click',function(){
		val=$('#passwordn').val();
		val2=$('#passwordr').val();
		phn=$('#phone').val();
		pchk=$('#password_lock').is(':checked');
		if(pchk && val.length>0 && !strongRegex.test(val) && !mediumRegex.test(val)){
			post_toast('Invalid Input','Too Weak password !');
		}
		else if(pchk && val.length===0){
			post_toast('Invalid Input','New Password can\'t be blank.');
		}
		else if(pchk && val2.length===0){
			post_toast('Invalid Input','Repeated Password is empty.');
		}
		else if(pchk && val!=val2){
			post_toast('Invalid Input','Repeated Password Mismatch.');
		}
		else if(phn.length!=10){
			post_toast('Invalid Input','Phone number must be of exactly 10 Digits.');
		}
		else{
			$.getJSON('./ajax/settings.ajax.php',{
				cmd: 'SaveChange',
				sname: $('#sname').val(),
				password: pchk ? $('#passwordn').val() : null,
				phone: phn,
				beforeSend: function(){
					$('#save_spinner').show();
				},
				complete: function(){
					$('#save_spinner').hide();
				}
			})
			.done(function(response){
				if(response.header.login==true){
					//console.log(response);
					$('#mg').html(get_alert_html(response.msg.degree,response.msg.body));
				}
				else{
					window.location.replace('./index.php');
				}
			})
			.fail(function( jqxhr, textStatus, error ){
				var err = textStatus + ", " + error;
				console.log( "Request Failed: " + err );
			});
		}
	});
	
	$('#passwordn').on('blur input',function(){
		val=$(this).val();
		if(strongRegex.test(val)){
			$('#pbar').removeClass('bg-primary bg-secondary bg-success bg-danger bg-warning bg-info bg-light bg-dark bg-white bg-transparent').addClass('bg-success').html("Strong").css({"width":"100%"});
        }
		else if(mediumRegex.test(val)){
			$('#pbar').removeClass('bg-primary bg-secondary bg-success bg-danger bg-warning bg-info bg-light bg-dark bg-white bg-transparent')
						.addClass('bg-info').html("Medium").css({"width":"65%"});
        }
		else if(val.length>0){
			$('#pbar').removeClass('bg-primary bg-secondary bg-success bg-danger bg-warning bg-info bg-light bg-dark bg-white bg-transparent')
						.addClass('bg-danger').html("Weak").css({"width":"25%"});
        }
		else{
			$('#pbar').html("").css({"width":"0%"});
		}
	});
	$('#passwordr').on('blur',function(){
		if($(this).val()===$('#passwordn').val())
			$(this).popover('hide');
		else
			$(this).popover('show');
	});
	
	
	function get_time() {
		date=new Date;
		var hours = date.getHours();
		var minutes = date.getMinutes();
		var sec = date.getSeconds();
		var ampm = hours >= 12 ? 'PM' : 'AM';
		hours = hours % 12;
		hours = hours ? hours : 12; // the hour '0' should be '12'
		minutes = minutes < 10 ? '0'+minutes : minutes;
		var strTime = hours + ':' + minutes + ':' + sec + ' ' + ampm;
		return strTime;
	}
	
	function get_toast_html(id,heading,sub,body){
		return ''+
			'<div class="toast kb-toast" role="alert" aria-live="assertive" aria-atomic="true" id="toast' + id + '" data-autohide="false">'+
				'<div class="toast-header kb-toast-header">'+
					'<!--<img src="..." class="rounded mr-2" alt="...">-->'+
					'<span class="oi oi-bell mr-2"></span>'+
					'<strong class="mr-auto">'+heading+'</strong>'+
					'<small>'+sub+'</small>'+
					'<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">'+
						'<span aria-hidden="true">&times;</span>'+
					'</button>'+
				'</div>'+
				'<div class="toast-body kb-toast-body">'+
					body+
				'</div>'+
			'</div>';
	}
	
	function get_alert_html(colr,msg){
		return '<div class="container" id="mSg">'+
					'<div class="row justify-content-center">'+
						'<div class="col-10 col-sm-10 col-md-4 col-lg-4 alert alert-' + colr + ' alert-dismissible fade show mt-2 shadow" role="alert" id="galrt">'+
							'<div class="i_i">' + msg + '</div>'+
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
								'<span aria-hidden="true">&times;</span>'+
							'</button>'+
						'</div>'+
					'</div>'+
				'</div>';
	}

	function post_toast(title,body){
		$('#notice_panel').prepend(
			get_toast_html(++toast,title,get_time(),body)
		);
		$('#toast'+toast).toast('show');
		$('#toast'+toast).on('shown.bs.toast', function () {
			$(this).onSwipe({direction:'right'},$.proxy(function(){
				$(this).toast('hide');
			},this));
		});
	}
</script>