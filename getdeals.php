<?php
	$scid=$_GET['scid'];
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
	
	print <<<SCRIPT
		<script>
			$(function () { $("[data-toggle='popover']").popover(); });	//enable pop overs
		</script>
SCRIPT;
	$stmt=$dbh->prepare("SELECT * FROM subcategories WHERE scid=:scid");
	$stmt->bindParam(":scid",$scid);
	$stmt->execute();
	$num_subcat=$stmt->rowCount();
	if($num_subcat == 0)
	{
		die("No subcategory found with this id. You messed up something?");
	}
	$subcat=$stmt->fetch();
	echo "<h5 class='componentheading'>{$subcat['name']}</h5>";
	$date=date('Y/m/d');
	$stmt=$dbh->prepare("SELECT * FROM deals, images WHERE (deals.scid=:scid) AND (deals.iid=images.iid) AND (instock <> 0 AND active <> 0 AND validupto > '$date')");
	$stmt->bindParam(":scid",$scid);
	$stmt->execute();
	$num_deals=$stmt->rowCount();
	if($num_deals == 0)
	{
		die("No active deals found under this category.");
	}
	for($i=0;$i<$num_deals;$i++)
	{
		$deal=$stmt->fetch();
		print <<<END
			<a href="showdeal.php?did={$deal['did']}" style="text-decoration:none"><div class="col-sm-3 deal" data-toggle="popover" data-trigger="hover focus" data-delay="400" data-placement="top" data-title="<b>{$deal['title']}</b>" data-html="true" data-content="<h6>{$deal['desc']}</h6><h6>Click for more details!">
				<img class="img-thumbnail img-responsive" src="{$deal['path']}">
				<div class="caption dealtitle">{$deal['title']}</div>
				<h6 class="originalprice">Rs. {$deal['originalprice']}</h6>
				<h6 class="price">Rs. {$deal['price']}</h6>
				<h6 class="validupto">Valid upto: {$deal['validupto']}</h6>
			</div></a>
END;
	}
?>