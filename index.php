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
	<meta name="keywords" content="cake,food items,flowers,clothes,electronic,deals,dehradun">
	<meta name="description" content="deals in dehradun">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<meta name="author" content="Nishkarsh Sharma and Pratik Kumar">
	<title>MyTypeDeals - Find exciting deals in your city! Buy cakes, flowers, healthcare products, clothes, electronic items at discounted price in Dehradun</title>
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
		<div class="row">
			<div class="col-sm-12" id="content">
				<div id="slideshow" class="carousel slide">
					<ol class="carousel-indicators">
						<li data-target="#slideshow" data-slide-to="0" class="active"></li>
						<li data-target="#slideshow" data-slide-to="1"></li>
						<li data-target="#slideshow" data-slide-to="2"></li>
						<li data-target="#slideshow" data-slide-to="3"></li>
						<li data-target="#slideshow" data-slide-to="4"></li>
					</ol>
					<div class="carousel-inner">
						<div class="item active">
							<img src="images/bigdeals/1.jpg" alt="First Slide">
							<div class="carousel-caption">Soft to feel, and beautiful to look at!</div>
						</div>
						<div class="item">
							<img src="images/bigdeals/2.jpg" alt="Second Slide">
							<div class="carousel-caption">Shop quirky & vibrant bed linen by Manish Arora</div>
						</div>
						<div class="item">
							<img src="images/bigdeals/3.jpg" alt="Third Slide">
							<div class="carousel-caption">Beauty and functionality should be inseparable</div>
						</div>
						<div class="item">
							<img src="images/bigdeals/4.jpg" alt="Fourth Slide">
							<div class="carousel-caption">Sale sale sale!! 60% off!</div>
						</div>
						<div class="item">
							<img src="images/bigdeals/5.jpg" alt="Fifth Slide">
							<div class="carousel-caption">Great deals on food!</div>
						</div>
					</div>	<!-- carousel-inner ends -->
					<a data-scroll class="carousel-control left" href="#slideshow" data-slide="prev">&lsaquo;</a>
					<a data-scroll class="carousel-control right" href="#slideshow" data-slide="next">&rsaquo;</a>
				</div>	<!-- carousel ends -->
			</div>	<!-- column ends -->
		</div>	<!-- row ends -->
			<!-- deals are finally here -->
			<div class="row dealscontainer" style="margin-left:-10px;">
				<div class="col-sm-9">
					<?php
						/* GET CATEGORIES FROM TABLE categories */
						$stmt1=$dbh->prepare("SELECT * FROM categories");
						$stmt1->execute();
						$num_cats=$stmt1->rowCount();
						/* FETCH EACH ROW FROM categories*/
						for($i=0;$i<$num_cats;$i++)
						{
							$cat=$stmt1->fetch();
							
							/* MAKE A ROW FOR EACH CATEGORY */
							print <<<END
							<div class="row"> <!-- {$cat['name']} row starts -->
								<h4 class="componentheading" id="cat-{$cat['cid']}">{$cat['name']}</h4>
END;
								/* GET DEALS FROM TABLE deals FOR CURRENT CATEGORY, EQUIJOINED WITH images on iid*/
								$date=date('Y/m/d');
						
								$stmt2=$dbh->prepare("SELECT * FROM deals, images WHERE (deals.cid=:catid AND deals.iid=images.iid) AND (instock <> 0 AND active <> 0 AND validupto > '$date')");
								$stmt2->bindParam(":catid",$cat['cid']);
								$stmt2->execute();
								$num_deals=$stmt2->rowCount();
								
								if($num_deals > 0)
								{
									/* SHOW DEALS FETCHED FOR CURRENT CATEGORY */
									for($j=0;$j<$num_deals;$j++)
									{
										$deal=$stmt2->fetch();
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
								else
								{
									print <<<END
										<h5>No Deals available in this category yet.</h5>
END;
								}
							echo "</div> <!-- {$cat['name']} row ends -->";
						}
					?>
				</div>
				<div class="col-sm-3">
				<h4 class="componentheading">Picked for you</h4>
				</div>
			</div>	<!-- showcase of deals ends -->
		</section><!-- main ends -->
		
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
		<!-- Section Containing Site help -->
		<section id="sitehelp">
			<div id="helpc" class="row" style="margin-left:0px;">
			<div class="col-sm-12">
				<h5 class='componentheading'>Help</h5>
			</div>
			</div>
		</section>
		<section id="siteabout">
			<div id="aboutc" class="row" style="margin-left:0px;">
			<div class="col-sm-12">
				<h5 class='componentheading'>About</h5>
				<p class="content">
					Mytypedeals.com is a one stop shop for all the top deals in your city.Mytypedeals.com aims at providing a hassle free and enjoyable shopping experience to shoppers who look for unrealistic deals in their city.Mytypedeals also aims to be the fastest cake delivery services company in Dehradun where our team promises our buyers to deliver cake in any region of Dehradun within 3 hrs of order. The deals are showcased after proper planning and seeing the scenario and current prices and with maximum negotiation done with the clients we make] it a win win strategy for our clients and followers.The cake which we display are at 50% less price than all the major leads. Along with this our brand partner Elloras Melting Moments makes sure that the quality served to your loved ones is the best. The brand is also making a conscious effort to bring the power of fashion to shoppers with an array of the latest and trendiest products available in the ethnic and western apparels category. Cash back offers are also a specialty of mytypedeals.com.Along with this mytypedeals is also famous in best food combo deals in Dehradun with price range starting from Rs 3. The team is also working for various social issues like girl child education and women empowerment.So if ever you buy a deal from our website,we make sure to spend some amount on these causes which appreciates your happiness.We are working hard to coming up with the best deals in all major categories and things which the youth requires.
				</p>
				<p class="content">
					Mytypedeals.com's value proposition revolves around giving consumers the power and ease of purchasing unrealistic deals and offers online.To make online shopping easier for you, a dedicated customer connect team is on standby to answer your queries 24x7.
				</p>
				<br>
				<p>
					<h5 class='componentheading'>Our Team</h5>
					<table class="table table-striped table-hover table-responsive">
					<caption></caption> 
					<thead> 
						<tr> 
							<th>Work</th> 
							<th>Member</th> 
						</tr> 
					</thead> 
					<tbody> 
						<tr> <td>Technical Specialists</td> <td>Nishkarsh Sharma,Pratik Kumar and Akashdeep Singh</td> </tr> 
						<tr>  <td>Design Specialist</td> <td>Lavendra Jeena</td> </tr> 
						<tr> <td>The Marketeers</td> <td>Mudit Gulati (owner and MD elloras melting moments),Krishna Kamal,Sommay Mudgal,Amanpreet Singh,Rishi Batra,Surbhi Arora,Manpreet Rekhi,Deepika Manchanda,Divya Chopra and Akashdeep Singh</td> </tr>
						<tr>  <td>Client (Deal Specialist) and Customer Support</td> <td>Akashdeep Singh</td> </tr> 
					 </tbody> 
					 </table>
					</p>
					</div>
					</div>
		</section>
		<!-- Section Containing signup Form -->
		<section id="signup">
			<div id="signupc" class="row" style="margin-left:0px;">
			<div class="col-sm-12">
			
			<div class="modal fade" id="signupmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
				<div class="modal-dialog"> 
					<div class="modal-content"> 
						<div class="modal-header"> 
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
							<h5 class='modalheading'>Sign Up</h5>
						</div> 
						<div class="row">
						<div class="modal-body">
						<div class="col-sm-12"> 
						<form class="form-horizontal" role="form" action="signup.php" method="POST"> 
						<div class="form-group"> 
							<label for="ftname" class="col-sm-3 control-label">First Name</label> 
							<div class="col-sm-9"> 
							<input type="text" class="form-control" name="fname" id="fname" placeholder="Enter First Name"> 
							</div> 
						</div> 
						<div class="form-group"> 
							<label for="lname" class="col-sm-3 control-label">Last Name</label> 
							<div class="col-sm-9"> 
								<input type="text" class="form-control" name="lname" id="lastname" placeholder="Enter Last Name"> 
							</div> 
						</div>
						<div class="form-group"> 
							<label for="email" class="col-sm-3 control-label">Email</label> 
							<div class="col-sm-9"> 
								<input type="email" class="form-control" name="email1" id="email" placeholder="Enter Your Email"> 
							</div> 
						</div>
						<div class="form-group"> 
							<label for="lastname" class="col-sm-3 control-label">Sex</label> 
							<div class="col-sm-9"> 
								<label class="radio-inline"> 
								<input type="radio"  name="sex" id="sexm" value="male" checked>Male
								</label> 
								<label class="radio-inline"> 
								<input type="radio"  name="sex" id="sexf" value="female">Female 
								</label>
							</div>
						</div>
						<div class="form-group"> 
							<label for="password" class="col-sm-3 control-label">Password</label> 
							<div class="col-sm-9"> 
								<input type="password" class="form-control" name="pass1" id="password" placeholder="Choose your Password"> 
							</div> 
						</div>
						<div class="form-group"> 
							<label for="cpassword" class="col-sm-3 control-label">Again</label> 
							<div class="col-sm-9"> 
								<input type="password" class="form-control" id="cpassword" name="pass2" placeholder="Again..!"> 
							</div> 
						</div>
						<div class="form-group"> 
							<label for="mobile" class="col-sm-3 control-label">Mobile</label> 
							<div class="col-sm-9"> 
								<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Yor Mobile Number"> 
							</div> 
						</div>
						<div class="form-group"> 
							<label for="addressine1" class="col-sm-3 control-label">House Number</label> 
							<div class="col-sm-9"> 
								<input type="text" class="form-control"  id="addressline1" name="address1" placeholder="Enter Home Numer"> 
							</div> 
						</div>
						<div class="form-group"> 
							<label for="addressine2" class="col-sm-3 control-label">Street 1</label> 
							<div class="col-sm-9"> 
								<input type="text" class="form-control" id="addressline2" name="address2" placeholder="Enter  Street detail"> 
							</div> 
						</div>
						<div class="form-group"> 
							<label for="addressine3" class="col-sm-3 control-label">Street 2</label> 
							<div class="col-sm-9"> 
								<input type="text" class="form-control" id="addressline3"  name="address3"placeholder="Enter  More Street detail"> 
							</div> 
						</div>
						<div class="form-group"> 
							<label for="city" class="col-sm-3 control-label">City</label> 
							<div class="col-sm-9"> 
								<input type="text" class="form-control" id="city" name="city" placeholder="Enter  City Name"> 
							</div> 
						</div>
						<div class="form-group"> 
							<label for="state" class="col-sm-3 control-label">State</label> 
							<div class="col-sm-9"> 
								<select class="form-control" name="state">
									<option>1</option> 
									<option>2</option> 
									<option>3</option> 
									<option>4</option> 
									<option>5</option> 
								</select>
							</div>
						</div>
						<div class="form-group"> 
							<label for="country" class="col-sm-3 control-label">Country</label> 
							<div class="col-sm-9"> 
								<input type="text" class="form-control" id="country"  name="acountry" value="India" disabled> 
							</div> 	
						</div>
						<div class="modal-footer"> 			
				        	<div class="form-group"> 
				               <div class="col-sm-offset-2 col-sm-10"> 
				                 	<button type="button" class="btn btn-default" data-dismiss="modal">Close </button> 
					                <button type="submit" class="btn btn-primary">Sign in</button> 
				                </div> 
			                </div> 
						</div>
			
					</form>
						</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Section Containing forgotpassword option -->
		<section id="siteforgotpassword">
			<div id="forgotpasswordc" class="row" style="margin-left:0px;">
			<div class="col-sm-12">
			
			<div class="modal fade" id="forotpasswordmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
				<div class="modal-dialog"> 
					<div class="modal-content"> 
						<div class="modal-header"> 
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
							<h5 class='modalheading'>Forgot Password</h5>
						</div>
						<form class="form-horizontal" role="form" style="padding-top:20px"> 
						<div class="form-group"> <label class="col-sm-3 control-label">Registerd Email:</label> 
							<div class="col-sm-8"> <div class="input-group"><span class="input-group-btn"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-envelope"></span></button></span><input type="email" class="form-control" id="email" placeholder="Email"> </div></div> 
						</div> 
						<div class="modal-footer"> 			
				        	<div class="form-group"> 
				               <div class="col-sm-offset-2 col-sm-10"> 
				                 	<button type="button" class="btn btn-default" data-dismiss="modal">Close </button> 
					                <button type="submit" class="btn btn-primary">Send Reset Link</button> 
				                </div> 
			                </div> 
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Section Containing contact details -->
		<section id="sitecontact">
			<div id="contactc" class="row" style="margin-left:0px;">
			<div class="col-sm-12">
			
			<div class="modal fade" id="contactmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
				<div class="modal-dialog"> 
					<div class="modal-content"> 
						<div class="modal-header"> 
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
							<h5 class='modalheading'>Contact Us</h5>
						</div> 
						<div class="row">
						<div class="modal-body">
						<div class="col-sm-4"> 
						<h4>Contact Details</h4> 
						<p>
						<ul class="list-unstyl">
						<li>Name:</li>
						<li>Name:</li>
						<li>Name:</li>
						<li>Name:</li>
						</ul>
						</p>
						</div> 
						<div class="col-sm-8">
						<h4>Feedback Form</h4> 
							<form class="form-horizontal" role="form"> 
							<div class="form-group"> <label class="col-sm-3 control-label">Name</label> 
							<div class="col-sm-9"> <input type="text" class="form-control" id="Name" placeholder="Name"> </div> 
							</div>
							<div class="form-group"> <label class="col-sm-3 control-label">Email</label> 
							<div class="col-sm-9"> <input type="email" class="form-control" id="email" placeholder="Email"> </div> 
							
							</div> 
							<div class="form-group"> 
							<label for="inputPassword" class="col-sm-3 control-label">Phone</label> 
							<div class="col-sm-9"> <input type="text" class="form-control" id="iphone" placeholder="Phone"> 
							</div> 
							</div>
							<div class="form-group"> <label class="col-sm-3 control-label">Message</label> 
							<div class="col-sm-9"> <textarea class="form-control" rows="3" placeholder="Enter you message"></textarea> </div> 
						</div>
							<div class="modal-footer"> 
								<button type="button" class="btn btn-default" data-dismiss="modal">Close </button> 
								<button type="button" class="btn btn-primary"> Submit </button> 
							</div>
						</form>
						</div>
						</div>
				</div>
			</div>
		</section>
		<!-- Section Containing Site privacy policy -->
		<section id="sitepp">
			<div id="aboutc" class="row" style="margin-left:0px;">
				<div class="col-sm-12">
					<h5 class='componentheading'>Privacy Policy</h5>
			        <h4><br/>We take your privacy seriously, and  we want you to know how we collect, use, share and protect your information. <br/>
					<strong>This Privacy Policy tells you:</strong></h4>
					<ul type="disc">
					  <li>What information we collect</li>
					  <li>How we use that information</li>
					  <li>How we may share that information</li>
					  <li>How we protect your information </li>
					  <li>Your choices regarding your personal information </li>
					</ul>
					<p class="content"><strong>Information  We Collect</strong><br /><strong>Information You Give Us</strong><br />
					  We receive and may store any information you enter on our websites or give to  us in our stores. For example, we collect information from you when you place  an order, create an account, call us with a question, create a Wish List, write  a review, or use any of our services. <br />
					  The information we collect from you  includes things like:</p>
						<ul type="disc">
						  <li>Your name</li>
						  <li>Your mailing address</li>
						  <li>Your e-mail address</li>
						  <li>Your phone number</li>
						</ul>
						<p class="content">It may also include information you  give us about other people, such as the name and address of a gift recipient,  or the name and contact info of a Friends &amp; Family Pickup person. <br />
						<strong>Information From Other Sources</strong><br />
						  We may also receive information about you from other sources, including third  parties that help us update, expand and analyze our records and identify new customers.  Like many other websites, we also collect information through cookies and other  automated means. Cookies are commonly used by websites to save data on your  computer. The information we collect from cookies may include your IP address,  browser and device characteristics, referring URLs, and a record of your  interactions with our websites. We use cookies to create a more personalized  shopping experience on our websites. <br />
						  To help us understand and enhance  our interactions with visitors to our websites, we may permit web analytics  providers to collect information on our websites using automated tools like  cookies or web beacons. We also may share personal information with those  providers. We may have similar arrangements with interest-based advertisers.  Interest-based advertising is covered in more detail below.<br />
				          <strong>Public Forums </strong><br />
							  Our Web site offers publicly accessible blogs or community forums. You should  be aware that any information you provide in these areas may be read,  collected, and used by others who access them. <br />
					          <strong>How  We Use the Information We Collect</strong><br />
							  We use the information we collect  for things like:</p>
        <ul type="disc">
          <li>Fulfilling orders and requests for products, services       or information</li>
          <li>Processing returns, exchanges and layaway requests</li>
          <li>Tracking and confirming online orders</li>
          <li>Delivering or installing products</li>
          <li>Managing our Reward Zone program</li>
          <li>Marketing and advertising products and services</li>
          <li>Conducting research and analysis</li>
          <li>Establishing and managing your accounts with us</li>
          <li>Communicating things like special events, sweepstakes,       promotions and surveys </li>
          <li>Facilitating interactions with Mytypedeals and others,       such as enabling you to email a link to a friend </li>
        </ul>
        <p class="content"> <br />
          Sometimes we may be required to  share personal information in response to a regulation, court order or  subpoena. We may also share information when we believe it's necessary to  comply with the law. We also may share information to respond to a government  request or when we believe disclosure is necessary or appropriate to protect  the rights, property or safety of Mytypedeals, our customers, or others; to  prevent harm or loss; or in connection with an investigation of suspected or  actual unlawful activity. <br />
          We may also share personal  information in the event of a corporate sale, merger, acquisition, dissolution  or similar event.<br />
          We may share personal information in  connection with financial products or services related to our business such as  private label credit cards. We also may share personal information in  connection with co-branded product or service offerings. For example, when you  apply for a Mytypedeals credit card, we may share your personal information  with our banking partners that issue the card.<br />
  <strong>Links  to Other Websites </strong>Our websites link to other websites,  many of which have their own privacy policies. Be sure to review the privacy  policy on the site you're visiting. <strong> </strong></p>

			</div>
		</div>
		</section>
		<!-- Section Containing Return Policy -->
		<section id="sitereturn">
		<div id="returnc" class="row" style="margin-left:0px;">
			<div class="col-sm-12">
				<h5 class='componentheading'>Return Policy</h5>
				<b>"No Questions Asked Return Policy!"</b> </br>
				<p class="content">Though we strive to give you a great customer experience each time you shop with us, if at all you are not 100% satisfied with your purchase, you can return your Order for a full refund of paid price.</p> 
				<p class="content">We mean what we say! All you need to do is give us a call on 09557442222 (24X7) or drop an email at order@mytypedeals.com within a period of 7 days, from the date of order. </p>
				<p>However, you must understand that we can't bear a loss either; so return of products will be accepted only if the products are returned in a saleable condition with the tags intact and in their original packaging, in an unwashed and undamaged condition. C'mon that's just fair! </p>
				<ul type="circle">
					<li> Please note that "mytypedeals.com's 7 Day Returns Policy" does not apply to Inner wear, Lingerie, Fragrances, Beauty products, Jewellery(sold by Mytypedeals Partners only), Swimsuits, Socks, Furniture,all products of cake taxi(Cakes,Flowers and Chocolates),food items, CDs, Pens & Books.</li>
					<li> Refund/ replacement for goods/ merchandise is subject to inspection and checking by mytypeedeals team.</li>
					<li> Damages due to neglect, improper usage or application will not be covered under our Returns Policy.</li>
					<li> Some special rules for promotional offers may override "mytypedeals.com's 7 Day Returns Policy."</li>
					<li> Please note that the Cash on Delivery convenience charge and the shipping charge would not be included in the refund value of your order as these are non-refundable charges.</li>
				</ul>
			</div>
			</div>
		</section>
		<footer>
			<?php include_once('footer.php'); ?>
		</footer>
	</div> <!-- end of container -->
</body>
</html>