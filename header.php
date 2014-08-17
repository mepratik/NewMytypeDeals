<div class="row" id="notification">
<div id="message"></div>
</div>
<div class="row" id="topbar">
	<div class="col-sm-3">
		<a href="index.php" data-toggle="tooltip" title="MyTypeDeals.com - Find best deals in Dehradun"><img class="img-responsive" src="images/logo.png" alt="mytypedeals.com logo"></a>
	</div>
	<div class="col-sm-6">
		<form role="form" onSubmit="return false;">
			<div class="input-group" id="searchbar">
				<div class="input-group-btn">
				<button type="button" class="btn btn-default visible-lg visible-md visible-sm dropdown-toggle" data-toggle="dropdown" tabindex="-1">All Categories <span class="caret"></span></button>
				<ul class="dropdown-menu">
				<li><a href="#">All Categories</a></li>
				<li class="divider"></li>
				<?php
					$stmt=$dbh->prepare("SELECT * FROM categories");
					$stmt->execute();
					$num_rows=$stmt->rowCount();
					for($cat=0;$cat<$num_rows;$cat++)
					{
						$row=$stmt->fetch();
						echo "<li><a href='#' title={$row['title']}>{$row['name']}</a></li>";
					}
				?>
				</ul>
				</div>
				<input type="text" id="query" class="form-control" placeholder="Search">
				<span class="input-group-btn">
					<button id="searchbtn" type="button" class="btn btn-default">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</span>	
			</div>
		</form>
	</div>
	<div class="col-sm-3">
	<nav>
	<ul class="list-inline pull-right" role="menu">
				<li id="helpb"><a href="#help">Help</a></li>
				<li class="aboutb"><a href="#about">About</a></li>
				<li id="contactb" data-toggle="modal" data-target="#contactmodel"><a href="#contact">Contact</a></li>
				</ul>
	</nav>
	<?php 
		if((isset($_SESSION['login']) && $_SESSION['login']==1))
		{	
			echo "<span id='userinfo'>";
			echo "Welcome ".$_SESSION['fname']."!";
			echo "</span>";
		}
	?>
	</div>
</div>
<!-- detailsdrawer starts -->
<div class="row collapse" id="detailsdrawer">
	<div class="col-sm-4 visible-lg visible-md visible-sm"><h4>Information</h4></div>
	<div class="col-sm-4 visible-lg visible-md visible-sm"><h4>History</h4></div>
	<div class="col-sm-4">
	<h4>Cart</h4>There are no items in your cart.
	<button type="button" class="btn btn-primary pull-right">Checkout</button>
	</div>
</div>	<!-- ends detailsdrawer -->

<?php 
	if(!(isset($_SESSION['login']) && $_SESSION['login']==1))
	{
		print <<<LOGINFORM
		<!-- starts login form drawer -->
		<div class="row collapse" id="loginformdrawer">
			<div class="col-sm-3 pull-right" id="loginform">
				<form role="form" method="POST" action="login.php" id="form">
					<div class="input-group input-group-sm">
					<span class="input-group-btn"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-user"></span></button></span>
					<input type="text" name="username" class="form-control" placeholder="Username">
					</div>
					<br>
					<div class="input-group input-group-sm">
					<span class="input-group-btn"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-lock"></span></button></span>
					<input type="password" name="password" class="form-control" placeholder="Password">
					</div><br>
					<button type="button" class="btn btn-primary btn-sm" id="loginbutton">Login 
					<span class="glyphicon glyphicon-log-in"></span></button>
					<p class="text-right">
						<a data-toggle="modal" data-target="#forotpasswordmodel" href="#"><small>Forgot password?</small></a>
						<br>
						<a data-toggle="modal" data-target="#signupmodel" href="#"><small>Not a member? Sign up!</small></a>
					</p>
				</form>
			</div>
		</div>
		<!-- ends login form drawer -->
LOGINFORM;
	}
?>
<div class="row">
<div class="col-md-10 col-sm-10 col-xs-7 col-lg-10">
		<nav class="navbar navbar-default" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#catmenu">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#" data-toggle="popover" data-placement="bottom" data-title="<b>Browse Deals by Category</b>" data-trigger="click"
					data-html="true" data-content="<div class=row><?php 
						$stmt1=$dbh->prepare("SELECT * FROM categories");
						$stmt1->execute();
						$num_cats=$stmt1->rowCount();
						for($i=0;$i<$num_cats;$i++)
						{
							$cat=$stmt1->fetch(); /* FETCH ROW FROM categories*/
							echo "<div class=col-sm-6><h5 class='componentheading'>{$cat['name']}</h5>";
							$stmt2=$dbh->prepare("SELECT * FROM subcategories WHERE cid=:catid");
							$stmt2->bindParam(":catid",$cat['cid']);
							$stmt2->execute();
							$num_subcats=$stmt2->rowCount();
							for($j=0;$j<$num_subcats;$j++)
							{
								$subcat=$stmt2->fetch();	//FETCH ROW FROM subcategories FOR CURRENT CATEGORY
								print <<<END
									<a onClick=getDeals({$subcat['scid']})><h6 style='cursor:pointer;'>{$subcat['name']}</h6></a>
END;
							}
							echo "</div>";
						}
				?></div>">Deals</a>
			</div>
			<div class="collapse navbar-collapse" id="catmenu">
				<ul class="nav navbar-nav">
				<?php
					$stmt=$dbh->prepare("SELECT * FROM categories");
					$stmt->execute();
					$num_cats=$stmt->rowCount();
					
					/*****************************************************************************
					now, to get the scroll effects in index.php, the href must be to the same page.
					however, the menu items in catmenu of other pages must be linked to index.php's 
					sections. so, no prefix applied to links if on index.php 
					******************************************************************************/
					$uri=explode("/",$_SERVER['REQUEST_URI']);
					$num=count($uri);
					if($uri[($num-1)] == "index.php" || $uri[($num-1)] == "")
						$prefix="";
					else
						$prefix="index.php";
					for($i=0;$i<$num_cats;$i++)
					{
						$row=$stmt->fetch();
						echo "<li><a data-scroll href={$prefix}#cat-{$row['cid']} title={$row['title']}>{$row['name']}</a></li>";
					}
				?>
				</ul>
			</div>
		</nav>
	</div>
	<div class="pull-right">
	<?php 
	if(!(isset($_SESSION['login']) && $_SESSION['login']==1))
	{
		print <<<LOGINBUTTON
		<button type="button" class="btn btn-default btn-sm" data-toggle="collapse" href="#loginformdrawer" id="userbtn"><span class="glyphicon glyphicon-user"></span></button>
LOGINBUTTON;
	}
	else
	{
		print <<<LOGOUTBUTTON
		<a href="logout.php" data-toggle="tooltip" title="Sign Out" style="text-decoration:none"><button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-log-out"></span></button></a>
LOGOUTBUTTON;
	}
	?>
	<button type="button" class="btn btn-default btn-sm" data-toggle="collapse" href="#detailsdrawer" id="cartbtn"><span class="glyphicon glyphicon-shopping-cart"></span> Cart <span class="badge">2</span></button>
	</div>
</div>