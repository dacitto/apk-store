<?php 
$noNavbar = '';
include 'init.php';
?>

	
<form action="">
	
<div class="rating text-center">
<input type="radio" name="star" id='star5' value="5"><label for="star5" class="s5"><i class="fa fa-star"></i></label>
<input type="radio" name="star" id='star4' value="4"><label for="star4" class="s4"><i class="fa fa-star"></i></label>
<input type="radio" name="star" id='star3' value="3"><label for="star3" class="s3"><i class="fa fa-star"></i></label>
<input type="radio" name="star" id='star2' value="2"><label for="star2" class="s2"><i class="fa fa-star"></i></label>
<input type="radio" name="star" id='star1' value="1"><label for="star1" class="s1"><i class="fa fa-star"></i></label>
<br/>
<input type="reset" value="reset" class="text-center">
<input type="submit" value="rate" class="text-center">

	


</div>

</form>



<style type="text/css">
    body{
    	background-color: #252525
    }
	.rating{
		direction: rtl;
		margin: 150 auto;
		font-size: 26px
	/*	display: flex;
		position: absolute;*/
	}
	.rating input[type="radio"]{
		display: none;
	}
	.rating input{
		padding:0;
	}
	.rating label{
		width: 17px;
		color: #eee;
		transition: all .6s ease-in-out

	}
	.rating input[type="radio"]:checked+label,
	.rating input[type="radio"]:checked+label~label,
	.rating label:hover,
	.rating label:hover~label{
     color: gold;
     text-shadow: 0 0  10px yellow;
     transform: scale(1.05);
     transition: all .6s ease-in-out;
	}
	
	
</style>