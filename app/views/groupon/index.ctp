<style>
img, input
{
	text-align: center;
	margin: auto;
}
</style>

<center><strong style="color: #333;">Thank you for using Groupon and welcome to LeBronJones.com.  Here are directions on how to go about getting your shirts:</strong></center>
<BR>	
<ol>
	<li>
		At the bottom of this page is a button to get started.  Once you click it, you will be taken to the LeBronJones.com home page.
		<Br><Br>
	</li>
	<li>
		Click on any shirt design you like.
		<Br><Br>
	</li>
	<li>
		Select the size and qty you want then click the "Add To Cart" button.  While your groupon is worth the value of one basic cotton t-shirt plus USPS shipping, you may continue to shop until you are ready to checkout.
		<Br><Br>
		<center><?php echo $html -> image("/img/add-to-cart.jpg"); ?></center>
		<Br><Br>
	</li>
	<li>
		When you are ready to checkout, make sure you are in the "My Cart" page.
		<BR><BR>
		<center><?php echo $html -> image("/img/my-cart.jpg", array("width"=>500)); ?></center>
		<Br><Br>
	</li>
	<li>
		Type in your Groupon code into the Coupon Code section, click "add...," then click the "Checkout" button. Make sure to copy the code exactly EXCEPT remove the # sign before the first number. 
		<Br><Br>
		<center><?php echo $html -> image("/img/add-coupon.jpg"); ?></center>
		<BR><BR>
		<center><span style="color: #f66; font-weight: bold;">NOTE: You may redeem multiple groupon codes in one session, please make sure you have already purchased the correct number of shirts before entering in coupon codes.</span></center>
		<BR><BR>
	</li>
	<li>
		Now login on the right side of the page.  If you don't have a login, you can register on the left side of the page.  You will be asked to put in your billing and shipping information.
		<Br><Br>
		<center><?php echo $html -> image("/img/login.jpg", array("width"=>500)); ?></center>
		<BR><BR>
	</li>
	<li>
		Finally you will be taken to the checkout page.  Here you will be able to enter in your payment information, see a summary of your cart, select your shipping type, and select gift wrapping options.  Your Groupon is valid for USPS shipping only, you may choose expedited shipping, but you will need to pay the difference.
		<BR><BR>
		<center><span style="color: #f66; font-weight: bold;">Note: You need to enter your credit card information even if your amount due is zero (you ordered the Groupon exactly). If your amount due is zero, your credit card will not be charged, and your credit card information is NEVER stored.</span></center>
		<BR><BR>
		<center><?php echo $html -> image("/img/checkout.jpg", array("width"=>400)); ?></center>
		<Br><Br>
	</li>
	<li>
		When you're ready, click the "Complete Payment" button.  You'll be taken to your receipt which you can print out for your own records.  A copy will also be emailed to you.
		<Br><Br>
	</li>
	<li>
		Don't Forget to Join the <?php echo $html->link("LeBron Jones Facebook Fan Page", "http://www.facebook.com/staygonelebron", array("target"=>"_blank")); ?> to join in on the Cavs and LeBron discussion with thousands of other Cavalier Fans (or people that just hate LeBron).
	</li>
</ol>

<center><input type="button" value="Click To Get Started" onclick="window.location='http://www.lebronjones.com'"></center>

<BR><BR>
	
<center><iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fstaygonelebron&amp;width=800&amp;colorscheme=light&amp;connections=14&amp;stream=true&amp;header=true&amp;height=500" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:800px; height:500px;" allowTransparency="true"></iframe></center>