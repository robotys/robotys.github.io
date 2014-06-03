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
		}
	}

	// dumper($index);

	$data = json_encode($index);

	file_put_contents('assets/index.json', $data);

	echo 'done!';





	#################################
	########### FUNCTIONS ###########

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