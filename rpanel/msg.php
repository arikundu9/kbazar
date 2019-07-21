<?php
$change_c=['red'=>'danger','green'=>'success','info'=>'warning'];
if(isset($_SESSION['msg']) and !@$ajax) {
		$ast=explode('#',$_SESSION['msg']);
		foreach($ast as $stv) {
			$st=explode('|',$stv);
			echo '
				<div class="container" id="mSg">
					<div class="row justify-content-center">
						<div class="col-10 col-sm-10 col-md-4 col-lg-4 alert alert-'.@$change_c[$st[0]].' alert-dismissible fade show mt-2 shadow" role="alert" id="galrt">
							<div class="i_i">'.@$st[1].'</div>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
				</div>';
		}
		unset($_SESSION['msg']);
	}
?>