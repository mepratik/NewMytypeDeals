<!doctype html>
<?php 
	session_start();
	include_once('config.php');
	$conf=new configure();
	try
	{
		$dbh=new PDO("mysql:dbname=$conf->dbname;host=$conf->host","$conf->uname","$conf->pass");
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
?>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="cake,food items,flowers,clothes,electronic,deals,dehradun,cart">
	<meta name="description" content="mytypedeals item details page">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<meta name="author" content="Nishkarsh Sharma">
	<title>MyTypeDeals - Deal Details</title>
	<link rel="stylesheet" href="css/mytypedeals.css">
	<link rel="stylesheet" href="bootstrap-3.1.1-dist/css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/smooth-scroll.js"></script>
	<script src="bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>
	<script src="js/mytypedeals.js"></script>
</head>
<body>
	<div class="container">
		<header>
			<?php include_once('header.php'); ?>
		</header>
		
		<!-- main parts start now -->
		<section id="main">
			<?php
				//$date=Date('y'/'m''d');
				$stmt=$dbh->prepare("SELECT * FROM deals, images, dealers WHERE (deals.did=:did AND deals.iid=images.iid AND deals.dealerid=dealers.dealerid) AND (instock <> 0 AND active <> 0 AND validupto > '$date')");
				$stmt->bindParam(":did",$_GET['did']);
				$stmt->execute();
				$num_deals=$stmt->rowCount();
				if($num_deals != 1)
					echo "<h6 class=text-danger>Invalid Deal! Please try again...</h6>";
				else
				{
					$deal=$stmt->fetch();
					$discount=$deal['originalprice'] - $deal['price'];
					$desc=explode(';',$deal['desc']);
					$features=explode(';',$deal['features']);
					$otherdetails=explode(';',$deal['otherdetails']);
					$warranty=explode(';',$deal['warranty']);
					print <<<DEAL
						<div class="row">
							<div class="col-sm-3">
								<img src="{$deal['path']}" class="img-responsive img-thumbnail" height="250px" width="250px">
							</div>
							<div class="col-sm-6">
								<div id="dealname" style="border-bottom:1px dashed grey;">
									<h4>{$deal['title']}</h4>
									<caption><small>by {$deal['dealername']}</small></caption>
								</div>
								<br>
								<ul class="list-unstyled" style="font-size:13px;color:grey;">
								<li>Price: <span class="originalprice">Rs. {$deal['originalprice']}</span></li>
								<li>Our Price: <span class="price"><b>Rs. {$deal['price']}</b></span></li>
								<li>You Save: Rs. {$discount}</li>
								</ul>
							</div>
							<div class="col-sm-3">
							</div>
						</div>
						<div class="row dealdiscription">
							<div class="col-sm-12">
								<h5 class="componentheading">About The Deal</h5>
							</div>
						</div>
						<div class="row dealcontent">
							<div class="col-sm-4">
								<h6 class="componentsubheading">Deal Description</h6>
DEAL;
							
								for($i=0;$i<count($desc);$i++)
									echo "<p class='content'>".$desc[$i]."</p>";
							echo "</div>";
							echo "<div class='col-sm-4'>";
								echo "<h6 class='componentsubheading'>Deal Features</h6>";
								for($i=0;$i<count($features);$i++)
									echo "<p class='content'>".$features[$i]."</p>";
							echo "</div>";
							echo "<div class='col-sm-4'>";
								echo "<h6 class='componentsubheading'>Other Details</h6>";
								for($i=0;$i<count($otherdetails);$i++)
									echo "<p class='content'>".$otherdetails[$i]."</p>";
							echo "</div>";
						echo "</div>";
							echo "<div class='row dealcontent'>";
							echo "<div class='col-sm-12'>";
								echo "<h6 class='componentsubheading'>Warranty</h6>";
								for($i=0;$i<count($warranty);$i++)
									echo "<p class='content'>".$warranty[$i]."</p>";
							echo "</div>";
						echo "</div>";
				}
			?>
		</section>	
		
		<!-- deals come here using ajax -->
		<section id="deals">
			<div id="dealsresults" class="row" style="margin-left:0px;">
			</div>
		</section>
		
		<!-- search results come here using ajax -->
		<section id="searchresults">
			<div id="results" class="row" style="margin-left:0px;">
			</div>
		</section>
		
		<footer>
			<?php include_once('footer.php'); ?>
		</footer>
	</div> <!-- end of container -->
</body>
</html>