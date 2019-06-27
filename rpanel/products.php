<?php
include 'check_login.php';
$title="Products :: KBazar.";
include 'header.php';
?>
<body>
	<?php	//include 'head.php';
			include 'nav.php'; 
			include 'msg.php';
	?>
	
	<div style="position:fixed;top:0;left:0;width:100%;height:100%;z-index:1053;background:#ffffff75;display:none;" id="loading">
		<div class="d-flex justify-content-center align-items-center w-100 h-100">
			<div class="xspinner-border spinner-grow" style="width: 6rem; height: 6rem;" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h6 class="modal-title" id="exampleModalLabel"><strong>Add New Product</strong></h6>
					<button type="button" class="close pr-4" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form name="addnew" method="post">
						<div class="form-group row">
							<label for="thumb" class="col-3 col-form-label"><b>Thumb:</b></label>
							<div class="col-3">
								<img class="card-img-top" src="./thumbs/default.jpg" id="img1" alt="Card image cap">
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="thumb1" name="thumb1"/>
									<label class="custom-file-label " for="thumb1">Thumb 1</label>
								</div>
							</div>
							<div class="col-3">
								<img class="card-img-top" src="./thumbs/default.jpg" id="img2"  alt="Card image cap">
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="thumb2" name="thumb2"/>
									<label class="custom-file-label" for="thumb2">Thumb 2</label>
								</div>
							</div>
							<div class="col-3">
								<img class="card-img-top" src="./thumbs/default.jpg" id="img3"  alt="Card image cap">
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="thumb3" name="thumb3"/>
									<label class="custom-file-label" for="thumb3">Thumb 3</label>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="name" class="col-2 col-form-label"><b>Name:</b></label>
							<div class="col-10">
								<input type="text" class="form-control" id="name" name="name"/>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
							<label for="munit" class="col-form-label"><b>Measurement Unit:</b></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">Select </div>
								</div>
								<select class="custom-select" name="munit" id="munit">
									<option value="0">Unit</option>
									<optgroup label="Count">
										<option value="piece">Piece</option>
										<option value="packet">Packet</option>
										<option value="dibba">Dibba</option>
										<option value="bosta">Bosta</option>
									</optgroup>
									<optgroup label="Weight">
										<option value="kg">Kilogram</option>
										<option value="g">Gram</option>
									</optgroup>
									<optgroup label="Length">
										<option value="miter">Miter</option>
										<option value="feet">Feet</option>
										<option value="cm">cm</option>
										<option value="gauge">Gauge</option>
									</optgroup>
									<optgroup label="Volumn">
										<option value="liter">Liter</option>
									</optgroup>
									<option value=""></option>
								</select>
							</div>
							</div>
							<div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
								<label for="price" class="col-form-label"><b>Price Per <span id="pp">Unit</span>:</b></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">₹ </div>
									</div>
									<input type="number" min="0" class="form-control" id="price" name="price"/>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
								<label for="stock" class="col-form-label"><b>Stock:</b></label>
								<div class="input-group">
									<input type="number" min="0" class="form-control" id="stock" name="stock"/>
									<div class="input-group-append">
										<div class="input-group-text" id="stock_unit">Unit.</div>
									</div>
								</div>
							</div>
							<div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 mt-1">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" checked="checked" class="custom-control-input" id="salebility" name="salebility"/>
									<label class="custom-control-label" for="salebility">Enable for sale</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="refund" name="refund"/>
									<label class="custom-control-label" for="refund">Refundable Product ?</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="replace" name="replace"/>
									<label class="custom-control-label" for="replace">Replaceable Product ?</label>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="minsale" class="col-12 col-sm-4 col-md-4 col-lg-3 col-form-label"><b>Minimum Sale:</b></label>
							<div class="col-12 col-sm-8 col-md-8 col-lg-9">
								<div class="input-group">
									<input type="number" value="1" min="1" class="form-control" id="minsale" name="minsale"/>
									<div class="input-group-append">
										<div class="input-group-text" id="stock_unit_min">Unit.</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="description" class="col-form-label"><b>Description:</b></label>
							<textarea class="form-control" id="description" name="description"></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer p-2">
					<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" id="addp">
						<div class="spinner-border spinner-border-sm mr-1" style="display:none;margin-bottom:1px !important;" id="save_spinner" role="status">
							<span class="sr-only">Loading...</span>
						</div>Save
					</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h6 class="modal-title" id="exampleModalLabel"><strong>Edit Product</strong></h6>
					<button type="button" class="close pr-4" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form name="editp" method="post">
						<input type="hidden" name="epid" id="epid" value=""/>
						<div class="form-group row">
							<label for="thumb" class="col-3 col-form-label"><b>Thumb:</b></label>
							<div class="col-3">
								<img class="card-img-top" src="./thumbs/default.jpg" id="eimg1" alt="Card image cap">
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="ethumb1" name="thumb1"/>
									<label class="custom-file-label " for="ethumb1">Thumb 1</label>
								</div>
							</div>
							<div class="col-3">
								<img class="card-img-top" src="./thumbs/default.jpg" id="eimg2"  alt="Card image cap">
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="ethumb2" name="thumb2"/>
									<label class="custom-file-label" for="ethumb2">Thumb 2</label>
								</div>
							</div>
							<div class="col-3">
								<img class="card-img-top" src="./thumbs/default.jpg" id="eimg3"  alt="Card image cap">
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="ethumb3" name="thumb3"/>
									<label class="custom-file-label" for="ethumb3">Thumb 3</label>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="ename" class="col-2 col-form-label"><b>Name:</b></label>
							<div class="col-10">
								<input type="text" class="form-control" id="ename" name="name"/>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
							<label for="emunit" class="col-form-label"><b>Measurement Unit:</b></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">Select </div>
								</div>
								<select class="custom-select" name="munit" id="emunit">
									<option value="0">Unit</option>
									<optgroup label="Count">
										<option value="2">Piece</option>
										<option value="1">Packet</option>
										<option value="3">Dibba</option>
										<option value="4">Bosta</option>
									</optgroup>
									<optgroup label="Weight">
										<option value="5">Kilogram</option>
										<option value="6">Gram</option>
									</optgroup>
									<optgroup label="Length">
										<option value="7">Miter</option>
										<option value="8">Feet</option>
										<option value="9">cm</option>
										<option value="10">Gauge</option>
									</optgroup>
									<optgroup label="Volumn">
										<option value="11">Liter</option>
									</optgroup>
									<option value=""></option>
								</select>
							</div>
							</div>
							<div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
								<label for="price" class="col-form-label"><b>Price Per <span id="epp">Unit</span>:</b></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">₹ </div>
									</div>
									<input type="number" min="0" class="form-control" id="eprice" name="price"/>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
								<label for="stock" class="col-form-label"><b>Stock:</b></label>
								<div class="input-group">
									<input type="number" min="0" class="form-control" id="estock" name="stock"/>
									<div class="input-group-append">
										<div class="input-group-text" id="estock_unit">Unit.</div>
									</div>
								</div>
							</div>
							<div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 mt-1">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" checked="checked" class="custom-control-input" id="esalebility" name="salebility"/>
									<label class="custom-control-label" for="esalebility">Enable for sale</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="erefund" name="refund"/>
									<label class="custom-control-label" for="erefund">Refundable Product ?</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="ereplace" name="replace"/>
									<label class="custom-control-label" for="ereplace">Replaceable Product ?</label>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="minsale" class="col-12 col-sm-4 col-md-4 col-lg-3 col-form-label"><b>Minimum Sale:</b></label>
							<div class="col-12 col-sm-8 col-md-8 col-lg-9">
								<div class="input-group">
									<input type="number" value="1" min="1" class="form-control" id="eminsale" name="minsale"/>
									<div class="input-group-append">
										<div class="input-group-text" id="estock_unit_min">Unit.</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="description" class="col-form-label"><b>Description:</b></label>
							<textarea class="form-control" id="edescription" name="description"></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer p-2">
					<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" id="eaddp">
						<div class="spinner-border spinner-border-sm mr-1" style="display:none;margin-bottom:1px !important;" id="edit_spinner" role="status">
							<span class="sr-only">Loading...</span>
						</div>Save
					</button>
				</div>
			</div>
		</div>
	</div>
	
	
	<div id="mg" align="center"></div>
	
	<div id="notice_panel"></div>
	
	<main role="main" class="container-fluid mt-3">
		<nav aria-label="Page navigation example">
			<ul class="pagination justify-content-center" id="pagination">
			</ul>
		</nav>
		<div class="row justify-content-center" id="crow">
		</div>
	</main>
	
	<div class="d-block" style="height:50px;"></div>
	<nav class="navbar navbar-expand-md fixed-bottom navbar-dark bg-dark xd-flex xalign-content-center xflex-wrap xjustify-content-between">
		<div class="navbar-collapse collapse p-2 p-md-0 p-lg-0 p-xl-0" id="navbarCollapse" style="">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="http://sorisoft.ml/">KBazar <span class="sr-only">(current)</span></a>
				</li>
				<!--<li class="nav-item">
					<a class="nav-link" href="#">Link</a>
				</li>-->
				<li class="nav-item dropup">
					<a class="nav-link dropdown-toggle" href="#" id="dropdown10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter Products</a>
					<div class="dropdown-menu bottom_dropdown" aria-labelledby="dropdown10">
						<a class="dropdown-item text-light" href="#" id="filter_id" data-filter="id">By ID</a>
						<a class="dropdown-item text-light" href="#" id="filter_name" data-filter="name">By Name</a>
						<a class="dropdown-item text-light" href="#" id="filter_price" data-filter="price">By Price</a>
						<a class="dropdown-item text-light" href="#" id="filter_nos" data-filter="nos">By No of Stock</a>
						<a class="dropdown-item text-light" href="#" id="filter_sale" data-filter="sale">By No of Sale</a>
						<a class="dropdown-item text-light" href="#" id="filter_default" data-filter="default">Default Filter</a>
					</div>
				</li>
			</ul>
			<form class="form-inline my-2 my-sm-0 mr-sm-2" method="get" action="#">
				<div class="input-group">
					<input class="form-control form-control-sm" id="pids" name="pid" type="text" placeholder="Enter Product ID" aria-label="Search"/>
					<button class="input-group-append btn btn-outline-success" id="pidsb" type="button"><span class="oi oi-magnifying-glass top-0"></span></button>
				</div>
			</form>
		</div>
		<button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="oi oi-chevron-top top--1"></span>
		</button>
		<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg"><span class="oi oi-plus xmr-2 top-2"></span></button>
		<button type="button" class="btn btn-primary btn-sm ml-1" onclick="load_info()"><span class="oi oi-reload xmr-2 top-2"></span></button>
	</nav>
	<?php //include 'foot.php';?>
</body>
<?php include 'footer.php';?>
<script>
	var Info=null;
	var toast=100;
	var ipp=12;
	var c_page=1;
	var Filter='default';

	$('#munit').on('change',function(){
		var u=$('#munit option:selected').text();
		$('#stock_unit').text(u);
		$('#stock_unit_min').text(u);
		$('#pp').text(u);
	});

	$('#emunit').on('change',function(){
		var u=$('#emunit option:selected').text();
		$('#estock_unit').text(u);
		$('#estock_unit_min').text(u);
		$('#epp').text(u);
	});

	$('#pagination').on('load',function(){
		$('[id^=page-]').on('click',function(){
			render_items($(this).attr('data-page'));
		});
	});

	$('#pidsb').on('click',function(){
		pid=$('#pids').val();
		f=false;
		Item=null;
		$.each(Info.body,function(i,item){
			if(pid === item.id){
				f=true;
				Item=item;
			}
		});
		if(f){
			//$('#pagination').html('');
			$('#crow').html('');
			$('#crow').append(get_item_html(0,Item.id,Item.name,Item.thumb1,Item.price,Item.stock,Info.units[Item.stock_unit],Item.status));
			$('#crow').trigger('load');
		}
		else
			$('#crow').html('not founnd!');
	});
	
	$('#crow').on('load',function(){
		$('[id^=edit_btn-]').on('click',function(){
			let id=parseInt($(this).attr('data-id'));
			$.each(Info.body,function(i,item){
				if(id === parseInt(item.id)){
					$('#epid').val(id);
					$('#eimg1').attr('src','./thumbs/'+item.thumb1);
					$('#eimg2').attr('src','./thumbs/'+item.thumb2);
					$('#eimg3').attr('src','./thumbs/'+item.thumb3);
					$('#ename').val(item.name);
					$('#emunit').val(item.stock_unit);
					$('#emunit').trigger('change');
					$('#eprice').val(item.price);
					$('#estock').val(item.stock);
					$('#eminsale').val(item.min_sale);
					$('#edescription').val(item.description);
					if(item.return_replace==='both')
						$('#erefund,#ereplace').attr('checked',true);
					if(item.return_replace==='none')
						$('#erefund,#ereplace').attr('checked',false);
					if(item.return_replace==='only_returnable'){
						$('#erefund').attr('checked',true);
						$('#ereplace').attr('checked',false);
					}
					if(item.return_replace==='only_replaceable'){
						$('#erefund').attr('checked',false);
						$('#ereplace').attr('checked',true);
					}
					if(item.status==='enabled')
						$('#esalebility').attr('checked',true);
					else
						$('#esalebility').attr('checked',false);
					$('#edit_modal').modal('show');
				}
			});
		});
	});

	$(document).ready(function(){
		loadThumb('#thumb1','#img1');
		loadThumb('#thumb2','#img2');
		loadThumb('#thumb3','#img3');
		loadThumb('#ethumb1','#eimg1');
		loadThumb('#ethumb2','#eimg2');
		loadThumb('#ethumb3','#eimg3');
		$('[id^=filter_]').on('click',function(){
			Filter=$(this).attr('data-filter');
			$('[id^=filter_]').removeClass('active');
			$(this).addClass('active');
			load_info();
		});
		load_info();
	});
	
	$('#add_modal').onSwipe({direction:'right'},function(){
		$('#add_modal').modal('hide');
	});

	$('#edit_modal').onSwipe({direction:'right'},function(){
		$('#edit_modal').modal('hide');
	});

	$(document).ajaxStart(function(){
		$("#loading").show();
	});

	$(document).ajaxComplete(function(){
		$("#loading").hide();
	});
	
	$('#addp').on('click',function(){
		if($('#name').val().length <= 0){
			post_toast('Invalid Input','Product Name can\'t be empty');
			$('#name').focus();
		}
		else if($('#munit').val() === '0'){
			post_toast('Invalid Input','Select a specific Measurement Unit');
			$('#munit').focus();
		}
		else if($('#price').val().length <= 0){
			post_toast('Invalid Input','Price can\'t be blank');
			$('#price').focus();
		}
		else if($('#stock').val().length <= 0){
			post_toast('Invalid Input','Stock can\'t be blank');
			$('#stock').focus();
		}
		else if($('#minsale').val().length <= 0){
			post_toast('Invalid Input','Minimun Sale can\'t be empty');
			$('#minsale').focus();
		}
		else{
			dataa=new FormData();
			dataa.append('cmd','AddProduct');
			dataa.append('thumb1',$('#thumb1')[0].files[0] );
			dataa.append('thumb2',$('#thumb2')[0].files[0] );
			dataa.append('thumb3',$('#thumb3')[0].files[0] );
			dataa.append('name',$('#name').val());
			dataa.append('munit',$('#munit').val());
			dataa.append('price',$('#price').val());
			dataa.append('stock',$('#stock').val());
			dataa.append('salebility',$('#salebility').prop('checked') ? 'enabled' : 'disabled');
			dataa.append('refund',$('#refund').prop('checked'));
			dataa.append('replace',$('#replace').prop('checked'));
			dataa.append('minsale',$('#minsale').val());
			dataa.append('description',$('#description').val());
			$.ajax({
				method : 'POST',
				url: './ajax/products.ajax.php',
				data: dataa,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function(){
					$('#save_spinner').show();
				},
				complete: function(){
					$('#save_spinner').hide();
				},
				success: function(msg){
					//console.log(msg);
				}
			})
			.done(function(ret){
				response=$.parseJSON(ret);
				if(response.header.login==true){
					pid=response.body.pid;
					post_toast('Item Added',
							'<b>ID:</b> '+pid+'<br>'+
							'<b>Name:</b> '+dataa.get('name')+'<br>'+
							'<b>Price:</b> ₹'+dataa.get('price')+' / '+dataa.get('munit')
					);
					load_info();
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
	});

	$('#eaddp').on('click',function(){
		if($('#ename').val().length <= 0){
			post_toast('Invalid Input','Product Name can\'t be empty');
			$('#ename').focus();
		}
		else if($('#emunit').val() === '0'){
			post_toast('Invalid Input','Select a specific Measurement Unit');
			$('#emunit').focus();
		}
		else if($('#eprice').val().length <= 0){
			post_toast('Invalid Input','Price can\'t be blank');
			$('#eprice').focus();
		}
		else if($('#estock').val().length <= 0){
			post_toast('Invalid Input','Stock can\'t be blank');
			$('#estock').focus();
		}
		else if($('#eminsale').val().length <= 0){
			post_toast('Invalid Input','Minimun Sale can\'t be empty');
			$('#eminsale').focus();
		}
		else{
			dataa=new FormData();
			dataa.append('cmd','EditProduct');
			dataa.append('thumb1',$('#ethumb1')[0].files[0] );
			dataa.append('thumb2',$('#ethumb2')[0].files[0] );
			dataa.append('thumb3',$('#ethumb3')[0].files[0] );
			dataa.append('pid',$('#epid').val());
			dataa.append('name',$('#ename').val());
			dataa.append('munit',$('#emunit').val());
			dataa.append('price',$('#eprice').val());
			dataa.append('stock',$('#estock').val());
			dataa.append('salebility',$('#esalebility').prop('checked') ? 'enabled' : 'disabled');
			dataa.append('refund',$('#erefund').prop('checked'));
			dataa.append('replace',$('#ereplace').prop('checked'));
			dataa.append('minsale',$('#eminsale').val());
			dataa.append('description',$('#edescription').val());
			$.ajax({
				method : 'POST',
				url: './ajax/products.ajax.php',
				data: dataa,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function(){
					$('#edit_spinner').show();
				},
				complete: function(){
					$('#edit_spinner').hide();
				},
				success: function(msg){
					//console.log(msg);
				}
			})
			.done(function(ret){
				response=$.parseJSON(ret);
				if(response.header.login==true){
					pid=response.body.pid;
					//console.log(response);
					/*post_toast('Item Modified',
							'<b>ID:</b> '+pid+'<br>'+
							'<b>Name:</b> '+dataa.get('name')+'<br>'+
							'<b>Price:</b> ₹'+dataa.get('price')+' / '+dataa.get('munit')'body'
					);*/
					post_toast('Intem Modified','Modified successfully');
					load_info();
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
	});

	function render_items(cpage){
		cpage=parseInt(cpage);
		c_page=cpage;
		$('#crow').html('');
		var total=Info.body.length;
		var t_page=parseInt((total/ipp).toFixed(0));
		if(t_page*ipp < total)
			t_page++;
		var lb=(cpage-1)*ipp;
		var ub=lb+ipp-1;
		$('#pagination').html('');
		//$('#pagination').append('<li class="page-item disabled" id="prev"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Prev</a></li>');
		for(i=1;i<=t_page;i++){
			$('#pagination').append(get_page_html(i,cpage));
		}
		//$('#pagination').append('<li class="page-item" id="next"><a class="page-link" href="#">Next</a></li>');
		$('#pagination').trigger('load');
		$.each(Info.body,function(i,item){
			if(i>=lb && i<=ub)
				$('#crow').append(get_item_html(i,item.id,item.name,item.thumb1,item.price,item.stock,Info.units[item.stock_unit],item.status));
		});
		$('#crow').trigger('load');
	}

	function load_info() {
		$.getJSON('./ajax/products.ajax.php',{
			cmd:'GetList',
			filter: Filter
		})
		.done(function(response){
			if(response.header.login==true){
				Info=response;
				render_items(c_page);
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

	function get_page_html(i,c){
		c=parseInt(c);
		if(i===c)
			return '<li class="page-item disabled" id="page-'+i+'" data-page="'+i+'"><a class="page-link" href="#'+i+'">'+i+'</a></li>';
		else
			return '<li class="page-item" id="page-'+i+'" data-page="'+i+'"><a class="page-link" href="#'+i+'">'+i+'</a></li>';
	}

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
	
	function get_item_html(i,id,name,thumb,price,stock,unit,status){
		return ''+
			'<div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mb-3" id="item_'+id+'">' + 
				'<div class="card kb-card">' + 
					'<div class="card-header kb-card-header kb-card-header-login">' + 
						'<h6 class="card-title mb-0 text-center">'+id+' : '+name+'</h6>' + 
					'</div>' + 
					'<img class="card-img-top kb-card-img-top" src="./thumbs/'+thumb+'" alt="Card image cap" id="thumb1_'+id+'">' + 
						'<ul class="list-group list-group-flush">' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Price:</b> ₹'+price+'/-</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Stock:</b> '+stock+' '+unit+'</li>' + 
							'<li class="kb list-group-item border-left-0 border-right-0"><b>Status:</b> '+status+'</li>' + 
						'</ul>' + 
					'<div class="kb card-footer d-flex align-content-center flex-wrap justify-content-between">' + 
						'<button type="button" class="btn btn-primary btn-sm" id="edit_btn-'+id+'" data-id="'+id+'">Edit</button>' + 
					'</div>' + 
				'</div>' + 
			'</div>';
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

	function loadTHUMB1(id) {
		input=$('#thumb1')[0];
		if (input.files && input.files[0]) {
			$('#thumb1_'+id+'').attr('src', './thumbs/'+id+'_thumb1.jpg');
			/*var reader = new FileReader();
			reader.onload = function(e){
				console.log(e);
				$('#thumb1_'+id+'').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);*/
		}
		else{
			$('#thumb1_'+id+'').attr('src', './thumbs/default.jpg');
		}
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

	function loadThumb(input,img){
		$(input).on( 'change', function() {
			myfile= $( this ).val();
			var ext = myfile.split('.').pop();
			if(ext=="png" || ext=="jpg" || ext=="jpeg"){
				readURL(this);
				//$(img).attr('src', '../img/pdf.png');
			}
			else{
				$(this).val('');
				$(img).attr('src', './thumbs/default.jpg');
				alert('Only .jpg/.jpeg , .png files are allowed.');
			}
		});
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$(img).attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			}
		}
	}
</script>
