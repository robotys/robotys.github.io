<?php

	require('HTML_To_Markdown.php');
	
	$config['db']		= 'robotys';
	$config['user']		= 'root';
	$config['pass']		= 'root';

	$config['host']		= '127.0.0.1';
	$config['prefix']	= 'wp';

	$config['old_wp_url'] = array('http://robotys.net','http://localhost/robotys');
	// $config['old_wp_content_dir'] = 'http://robotys.net/wp-content/uploads';


	// connect to database
	$conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['db']);
	// $conn = new mysqli('127.0.0.1', 'root', 'root', 'robotys');
	 
	// check connection
	if ($conn->connect_error) {
		dumper('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
	}

	// dumper($conn);


	$sql='SELECT post_title, post_name, post_date_gmt, post_status, post_content FROM `'.$config['prefix'].'_posts` WHERE post_status = "publish" AND post_content != ""';
 
	$rs=$conn->query($sql);

	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
	} else {
		$rows_returned = $rs->num_rows;

		// dumper($rs->fetch_assoc());

		while($row = $rs->fetch_assoc()){
			// process the posts
			$date = date('Y-m-d', strtotime($row['post_date_gmt']));
			$filename = $row['post_name'].'.md';

			if($row['post_status'] == 'publish') $filename = $date.'-'.$filename;

			// convert content to md
			$temp = new HTML_To_Markdown($row['post_content']);
			$md = $temp->output();

			// change url and assets directory
			foreach($config['old_wp_url'] as $arr){
				// change upload
				$md = str_replace($arr.'/wp-content/uploads', 'images', $md);
				$md = str_replace($arr, '', $md);
			}

			// insert title in content;
			$md = "#".$row['post_title']."\n\n".$md;

			// create post in posts directory
			file_put_contents('posts/'.$filename, $md);
		}
	}

	echo 'Done! Go <a href="gen.php">generate the index now &raquo;</a>';

	//// =========================

	function dumper($multi){
		echo '<pre>';
		var_dump($multi);
		echo '</pre>';
	}
?>