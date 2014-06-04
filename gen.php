<?php
	
	// we can be sloppy for these phase. What phase? RESEARCH & PROTOTYPING phase ow yeah!

	// we need to generate

	// from mds

	// everything that has YYYY-MM-DD in filename is good to go.

	// the index array structure should be (but not comfirmed yet) as below:

	// $index = array(
	// 				'slug-after-hashbang'=>array('timestamp'=>23234234, 'title'=>'Title from that mada', 'excerpt'=>'first para without img'),
	// 				'slug-after-hashbang'=>array('timestamp'=>23234234, 'title'=>'Title from that mada', 'excerpt'=>'first para without img'),
	// 				'slug-after-hashbang'=>array('timestamp'=>23234234, 'title'=>'Title from that mada', 'excerpt'=>'first para without img'),
	// 				'slug-after-hashbang'=>array('timestamp'=>23234234, 'title'=>'Title from that mada', 'excerpt'=>'first para without img'),
	// 			);

	// in json mind you. :)
	
	## Configurations:

	CONST MARKDOWN_DIR = 'posts';


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

	// generate index
	// generate archive


	// latest 10:
	for($ii = 0; ($ii < 10 && $ii < count($posts)) ; $ii++){
		$latest[] = $posts[$ii];

		$li[] = '<li><a href="'.read_url($posts[$ii]['slug']).'">'.$posts[$ii]['title'].'</a></li>';
	}
	// latest list
	$latest_list = implode($li);

	include('parsedown.php');
	$Parsedown = new Parsedown();

	foreach($posts as $i=>$post){
		$md = file_get_contents('posts/'.($post['filename']));
		$md = str_replace('(images/', '(../images/', $md);
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
		$vars['datetime'] = date('d M Y');
		$vars['img'] = get_first_image($md);
		$vars['content'] = $Parsedown->text($md);
		$vars['about'] = get_domain().'/read/tentang-robotys.html';

		$template = $read_template;

		foreach($vars as $key=>$value){
			$template = str_replace('{{'.$key.'}}', $value, $template);
		}

		file_put_contents('read/'.$vars['slug'].'.html', $template);
	}


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