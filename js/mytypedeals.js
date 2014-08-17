/*******************************************
*	JavaScript for mytypedeals.com
*	Author: Nishkarsh Sharma, Pratik Kumar
*	Created: April 19, 2014
*	Last-Modifed: April 120, 2014
********************************************/
$(document).ready(function(){
	$('#siteabout,#sitehelp,#sitepp,#sitecontact,#sitereturn').fadeOut('fast');
	/* only one panel remains at a time, hiding navbar when logindrawer or detailsdrawer opened */
	$('#userbtn').click(function(){
		
		$('#detailsdrawer').removeClass('in');
	});
	$('#cartbtn').click(function(){
		
		$('#loginformdrawer').removeClass('in');
	});
	
	$('#userbtn,#cartbtn').click(function(){
		if((! $('#loginformdrawer').hasClass('in')) && (! $('#detailsdrawer').hasClass('in')))
			$('.navbar').hide();
		else
			$('.navbar').show();
	});
	
	
	$(function () { $("[data-toggle='popover']").popover(); });	//enable pop overs

	/* loading and showing search results using ajax */
	function search(){
		$('#siteabout,#sitehelp,#sitepp,#sitecontact,#sitereturn').fadeOut('fast');
		$('#results').html("<h5 class='componentheading'>Search Results</h6><h5>Searching...</h5>");
		var q=$('#query').val();
		$.get('search.php?query='+q, function showResults(results){
			$('#main').fadeOut('slow',function(){
				$('#deals').fadeOut('slow',function(){
					$('#results').html(results);
					$('#searchresults').fadeIn('slow');
				});
			});
		});
	}
	
	var prev;
	$('li').click(function(){
		$(prev).removeClass("active");
		$(this).addClass("active");
		prev=this;
	});
	
	/* registering searchbtn with search() on click */ 
	$('#searchbtn').click(function(){
		search();
		$(prev).removeClass("active");
	});
	
	/* registering search input #query with search() on value change */
	$('#query').bind('change',function(){
		search();
		$(prev).removeClass("active");
	});
	
	/* show main div again if hidden when clicked on catmenu (any deal category) */
	$('#catmenu').click(function(){
		$('#siteabout,#sitehelp,#sitepp,#sitecontact,#sitereturn').fadeOut('fast');
		$('#searchresults').fadeOut('fast',function(){
			$('#deals').fadeOut('fast',function(){
				$('#main').fadeIn('slow');
			});
		});
	});
	
	$('#helpb').click(function(){
				$('#main,#siteabout,#sitecontact,#sitepp,#sitereturn').fadeOut('fast',function(){
					$('#sitehelp').fadeIn('slow');
				});
			});
				$('.aboutb').click(function(){
				$('#main,#sitehelp,#sitecontact,#sitepp,#sitereturn').fadeOut('fast',function(){
					$('#siteabout').fadeIn('slow');
				});
			});
				$('#contactb').click(function(){
				$('#main,#siteabout,#sitehelp,#sitepp,#sitereturn').fadeOut('fast',function(){
					$('#sitecontact').fadeIn('slow');
				});
			});
			$('#privacyb').click(function(){
				$('#main,#siteabout,#sitehelp,#sitecontact,#sitereturn').fadeOut('fast',function(){
					$('#sitepp').fadeIn('slow');
				});
			});
			$('#returnb').click(function(){
				$('#main,#siteabout,#sitehelp,#sitecontact,#sitepp').fadeOut('fast',function(){
					$('#sitereturn').fadeIn('slow');
				});
			});
	/* using jquery post for signing in */
		$("#loginbutton").click(function(){
	
		$("#notification").slideDown("slow",function(){
			$("#message").html("Processing...",function(){
				$("#message").delay(100).fadeIn("slow");
			});
		});
		
		$.post('login.php',$("#form").serialize(),function(data){
		$("#notification").fadeIn("slow",function(){
				$("#message").html(data);
				$("#message").fadeIn("slow");
				$("#message").delay(2000).fadeOut("slow",function(){
					$("#notification").delay(100).slideUp("slow",function(){
						location.reload(0);
					});
				});
			});
		});
	});		
});

/* this function gets the deals for subcategories */
function getDeals(subcatid)
{
	$('#siteabout,#sitehelp,#sitepp,#sitecontact,#sitereturn').fadeOut('fast');
	$('.navbar-brand').popover('hide');
	$.get('getdeals.php?scid='+subcatid, function(results){
		$('#main').fadeOut('slow',function(){
				$('#searchresults').fadeOut('slow',function(){
					$('#dealsresults').html(results);
					$('#deals').fadeIn('slow');
				});
			});
	});
}