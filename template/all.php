<!DOCTYPE HTML>
<head>
	<title>Robotys.net &bull; Web &bull; Teknologi &bull; Internet</title>

	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="../assets/style.css" type="text/css">
	<meta name="description" content="Robotys adalah persona dalam talian milik Izwan Wahab, juruaturcara laman web yang giat berkongsi tentang teknologi dalam kehidupan dan juga sistem dalam bisnes. Blog ini adalah ibarat nota beliau kepada diri sendiri agar mudah dingati pada masa hadapan.">


	<script src="../assets/jquery.min.js"></script>
	<script src="../assets/ga.js"></script>

	<script type="text/javascript">

		$(window).scroll(function(e){
			parallax();
		});

		function parallax(){
			var scrolled = $(window).scrollTop();
			$('.bg').css('top', -(scrolled * 0.2) + 'px');
		}
	</script>

	<!-- 
	<script src="assets/marked.js"></script>
	<script src="assets/saurus.js"></script>
 -->
</head>
<body>
<div class="bg"></div>
<div class="center"><div class="wrapper">

	<div class="header">
		<img src="../images/robotys-net-logo-bulat.jpg" style="width: 80px; border-radius: 50%; margin-bottom: -20px; border: 3px #FFF solid; box-shadow: 0px 0px 6px #888;"> 
		<br/><br/>
		<a href="../read" class="masthead">robotys.net</a> <br/>
		<p class="subtitle">Web &bull; Teknologi &bull; Internet</p>
		<p>Robotys adalah persona dalam talian milik Izwan Wahab, <a href="../read/tentang-robotys">juruaturcara laman web</a> yang giat berkongsi tentang teknologi dalam kehidupan dan juga sistem dalam bisnes. Blog ini adalah ibarat nota beliau kepada diri sendiri agar mudah dingati pada masa hadapan.</p>

		<p>
			<a title="facebook" href="http://facebook.com/robotys"><img src="../images/icon_facebook.png"/></a> &nbsp; &nbsp;
			<a title="github" href="http://github.com/robotys"><img src="../images/icon_github.png"/></a> &nbsp; &nbsp;
			<a title="twitter" href="http://twitter.com/robotys"><img src="../images/icon_twitter.png"/></a>
<!-- <a class="instagram_metro tsc_social_metro" title="instagram" href="#">instagram</a> -->
		</p>
	</div>

	<div class="content" id="content_wrapper">
		<!-- auto generated content will be here -->
		<!-- <div class="spinner" style="width: 100%; box-sizing: border-box; text-align: center; background: #fff; padding: 15px;">
			loading article <br/>
			<img src="images/loading.gif"/>
		</div> -->
		{{alls}}

	</div>
<!-- 
	<div class="navigation">
		<h3>Artikel-artikel lain:</h3>
		<ul id="nav">
			{{others_list}}
			<li><a href="../read/all.html" class="more">senarai artikel &raquo;</a></li>
		</ul>
	</div> -->

	<div class="subscribe">
		<!-- Begin MailChimp Signup Form -->
		<link href="//cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			#mc_embed_signup{background:auto; clear:left; font:14px Helvetica,Arial,sans-serif; }
			/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
			   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
		</style>
		<div id="mc_embed_signup">
			<form action="http://robotys.us8.list-manage.com/subscribe/post?u=6df1d81933d383e3275bb5515&amp;id=7ae6bb174b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<label for="mce-EMAIL">Subscribe untuk menerima update dan artikel khas</label>
				<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
			    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
			    <div style="position: absolute; left: -5000px;"><input type="text" name="b_6df1d81933d383e3275bb5515_7ae6bb174b" tabindex="-1" value=""></div>
			    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
			</form>
		</div>

		<!--End mc_embed_signup-->
	</div>

	<div class="footer">
		<p>Powered by <a href="http://github.com/robotys/saurus">Saurus</a> on <a href="http://github.com">Github</a> . All rights reserved &copy; 2014 Robotys.net.</p>
	</div>

</div></div>
</body>
</html>
