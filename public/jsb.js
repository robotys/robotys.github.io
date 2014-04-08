$(document).ready(function(){

	// get the index first of all

	$.get('index.json', function(post_index){

		// call other functions to generate all the stuff here
		// to make it synchronous.
		
		// 
		// var nav = [];
		var nav_li = '';
		var nav_limit = 15;
		var i = 0;
		$.each(post_index, function(slug,metadata){

			if(i < nav_limit){
				var permalink = '#/read/'+(metadata['slug']);

				nav_string = nav_template.replace('{{permalink}}', permalink);
				nav_string = nav_string.replace('{{title}}', metadata['title']);
				// nav_string = nav_string.replace('{{permalink}}', permalink);
				// nav_string = nav_string.replace('{{permalink}}', permalink);

				// console.log(nav_string);

				nav_li+= nav_string;
			}

			i++;

		});

		//inject into navigation
		$('#nav').html(nav_li);

	});

	

	// bind to navigation events of changing hash
	$(window).on('hashchange', function(){
		draw_content();
	});

	// console.log( textile('Kambing __AH__ kau *itu*'));


	function draw_content(){
		console.log(uri_segment());
	}


	function uri_segment(id){
		var str = window.location.hash;
		str = str.replace('#/','');
		var segments = str.split('/');
		// console.log(segments);

		if(id == null){ // hantar semua string
			return segments;
		}else{
			// hantar id je
			// id--;
			return segments[id];
		}
	}

	function is_home(){
		return (uri_segment(0) == "");
	}
});