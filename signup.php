<?php
			include_once('config.php');
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			
			$pass1 = $_POST['pass1'];
			$pass2 = $_POST['pass2'];
			$address1 = $_POST['address1'];
			$address2 = $_POST['address2'];
			$address3 = $_POST['address3'];
			$email1 = $_POST['email1'];
	
			
			$sex = $_POST['sex'];
			$city = $_POST['city'];
			$state = $_POST['state'];
			
			$mobile = $_POST['mobile'];
			
		
			
			if($pass1 !== $pass2)
				die("The passwords don't match. Try again...");
			
            $pass1 = md5($pass1);		
			
			if(strlen($mobile) != 10)
				die("The mobile number isn't correct.");
	
			
			$con=new configure();
			
			try
			{
				$dbh = new PDO("mysql:dbname=$con->dbname;host=$con->host","$con->uname","$con->pass");
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
			
			$stmt = $dbh->prepare("INSERT INTO users (fname,lname,password,email,gender,houseno,street1,street2,city,state,mobile) VALUES(:fname,:lname,:pass,:email,:gender,:address1,:address2,:address3,:city,:state,:mobile)");
			
			$stmt->bindParam(':fname',$fname);
			$stmt->bindParam(':lname',$lname);
			$stmt->bindParam(':pass',$pass1);
			$stmt->bindParam(':email',$email1);
			$stmt->bindParam(':gender',$sex);
			$stmt->bindParam(':address1',$address1);
			$stmt->bindParam(':address2',$address2);
			$stmt->bindParam(':address3',$address3);
			$stmt->bindParam(':city',$city);
			$stmt->bindParam(':state',$state);	
			$stmt->bindParam(':mobile',$mobile);
			$res = $stmt->execute();
			if($res)
			{
				echo "Registeration was successful. An activation mail has been sent to $email1, kindly check and activate your account.";
			}
			else
			{
				echo "Sorry, registration failed! Please check all the fields and try again.";
			}
			$body="<html><head></head><body style='width:50%'><img src='images/logo.png'><p style='padding-top:10px;border-top:1px dotted gray;'>Dear" . $fname." ".$lname .",</br><p>	Thankyou for registering with Mytypedeals.in. Before you jump in the next generation shopping era, </br>please activate your account by <a href='#'>clicking</a> on the given link:</br><a href='#'>lsdvkldkvlvldsv.com/shd</a></p><p>User Name:" . $email1 ."</p></p><p style='border-top:1px dotted gray;background-color:lightgray;text-align:center'>Copyright Protected &copy; 2014 MyTypeDeals</p></body><html>";
			$to=$email1;
			$subject='Activation mail';
			$message='www.mutypedeals.in/activateyouacount';
			$headers='From:mails@mytypedeals.in;\r\nContent-type:text/html;charset=UTF-8\r\n'.$body;
			mail($to,$subject,$message,$headers);
?>          