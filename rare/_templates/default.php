<html>
<head>
	<title><?php echo $template->get('title') ?></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script src="/rare.js"></script>
	<link rel="stylesheet" href="/rare.css" type="text/css" />
</head>
<body>
	<div id="nav">
		<ul>
			<li<?php echo (strpos(sitecmd::get('url.query'), 'filter') === 0 ? ' class="sel"' : '') ?>><a href="/?filter=<?php echo fSession::get('user_id') ?>">My Tasks</a></li>
			<li<?php echo ((!sitecmd::get('url.request') && !sitecmd::get('url.query')) ? ' class="sel"' : '') ?>><a href="/">All Tasks</a></li>
			<li<?php echo (sitecmd::get('url.request') == 'new' ? ' class="sel"' : '') ?>><a href="/new/">New Task</a></li>
		</ul>

		<form id="search" action="<?php echo sitecmd::url('') ?>" method="get">
			<input type="text" name="q" value="" class="in" />
		</form>
	</div>
	<div id="content">
	<?php fMessaging::show(array('success', 'error')) ?>
	<?php echo $content ?>
	</div>
	<div id="footer">
		<a href="https://github.com/vxnick/rare">Rare Task Management</a>
		&ndash; v<?php echo sitecmd::get('rare.version') ?>.
		Chewed up and spat out in a measly <?php echo sitecmd::get('sitecmd.timer') ?> seconds.
		Template by <a href="http://www.tempo.co.uk/">Tempo</a>
	</div>
</body>
</html>