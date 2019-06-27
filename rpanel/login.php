<?php
$title="Welcome To KBazar.";
include 'header.php';
?>
<body>
	<?php	//include 'head.php';
			//include 'nav.php';
			include 'msg.php';
	?>
	<div id="mg" align="center"></div>
	<main role="main" class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-10 col-sm-6 col-md-6 col-lg-4 xmain-container">
				<div class="card d-print-none">
					<div class="card-header">
						<h4 class="card-title mb-0 text-center font-boing">KBazar Login</h4>
					</div>
					<div class="card-body">
						<form method="post" enctype="multipart/form-data" action="">
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text">ID: </div>
								</div>
								<input type="text" name="id" class="form-control" id="user" placeholder="Username">
							</div>
							<div class="input-group mb-4">
								<div class="input-group-prepend">
									<div class="input-group-text">Password: </div>
								</div>
								<input type="password" name="pass" class="form-control" id="password" placeholder="Password">
							</div>
							<div class="custom-control custom-checkbox mr-sm-2 mb-3">
								<input type="checkbox" name="remember_me" value="300" class="custom-control-input" id="remm">
								<label class="custom-control-label" for="remm">Remember this browser.</label>
							</div>
							<input type="hidden" name="login"/>
							<button type="button" class="btn btn-primary w-100" data-Xonclick="this.form.submit();" id="logn">Login</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>
	
	<?php //include 'foot.php';?>
</body>
<?php include 'footer.php';?>

<script>
$( document ).ready(function() {
	//window.scrollto(0,1);
});
$(function(){
	$('#logn').on('click',function(e){
	    $('#mg').html(
				'<div class="container" id="mSg">' + 
					'<div class="row justify-content-center"">' + 
						'<div class="col-10 col-sm-10 col-md-4 col-lg-4 alert alert-warning alert-dismissible fade show mt-2 shadow" role="alert" id="alrt">' + 
							'<div class="i_i">Loading...</div>' + 
							'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' + 
								'<span aria-hidden="true">&times;</span>' + 
							'</button>' + 
						'</div>' + 
					'</div>' + 
				'</div>'
					);
		//$('#mg').show(250);
		if($('#remm').prop('checked'))
			rem = $('#remm').val();
		else
			rem = 0;
		id = $('#user').val();
		pass = $('#password').val();
		$.ajax({
			type: "POST",
			url: "index.php",//"<?php echo basename(__FILE__) ?>",
			dataType: "text",
			data: "login=Login&id=" + id + "&pass=" + pass + "&remember_me=" + rem,
			success: function(msg){
				/*if(msg == "SORI00")
					msG = "Admin ID or Password can\'t be blank.";
				if(msg == "SORI09")
					msG = "Unable To Identify ID";
				if(msg == "SORI07")
					msG = "A/C Locked For Security Reason.";*/
				if(msg == "SORI05"){
					$('#mg').html(
					'<div class="container" id="mSg">' + 
						'<div class="row justify-content-center"">' + 
							'<div class="col-10 col-sm-10 col-md-4 col-lg-4 alert alert-danger alert-dismissible fade show mt-2 shadow" role="alert" id="alrt">' + 
								'<div class="i_i">Invalid Login.</div>' + 
								'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' + 
									'<span aria-hidden="true">&times;</span>' + 
								'</button>' + 
							'</div>' + 
						'</div>' + 
					'</div>'
						);
					//$('#mg').show(500);
					setTimeout(function(){
						$('#alrt').alert('close');
					},3000);
				}
				if(msg == "SORI03"){
					$('#mg').html(
					'<div class="container" id="mSg">' + 
						'<div class="row justify-content-center"">' + 
							'<div class="col-10 col-sm-10 col-md-4 col-lg-4 alert alert-success alert-dismissible fade show mt-2 shadow" role="alert" id="alrt">' + 
								'<div class="i_i">Login Successful, Redirecting...</div>' + 
								'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' + 
									'<span aria-hidden="true">&times;</span>' + 
								'</button>' + 
							'</div>' + 
						'</div>' + 
					'</div>'
						);
					//$('#mg').show(500);
					h = "<?php echo isset($_GET['goto']) ? $_GET['goto'] : "./dashboard.php"; ?>";
					window.location.replace(h);
				}
			}
		}).fail(function() {
		});
		return false;
	});

	/*$('#page_1').onSwipe({direction:'left'},function(){
		slideto(2);
	});
	$('#page_2').onSwipe({direction:'right'},function(){
		slideto(1);
	});
	$('#page_2').onSwipe({direction:'left'},function(){
		slideto(3);
	});
	$('#page_3').onSwipe({direction:'right'},function(){
		slideto(2);
	});
	$(document).onSwipe({
		direction:'left-edge',
		distance:'10',
		padding:'70',
		time:'200',
		moving: function(x,y){
			width = $( "#sidebar" ).outerWidth();
			e=width-x;
			if(e<0)
				e = 'translate3d(-'+width+10+'px,0,0)';
			else
				e = 'translate3d(-'+e+'px,0,0)';
			//console.log(e);
			$( "#sidebar" ).removeClass("side_bar_off").addClass("side_bar_on")
		.css({'transform':e,'-moz-transform':e,'-webkit-transform':e});
			}
		},
		function(){
			if($( "#sidebar" ).is('.side_bar_off')){
				$( "#sidebar" ).removeClass("side_bar_off").addClass("side_bar_on");
			}
			else{
				$( "#sidebar" ).removeClass("side_bar_on").addClass("side_bar_off");
			}
		}
	);
	
	function slideto(v){
		var r=(v-1)*100;
		$('#control').css('transform','translate3d(-' + r + 'vw,0,0)');
	}
	$('#btn_slide_1').on('click',function(){
		slideto(2);
	});
	$('#btn_slide_2').on('click',function(){
		slideto(1);
	});
	$('#btn_slide_3').on('click',function(){
		slideto(3);
	});
	$('#btn_slide_4').on('click',function(){
		slideto(2);
	});
	
	var handle = $( "#custom-handle" );
	$( "#slider" ).slider({
		range: 'max',
		min: 0,
		max: 90,
		create: function(){
			handle.text( 'none' );
		},
		slide: function( event, ui ) {
			$('#rem_password_pw').val(ui.value * 60);
			handle.text( ui.value + 'min' );
			if(ui.value==0)
				handle.text( 'none' );
		}
	});
	
	var handle2 = $( "#custom-handle2" );
	$( "#slider2" ).slider({
		range: 'max',
		min: 0,
		max: 90,
		create: function(){
			handle2.text( 'none' );
		},
		slide: function( event, ui ) {
			$('#rem_password_pin').val(ui.value * 60);
			handle2.text( ui.value + 'min' );
			if(ui.value==0)
				handle2.text( 'none' );
		}
	});
	
	var handle3 = $( "#custom-handle3" );
	$( "#slider3" ).slider({
		range: 'max',
		min: 0,
		max: 90,
		create: function(){
			handle3.text( 'none' );
		},
		slide: function( event, ui ) {
			$('#rem_password_pt').val(ui.value * 60);
			handle3.text( ui.value + 'min' );
			if(ui.value==0)
				handle3.text( 'none' );
		}
	});
	
	$('#show_side_bar2,#hamburger').on('click',function(e){
		if($( "#sidebar" ).is('.side_bar_off')){
			$( "#sidebar" ).removeClass("side_bar_off").addClass("side_bar_on");
		}
		else{
			$( "#sidebar" ).removeClass("side_bar_on").addClass("side_bar_off");
		}
	e.stopPropagation();
	});
	
	$('#drop_down').on('click',function(e){
		if($( "#drop_down > ul" ).is('.showi')){
			$( "#drop_down > ul" ).removeClass("showi").addClass("hidei");
		}
		else{
			$( "#drop_down > ul" ).removeClass("hidei").addClass("showi");
		}
	e.stopPropagation();
	});
	
	$(document).on('click',function(e){
		if($(e.target).is('#sidebar,.list-group-item,#side_top,#drop_down > ul > li')==false){
			if($( "#sidebar" ).is('.side_bar_on')){
				$( "#sidebar" ).removeClass("side_bar_on").addClass("side_bar_off");
				e.stopPropagation();
			}
			if($( "#drop_down > ul" ).is('.showi')){
				$( "#drop_down > ul" ).removeClass("showi").addClass("hidei");
			}
		}
	});*/
	setTimeout(function(){
		//$('#mSg').slideUp(500);
		$('#galrt').alert('close')
	},3000);
});
</script>