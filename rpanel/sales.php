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
				<a class="nav-link" href="#" data-tab="2">Replace/Refund Requests</a>
			</li>
			<li class="nav-item tab" id="sterminated_tab">
				<a class="nav-link" href="#" data-tab="3">Semi-Terminated Orders</a>
			</li>
			<li class="nav-item tab" id="terminated_tab">
				<a class="nav-link" href="#" data-tab="4">Terminated Orders</a>
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
						<a class="nav-link" href="#">Replace/Refund</a>
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
			<!--<div class="card-footer d-flex align-content-center flex-wrap justify-content-between p-2">
				<button type="button" class="btn btn-secondary btn-sm">Cancel Selected</button>
				<button type="button" class="btn btn-primary btn-sm">Accept Selected</button>
			</div>-->
		</div>
	</main>
	
	<?php //include 'foot.php';?>
</body>
<?php include 'footer.php';?>
<script>
	var RESPONSE=null;
	var toast=100;
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
		$('#sterminated_tab').on('click',function(){
			$('[data-tab]').removeClass('active');
			$('.nav-link',this).addClass('active');
			reload(function(response){
				$('#render_panel').html('');
				$.each(response.body,function(i,order){
					if(order.status === 'Delevered' || order.status === 'Refund Rejected' || order.status === 'Replace Rejected' || order.status === 'Replaced'){
						$('#render_panel').append(get_order_html(order));
					}
				});
				$('#render_panel').trigger('loaded');
			});
		});
		$('#terminated_tab').on('click',function(){
			$('[data-tab]').removeClass('active');
			$('.nav-link',this).addClass('active');
			reload(function(response){
				$('#render_panel').html('');
				$.each(response.body,function(i,order){
					if(order.status === 'Rejected' || order.status === 'Canceled' || order.status === 'Refunded'){
						$('#render_panel').append(get_order_html(order));
					}
				});
				$('#render_panel').trigger('loaded');
			});
		});
	});
	
	$('#render_panel').on('loaded',function(){
		$('[id^=newOrderRejectBtn-]').on('click',function(){
			let id=parseInt($(this).attr('data-id'));
			//console.log('id reject '+id+' clicked.');
			$.each(RESPONSE.body,function(i,item){
				if(item.oid==id){
					edit_order_and_do(item,'Rejected',function(response){
						render_new_orders();
						post_toast('Order Rejected','Order (OID: '+item.oid+') is rejected successfully.');
						$('#mg').html(get_alert_html(response.msg.degree,response.msg.body));
						//console.log('he he he he',response);
					});
				}
			});
		});
		$('[id^=newOrderAcceptBtn-]').on('click',function(){
			let id=parseInt($(this).attr('data-id'));
			//console.log('id accept '+id+' clicked.');
			//console.log(RESPONSE);
			$.each(RESPONSE.body,function(i,item){
				if(item.oid==id){
					edit_order_and_do(item,'Accepted',function(response){
						render_new_orders();
						post_toast('Order Accepted','Order (OID: '+item.oid+') is accepted successfully.<br>Pack the order, to be picked by Delevery Man soon.');
						$('#mg').html(get_alert_html(response.msg.degree,response.msg.body));
						//console.log('he he he he',response);
					});
				}
			});
		});
		$('[id^=rrRejectBtn-]').on('click',function(){
			let id=parseInt($(this).attr('data-id'));
			//console.log('id rr_reject '+id+' clicked.');
			$.each(RESPONSE.body,function(i,item){
				if(item.oid==id){
					edit_order_and_do(item,'Rejected',function(response){
						render_rr_orders();
						post_toast('Request Rejected','Return/Replace request (OID: '+item.oid+') is rejected successfully.');
						$('#mg').html(get_alert_html(response.msg.degree,response.msg.body));
						//console.log('he he he he',response);
					});
				}
			});
		});
		$('[id^=rrAcceptBtn-]').on('click',function(){
			let id=parseInt($(this).attr('data-id'));
			//console.log('id rr_accept '+id+' clicked.');
			$.each(RESPONSE.body,function(i,item){
				if(item.oid==id){
					edit_order_and_do(item,'Accepted',function(response){
						render_rr_orders();
						post_toast('Request Accepted','Return/Replace request (OID: '+item.oid+') is accepted successfully.');
						$('#mg').html(get_alert_html(response.msg.degree,response.msg.body));
						//console.log('he he he he',response);
					});
				}
			});
		});
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
	
	function post_toast(title,body){
		$('#notice_panel').prepend(
			get_toast_html(++toast,title,get_time(),body)
		);
		$('#toast'+toast).toast('show');
		/*$('#toast'+toast).on('shown.bs.toast', function () {
			$(this).onSwipe({direction:'right'},function(){
				$(this).toast('hide');
			});
		});*/
		$('#toast'+toast).on('shown.bs.toast', function () {
			$(this).onSwipe({direction:'right'},$.proxy(function(){
				$(this).toast('hide');
			},this));
		});
	}
	
	function render_new_orders(){
		$('#render_panel').html('');
		reload(function(response){
			$.each(response.body,function(i,e){
				if(e.status === 'New' || e.status === 'Accepted' || e.status === 'Picked')
					$('#render_panel').append(get_order_html(e));
				//console.log(e);
			});
			$('#render_panel').trigger('loaded');
		});
	}

	function render_rr_orders(){
		$('#render_panel').html('');
		reload(function(response){
			$.each(response.body,function(i,e){
				if(e.status === 'Refund Requested' || e.status === 'Refund Accepted' || e.status === 'Refund Picked' || e.status === 'Replace Requested' || e.status === 'Replace Accepted' || e.status === 'Replace Picked' || e.status === 'Exchanged')
					$('#render_panel').append(get_rrorder_html(e));
				//console.log(e);
			});
			$('#render_panel').trigger('loaded');
		});
	}

	function get_rrorder_html(e){
		data=$.parseJSON(e.order_data);
		r = ''+
			'<div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2" id="item_'+e.oid+'">' + 
				'<div class="card border border-1 border-secondary">' + 
					/* '<div class="card-header p-2">' + 
						'<h6 class="card-title mb-0 text-center">'+id+' : '+name+'</h6>' + 
					'</div>' +	*/
					'<div class="card-body p-0">' +
					'<img class="card-img-top" src="./thumbs/'+e.thumb1+'" alt="Card image cap" id="thumb1_'+e.oid+'">' + 
						'<ul class="list-group list-group-flush">' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Order ID:</b> '+e.oid+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Product ID:</b> '+e.pid+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Product Name:</b> '+e.name+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Ordered:</b> '+data.ordered_unit+' '+RESPONSE.units[data.suid]+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Total Price:</b> '+data.ordered_unit+'x'+data.ppu+'=₹<strong>'+ data.ordered_unit * data.ppu +'</strong>/-</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Status:</b> <small>'+e.status+'</small></li>';
			if(e.status === 'Refund Requested' || e.status === 'Replace Requested'){
				r+=			'<li class="kb list-group-item border-left-0 border-right-0 text-center p-1">' +
								'<button type="button" class="btn btn-primary btn-sm w-100" id="rrAcceptBtn-'+e.oid+'" data-id="'+e.oid+'">Accept</button>' + 
							'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0 text-center p-1">' +
								'<button type="button" class="btn btn-secondary btn-sm w-100" id="rrRejectBtn-'+e.oid+'" data-id="'+e.oid+'">Reject</button>' + 
							'</li>';
			}
			r+=			'</ul>' + 
					'</div>' +
					/* '<div class="kb card-footer d-flex align-content-center flex-wrap justify-content-between">' + 
						'<button type="button" class="btn btn-secondary btn-sm" id="edit_btnc-'+id+'" data-id="'+id+'">Reject</button>' + 
						'<button type="button" class="btn btn-primary btn-sm" id="edit_btn-'+id+'" data-id="'+id+'">Accept</button>' + 
					'</div>' +	*/
				'</div>' + 
			'</div>';
			return r;
	}

	function get_order_html(e){
		data=$.parseJSON(e.order_data);
		//console.log(U[data.suid]);
		r = ''+
			'<div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2" id="item_'+e.oid+'">' + 
				'<div class="card border border-1 border-secondary">' + 
					/* '<div class="card-header p-2">' + 
						'<h6 class="card-title mb-0 text-center">'+id+' : '+name+'</h6>' + 
					'</div>' +	*/
					'<div class="card-body p-0">' +
					'<img class="card-img-top" src="./thumbs/'+e.thumb1+'" alt="Card image cap" id="thumb1_'+e.oid+'">' + 
						'<ul class="list-group list-group-flush">' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Order ID:</b> '+e.oid+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Product ID:</b> '+e.pid+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Product Name:</b> '+e.name+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Ordered:</b> '+data.ordered_unit+' '+RESPONSE.units[data.suid]+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Total Price:</b> '+data.ordered_unit+'x'+data.ppu+'=₹<strong>'+ data.ordered_unit * data.ppu +'</strong>/-</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Status:</b> <small>'+e.status+'</small></li>' + 
						'</ul>' + 
					'</div>';
			if(e.status === 'New'){
			r+=		'<div class="kb card-footer d-flex align-content-center flex-wrap justify-content-between">' + 
						'<button type="button" class="btn btn-secondary btn-sm" id="newOrderRejectBtn-'+e.oid+'" data-id="'+e.oid+'">Reject</button>' + 
						'<button type="button" class="btn btn-primary btn-sm" id="newOrderAcceptBtn-'+e.oid+'" data-id="'+e.oid+'">Accept</button>' + 
					'</div>';
			}
			r+='</div>' + 
			'</div>';
		return r;
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
	
	function edit_order_and_do(item,action,calbak){
		fd=new FormData();
		fd.append('cmd','EditOrder');
		fd.append('oid',item.oid);
		fd.append('pid',item.pid);
		fd.append('cid',item.cid);
		fd.append('status',item.status);
		fd.append('action',action);
		$.ajax({
			method : 'POST',
			url: './ajax/sales.ajax.php',
			data: fd,
			cache: false,
			contentType: false,
			processData: false/* ,
			beforeSend: function(){
				$('#edit_spinner').show();
			},
			complete: function(){
				$('#edit_spinner').hide();
			},
			success: function(msg){
				//console.log(msg);
			} */
		})
		.done(function(ret){
			response=$.parseJSON(ret);
			//console.log(response);
			if(response.header.login==true){
				calbak(response);
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
	}
	
	function reload(calbak){
		$.getJSON('./ajax/sales.ajax.php',{
			cmd: 'GetOrders'
		})
		.done(function(response){
			if(response.header.login==true){
				RESPONSE=response;
				calbak(response);
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
	
</script>