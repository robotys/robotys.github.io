$(document).ready(function(){

	var nav_limit = 15;
	var front_content_limit = 15;
	// get the index first of all

	$.get('index.json', function(post_index){

		// call other functions to generate all the stuff here
		// to make it synchronous.
		draw_nav(post_index);
		draw_content(post_index);

		// bind to navigation events of changing hash
		$(window).on('hashchange', function(){
			draw_content(post_index);
		});
	});

	// console.log( textile('Kambing __AH__ kau *itu*'));


	function draw_content(post_index){
		
		// get to use object that contains only posts that we want to draw based on uri segment
		if(uri_segment(0) == ""){ // home, get front_limit_content and display it
			var to_use = obj_slice(post_index, 0, front_content_limit);
		}

		if(uri_segment(0) == "read"){
			var slug = uri_segment(1);
			var to_use = {};
			to_use[slug] = post_index[slug];
		}

		var to_use_limit = Object.size(to_use);

		// prepare the markdowns. Such a hassle because js is asynchronous!
		var mds = {};

		$.each(to_use, function(slug,metadata){


			var metadata = complete_metadata(metadata);
			// dapatkan mds from get. This is asynchronous!. Thus need a way to now if all is finished. Maybe we can cross check the need array in mds per key object is there then we go.
			$.get('posts/'+metadata['filename'], function(md){
				mds[metadata['slug']] = md;

				var current_mds_count = Object.size(mds);

				if(current_mds_count == to_use_limit) inject_content(to_use, mds);
			});
		});
			
	}

	function inject_content(metadata, mds){
		var htmls = '';

		$.each(mds, function(slug, md){
			metadata[slug]['content'] = prep_html(md);

			var content_temp = content_template;
			content = templater(content_template, metadata[slug]);

			htmls += content+'\n';
		});

		$('#content_wrapper').html(htmls);
	}

	function templater(template, metadata){

		var temp = template;
		
		$.each(metadata, function(key,value){
			temp = temp.replace('{{'+key+'}}', value);
		});
		
		return temp;
	}

	function prep_html(md){
		// remove #title because there exists one in metadata.
		
		var lines = md.split('\n');
		// remove one line, starting at the first position
		lines.splice(0,1);
		// join the array back into a single string
		var md = lines.join('\n');

		// convert to html with textile
		var html = textile(md);

		// send html back to whoever call

		return html;
	}

	function draw_nav(post_index){
		var nav_li = '';
		
		var i = 0;
		$.each(post_index, function(slug,metadata){
			// metadata = complete_metadata(metadata);

			var nav_string = nav_template;

			if(i < nav_limit){
				var permalink = '#/read/'+(metadata['slug']);

				nav_string = nav_string.replace('{{permalink}}', permalink);
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

	}

	function complete_metadata(metadata){
		metadata['datetime'] = get_datetime(metadata['timestamp']);
		// metadata['filename'] = get_filename(metadata);
		metadata['permalink'] = '#/read/'+metadata['slug'];

		return metadata;
	}

	function obj_slice(obj, start, end) {
		
	    var sliced = {};
	    var i = 0;
	    for (var k in obj) {
	    	
	        if (i >= start && i < end)
	            sliced[k] = obj[k];

	        i++;
	    }

	    return sliced;
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

	function get_datetime(UNIX_timestamp){
		var a = new Date(UNIX_timestamp*1000);
		var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
		var year = a.getFullYear();
		// var month = a.getMonth()+1;
		var month = months[a.getMonth()];
		var date = a.getDate();
		var hour = a.getHours();
		var min = a.getMinutes();
		var sec = a.getSeconds();
		var time = date+' '+month+' '+year;
		// var time = date+' '+month+' '+year+' '+hour+':'+min+':'+sec ;
		return time;
	}

	Object.size = function(obj) {
		var size = 0, key;
		for (key in obj) {
			if (obj.hasOwnProperty(key)) size++;
		}
		return size;
	};

});