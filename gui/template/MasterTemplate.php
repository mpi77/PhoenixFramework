<!DOCTYPE html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<base href="<?php echo htmlspecialchars(Config::SITE_BASE);?>">
<title><?php Translate::display(Translator::SITE_TITLE);?></title>
<meta name="description" content="<?php Translate::display(Translator::SITE_DESCRIPTION);?>">
<meta name="keywords" content="<?php Translate::display(Translator::SITE_KEYWORDS);?>">
<meta name="author" content="<?php Translate::display(Translator::SITE_AUTHORS);?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<link rel="shortcut icon" href="gui/images/favicon/favicon.ico" title="favicon" />
<link rel="stylesheet" href="gui/css/custom.css" />
</head>

<body role="document">
	<div id="main-wrap">
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="menu-navbar">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="./"><li class="fa fa-empire">&nbsp;</li>HOME</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="user/login/">Login</a></li>
					</ul>
				</div>
			</div>
		</div>
		<?php echo $f->output();?>
		<div id="push"></div>
	</div>
	<div id="footer">
		<div class="container">
			<p class="text-center">
				&copy;&nbsp;<a href="#">MPi</a>, 2014
			</p>
		</div>
	</div>
</body>
</html>
