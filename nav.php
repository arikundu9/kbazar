<?php
$nav=[	
		'dashboard.php'=>['Dashboard','','dashboard'],
		'products.php'=>['Products','','box'],
		'sales.php'=>['Sales','','monitor'],
		'customers.php'=>['Customers','','dollar'],
		'kbazar_v2'=>['Home','','cog']
	];

$script=basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$nav[$script][1]='active';
?>
<div class="container-fluid position-sticky mb-0 rbn">
	<div class="row">
		<div class="col p-0">
			<div class="xrb-left ml-auto"></div>
		</div>
		<div class="col-12 p-0">
			<nav class="navbar navbar-expand-md navbar-dark bg-dark py-0 px-0 sori_nav border-0">
				<div class="mx-auto">KBazar</div>
				<button class="navbar-toggler py-2 border-0 xw-100 text-center btn-drop" type="button" data-toggle="collapse" 
						data-target="#navbarCollapse2" aria-controls="navbarCollapse2" 
						aria-expanded="false" aria-label="Toggle navigation">
					<span class="oi oi-grid-three-up"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarCollapse2">
					<div class="d-flex justify-content-around my-2 my-md-0 my-lg-0 my-xl-0">
						<a class="btn btn-light btn-sm mr-2" href="logout.php"><span class="oi oi-power-standby mr-1"></span>Logout</a>
					</div>
					<ul class="navbar-nav mr-auto font-roboto-bold">
						<?php
						foreach($nav as $k=>$v){
							echo '
						<li class="nav-item text-center '.$v[1].'">
							<a class="nav-link px-3" href="'.$k.'"><span class="oi oi-'.$v[2].' mr-2 top-2"></span>'.@$v[0].'</a>
						</li>';
						}
						?>

					</ul>
				</div>
			</nav>
		</div>
		<div class="col p-0">
			<div class="xrb-right mr-auto"></div>
		</div>
	</div>
</div>