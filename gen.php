<?php
	
	// we can be sloppy for these phase. What phase? RESEARCH & PROTOTYPING phase ow yeah!

	// we need to generate

	// from mds

	// everything that has YYYY-MM-DD in filename is good to go.

	// the index array structure should be (but not comfirmed yet) as below:

	// $index = array(
	// 				'slug-after-hashbang'=>'timestamp gmt',
	// 				'slug-after-hashbang'=>13456993454,
	// 				'slug-after-hashbang'=>13456993454,
	// 				'slug-after-hashbang'=>13456993454
	// 			);

	// in json mind you. :)
	
	## Configurations:

	CONST MARKDOWN_DIR = 'mds';



	## MAIN


	$mds = get_mds();

	foreach($mds as $filename){
		$ind = indexer($filename);

		$index[$ind['slug']] = $ind['timestamp'];
	}

	$data = json_encode($index);

	file_put_contents('public/index.json', $data);

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

		
		$ret['slug'] = $slug;
		$ret['timestamp'] = $timestamp;

		return $ret;
		
	}

	#################################

?>