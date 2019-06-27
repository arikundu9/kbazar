<?php
$title="Welcome To KBazar.";
include 'header.php';
?>
<body>
	<?php include 'head.php'; ?>
	<?php include 'nav.php'; ?>
	
	<div id="slides" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#slides" data-slide-to="0" class=""></li>
          <li data-target="#slides" data-slide-to="1" class=""></li>
          <li data-target="#slides" data-slide-to="2" class="active"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item">
            <img class="first-slide d-block w-100" src="./b4.jpg" alt="First slide">
            <div class="container">
              <!--<div class="carousel-caption text-left">
                <h1>Example headline.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
              </div>-->
            </div>
          </div>
          <div class="carousel-item">
            <img class="second-slide d-block w-100" src="./b2.jpg" alt="Second slide">
            <div class="container">
              <!--<div class="carousel-caption">
                <h1>Another example headline.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
              </div>-->
            </div>
          </div>
          <div class="carousel-item active">
            <img class="third-slide d-block w-100" src="./b3.jpg" alt="Third slide">
            <div class="container">
              <!--<div class="carousel-caption text-right">
                <h1>One more for good measure.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
              </div>-->
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#slides" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#slides" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
	
	<main role="main" class="container mt-3">
		<div class="main-container text-center">
			<h2>Welcome To<br> Susunia Pvt. Ltd.</h2>
		</div>
	</main>
	
	<?php include 'foot.php';?>
</body>
<?php include 'footer.php';?>
