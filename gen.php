<?php
	
	
	## Configurations:

	CONST MARKDOWN_DIR = 'posts';
	CONST FRONT_COUNT = 10;
	error_reporting(E_ALL);
	## MAIN


	$mds = get_mds();

	foreach($mds as $filename){

		if($filename != '.DS_Store'){
			$ind = indexer($filename);
			$index[$ind['slug']] = $ind;
			$posts[] = $ind;
		}
	}

	// dumper($index);

	$data = json_encode($index);

	file_put_contents('assets/index.json', $data);


	// masukkan dalam read

	// generate read template
	$read_template = file_get_contents('template/read.php');
	$index_template = file_get_contents('template/index.php');
	$index_post_template = '
		<div class="post" id="{{post-id}}">
			<h1><a href="{{permalink}}">{{title}}</a></h1>
			<div class="date"><div>{{datetime}}</div></div> 
			<br/> {{content}} 
		</div>';

	$all_template = file_get_contents('template/all.php');
	$all_post_template = '
		<div class="post" id="{{post-id}}">
			<h1><a href="{{permalink}}">{{title}}</a></h1>
			<div class="date"><div>{{datetime}}</div></div> 
			<br/> {{excerpt}} 
		</div>';
	// generate index
	// generate archive


	// latest for front and list:
	for($ii = 0; ($ii < FRONT_COUNT && $ii < count($posts)) ; $ii++){
		$latest[] = '<li><a href="'.read_url($posts[$ii]['slug']).'">'.$posts[$ii]['title'].'</a></li>';
	}
	// latest list
	$latest_list = implode($latest);

	include('parsedown.php');
	$Parsedown = new Parsedown();

	foreach($posts as $i=>$post){
		$md = file_get_contents('posts/'.($post['filename']));
		$md = str_replace('(images/', '(../images/', $md);
		$post['excerpt'] = str_replace('(images/', '(../images/', $post['excerpt']);
		// buang first line because it is a title line, we already has title

		$exp = explode("\n", $md);
		unset($exp[0]);
		$md = implode("\n", $exp);

		// $md = str_replace('images/', '\'../images/', $md);
		// dumper(strlen($md));
		$prev = $next = '';
		
		if(array_key_exists(($i-1), $posts) !== FALSE){
			$prev = '<a href="'.read_url($posts[($i-1)]['slug']).'">'.$posts[($i-1)]['title'].'</a>';
		}

		if(array_key_exists(($i+1), $posts) !== FALSE){
			$next = '<a href="'.read_url($posts[($i+1)]['slug']).'">'.$posts[($i+1)]['title'].'</a>';
		}
		$vars = $post;
		$vars['latest_list'] = $latest_list;
		$vars['prev'] = $prev;
		$vars['next'] = $next;
		$vars['title'] = $post['title'];
		$vars['permalink'] = read_url($post['slug']);
		$vars['datetime'] = date('d M Y', $post['timestamp']);
		$vars['img'] = get_first_image($md);
		$vars['content'] = $Parsedown->text($md);
		$vars['home_link'] = get_domain();
		$vars['excerpt'] = $Parsedown->text($vars['excerpt']);

		$template = $read_template;
		$content = $index_post_template;
		$all = $all_post_template;
		foreach($vars as $key=>$value){
			$template = str_replace('{{'.$key.'}}', $value, $template);
			$content = str_replace('{{'.$key.'}}', $value, $content);
			$all = str_replace('{{'.$key.'}}', $value, $all);
		}

		file_put_contents('read/'.$vars['slug'].'.html', $template);

		// contents untuk index
		if($i < FRONT_COUNT) $all_contents[] = $content;
		$all_post[] = $all;
	}

	for($i = 0; $i < count($posts); $i++){
		if(array_key_exists($i, $latest) === FALSE) $other[] = '<li><a href="'.read_url($posts[$i]['slug']).'">'.$posts[$i]['title'].'</a></li>';
	}

	$others_list = implode($other);
	$contents = implode($all_contents);
	// gen index
	$index = str_replace('{{contents}}', $contents, $index_template);
	$index = str_replace('{{others_list}}', $others_list, $index);

	file_put_contents('read/index.html', $index);

	$alls = implode($all_post);

	// gen index
	$all = str_replace('{{alls}}', $alls, $all_template);
	// $index = str_replace('{{others_list}}', $others_list, $index);

	file_put_contents('read/all.html', $all);

	echo 'done!';


	#################################
	########### FUNCTIONS ###########

	function get_first_image($md){
		$temp = explode('![', $md);
		if(count($temp) > 1){
			$temp = explode(')', $temp[1]);
			$temp = explode('](', $temp[0]);
			
			return $temp[1];
		}else{
			return '';
		}
	}

	function get_domain(){
		$domain = 'http://'.str_replace('/gen.php', '', ($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));

		return $domain;
	}

	function read_url($slug){
		if(!ISSET($domain)) $domain = 'http://'.str_replace('/gen.php', '', ($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));
		return $domain.'/read/'.$slug.'.html';
	}

	function dumper($multi){
		echo '<pre>';
		var_dump($multi);
		echo '</pre>';
	}

	function get_mds(){
		$mds = scandir(MARKDOWN_DIR);

		arsort($mds); // from latest DESC

		unset($mds[0]);
		unset($mds[1]);

		return $mds;
	}

	function indexer($filename){
		$exp = explode('-',$filename);

		$date = $exp[0].'-'.$exp[1].'-'.$exp[2];

		unset($exp[0]);
		unset($exp[1]);
		unset($exp[2]);

		$str = implode('-', $exp);
		$slug = str_replace('.md', '', $str);
		$slug = str_replace('.txt', '', $slug);

		$timestamp = gmdate(strtotime($date));

		// get titles and other metadata too;
		$contents = file_get_contents(MARKDOWN_DIR.'/'.$filename);

		unset($exp);
		
		$exp = explode("\n", $contents);

		foreach($exp as $ex){
			if(trim($ex) != '') $cont[] = $ex;
		}

		unset($exp);

		$title = trim(str_replace('#', '', $cont[0]));
		$excerpt = $cont[1];
		$wordcount = substr_count($contents, ' '); // count the space as approximate word count

		
		$ret['slug'] = $slug;
		$ret['filename'] = $filename;
		$ret['timestamp'] = (int)$timestamp;
		$ret['title'] = $title;
		$ret['excerpt'] = $excerpt;
		$ret['wordcount'] = (int)$wordcount;

		return $ret;
		
	}

	#################################

?>