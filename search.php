<?php
	$query=$_GET['query'];
	$tags=explode(" ",$query);
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
	
	print <<<END
		<script>
			$(function () { $("[data-toggle='popover']").popover(); });	//enable pop overs
		</script>
		<h4 class="componentheading">Search Results<h4>
END;
	$date=date('Y/m/d');
	$total_results=0;
	foreach ($tags as $tag)
	{
		$stmt=$dbh->prepare("SELECT * FROM deals, images WHERE (deals.title LIKE '%".$tag."%' OR deals.desc LIKE '%".$tag."%' OR deals.features LIKE '%".$tag."%' OR deals.price LIKE '%".$tag."%') AND (deals.iid=images.iid) AND (instock <> 0 AND active <> 0 AND validupto > '$date')");
		$stmt->execute();
		$num_deals=$stmt->rowCount();
		$total_results += $num_deals;
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
	}
	if($total_results)
		echo "<h6 class=text-warning>Total $total_results result(s) found.</h6>";
	else
		echo "<h6 class=text-danger>Sorry! No results found. Try writing different keywords that may match the same deal.</h6>";
?>