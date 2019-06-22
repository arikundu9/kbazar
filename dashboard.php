<?php
include 'check_login.php';
$title="Dashboard :: KBazar.";
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

	<main role="main" class="container mt-2">
		<div class="row justify-content-center">
			<div class="col-12 col-sm-6 col-md-6 col-lg-5 col-xl-6 mb-2">
				<div class="card p-0 main-container">
					<div class="card-header">
						<h5 class="card-title mb-0 text-center">Stock Details</h5>
					</div>
					<div class="card-body">
						Total Amount: <h1 id="amount"></h1>
						Type of Products: <br><span class="h1" id="nop"></span><span class="h3"> type</span><br>
						Out of Stock: <br><span class="h1" id="sout"></span><span class="h3"> Products</span><br>
					</div>
					<div class="card-footer d-flex align-content-center flex-wrap justify-content-between">
						<button type="button" class="btn btn-primary btn-sm">Button</button>
					</div>
				</div>
			</div>
			<!--<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-2">
				<div class="card p-0 main-container">
					<div class="card-header">
						<h5 class="card-title mb-0 text-center">Daily Sale Graph</h5>
					</div>
					<div class="card-body">
						Day vs Sale
					</div>
					<div class="card-footer">
						Today's Sale: <span class="h2">₹650/-</span>
					</div>
				</div>
			</div>-->
		</div>
	</main>
	
	<?php //include 'foot.php';?>
</body>
<?php include 'footer.php';?>
<script>

	$(document).ajaxStart(function(){
		$("#loading").show();
	});

	$(document).ajaxComplete(function(){
		$("#loading").hide();
	});

	$(document).ready(function(){
		$.getJSON('./ajax/dashboard.ajax.php',{
			cmd:'GetInfo'
		})
		.done(function(response){
			if(response.header.login==true){
				$('#amount').html('₹'+response.body.total_stock_amount+'/-');
				$('#nop').html(response.body.total_stock);
				$('#sout').html(response.body.stock_out);
			}
			else{
				window.location.replace('./index.php');
			}
		})
		.fail(function( jqxhr, textStatus, error ) {
			DATA=false;
			var err = textStatus + ", " + error;
			console.log( "Request Failed: " + err );
		});
	});
</script>
