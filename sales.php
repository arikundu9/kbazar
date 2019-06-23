<?php
include 'check_login.php';
$title="Sales :: KBazar.";
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
	
	<main role="main" class="container-fluid mt-3">

		<ul class="nav nav-tabs">
			<li class="nav-item tab" id="no_tab">
				<a class="nav-link active" href="#" data-tab="1">New Orders</a>
			</li>
			<li class="nav-item tab" id="rr_tab">
				<a class="nav-link" href="#" data-tab="2">Return/Refund</a>
			</li>
			<!--<li class="nav-item dropdown tab" id="more_tab">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" data-tab="3">More</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<a class="dropdown-item" href="#">Something else here</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">Separated link</a>
				</div>
			</li>-->
		</ul>

		<div class="card main-container p-0 mb-2 tab-body">
			<!-- <div class="card-header pl-1 pt-1 pr-1 pb-0 ">
				<ul class="nav nav-tabs">
					<li class="nav-item tab">
						<a class="nav-link active" href="#">New Orders</a>
					</li>
					<li class="nav-item tab">
						<a class="nav-link" href="#">Return/Refund</a>
					</li>
					<li class="nav-item dropdown tab">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">More</a>
						<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<a class="dropdown-item" href="#">Something else here</a>
						<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Separated link</a>
						</div>
					</li>
				</ul>
			</div> -->
			<div class="card-body xp-2 row justify-content-center" id="render_panel">

			</div>
			<div class="card-footer d-flex align-content-center flex-wrap justify-content-between p-2">
				<button type="button" class="btn btn-secondary btn-sm">Cancel Selected</button>
				<button type="button" class="btn btn-primary btn-sm">Accept Selected</button>
			</div>
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
		render_new_orders();
		$('#no_tab').on('click',function(){
			$('[data-tab]').removeClass('active');
			$('.nav-link',this).addClass('active');
			render_new_orders();
		});
		$('#rr_tab').on('click',function(){
			$('[data-tab]').removeClass('active');
			$('.nav-link',this).addClass('active');
			render_rr_orders();
		});
		$('#more_tab').on('click',function(){
			$('[data-tab]').removeClass('active');
			$('.nav-link',this).addClass('active');
			$('#render_panel').html('');
		});
	});
	
	$('#render_panel').on('loaded',function(){
		$('[id^=newOrderRejectBtn-]').on('click',function(){
			let id=parseInt($(this).attr('data-id'));
			console.log('id reject '+id+' clicked.');
		});
		$('[id^=newOrderAcceptBtn-]').on('click',function(){
			let id=parseInt($(this).attr('data-id'));
			console.log('id accept '+id+' clicked.');
		});
		$('[id^=rrRejectBtn-]').on('click',function(){
			let id=parseInt($(this).attr('data-id'));
			console.log('id rr_reject '+id+' clicked.');
		});
		$('[id^=rrAcceptBtn-]').on('click',function(){
			let id=parseInt($(this).attr('data-id'));
			console.log('id rr_accept '+id+' clicked.');
		});
	});

	function render_new_orders(){
		$('#render_panel').html('');
		$.getJSON('./ajax/sales.ajax.php',{
			cmd: 'GetOrders'
		})
		.done(function(response){
			if(response.header.login==true){
				$.each(response.body,function(i,e){
					if(e.status === 'New' || e.status === 'Accepted' || e.status === 'New' || e.status === 'Picked' || e.status === 'Delevered')
						$('#render_panel').append(get_order_html(0,e.oid,'nn','',e.pid,e.name,'',e.status));
					//console.log(e);
				});
				$('#render_panel').trigger('loaded');
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

	function render_rr_orders(){
		$('#render_panel').html('');
		$.getJSON('./ajax/sales.ajax.php',{
			cmd: 'GetOrders'
		})
		.done(function(response){
			if(response.header.login==true){
				$.each(response.body,function(i,e){
					if(e.status === 'Refund Requested' || e.status === 'Refund Accepted' || e.status === 'Refund Rejected' || e.status === 'Refund Picked' || e.status === 'Refunded' || e.status === 'Replace Requested' || e.status === 'Replace Accepted' || e.status === 'Replace Rejected' || e.status === 'Replaced')
						$('#render_panel').append(get_rrorder_html(0,e.oid,'nn','',e.pid,e.name,'',e.status));
					//console.log(e);
				});
				$('#render_panel').trigger('loaded');
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

	function get_rrorder_html(i,id,name,thumb,price,stock,unit,status){
		return ''+
			'<div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2" id="item_'+id+'">' + 
				'<div class="card border border-1 border-secondary">' + 
					/* '<div class="card-header p-2">' + 
						'<h6 class="card-title mb-0 text-center">'+id+' : '+name+'</h6>' + 
					'</div>' +	*/
					'<div class="card-body p-0">' +
					'<img class="card-img-top" src="./thumbs/default.jpg" alt="Card image cap" id="thumb1_'+id+'">' + 
						'<ul class="list-group list-group-flush">' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Product ID:</b> '+price+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Product Name:</b> '+stock+' '+unit+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Status:</b> <small>'+status+'</small></li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0 text-center p-1">' +
								'<button type="button" class="btn btn-primary btn-sm w-100" id="rrAcceptBtn-'+id+'" data-id="'+id+'">Accept</button>' + 
							'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0 text-center p-1">' +
								'<button type="button" class="btn btn-secondary btn-sm w-100" id="rrRejectBtn-'+id+'" data-id="'+id+'">Reject</button>' + 
							'</li>' + 
						'</ul>' + 
					'</div>' +
					/* '<div class="kb card-footer d-flex align-content-center flex-wrap justify-content-between">' + 
						'<button type="button" class="btn btn-secondary btn-sm" id="edit_btnc-'+id+'" data-id="'+id+'">Reject</button>' + 
						'<button type="button" class="btn btn-primary btn-sm" id="edit_btn-'+id+'" data-id="'+id+'">Accept</button>' + 
					'</div>' +	*/
				'</div>' + 
			'</div>';
	}

	function get_order_html(i,id,name,thumb,price,stock,unit,status){
		return ''+
			'<div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2" id="item_'+id+'">' + 
				'<div class="card border border-1 border-secondary">' + 
					/* '<div class="card-header p-2">' + 
						'<h6 class="card-title mb-0 text-center">'+id+' : '+name+'</h6>' + 
					'</div>' +	*/
					'<div class="card-body p-0">' +
					'<img class="card-img-top" src="./thumbs/default.jpg" alt="Card image cap" id="thumb1_'+id+'">' + 
						'<ul class="list-group list-group-flush">' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Order ID:</b> '+id+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Product ID:</b> '+price+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Product Name:</b> '+stock+' '+unit+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Status:</b> <small>'+status+'</small></li>' + 
						'</ul>' + 
					'</div>' +
					'<div class="kb card-footer d-flex align-content-center flex-wrap justify-content-between">' + 
						'<button type="button" class="btn btn-secondary btn-sm" id="newOrderRejectBtn-'+id+'" data-id="'+id+'">Reject</button>' + 
						'<button type="button" class="btn btn-primary btn-sm" id="newOrderAcceptBtn-'+id+'" data-id="'+id+'">Accept</button>' + 
					'</div>' + 
				'</div>' + 
			'</div>';
	}
</script>