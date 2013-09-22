$(function() {
	
	function pages(pg, display, chNum) {
		var maxPG = Math.ceil(display / chNum);
		// disable newer if at page 1
		if(pg === 1) {
			$('[data-direction="back"]').attr('disabled', true);
		} else {
			$('[data-direction="back"]').attr('disabled', false);
		} 
		// disable older if at last page
		if(pg === maxPG) {
			$('[data-direction="next"]').attr('disabled', true);
		} else {
			$('[data-direction="next"]').attr('disabled', false);
		} 
		$('.pg-num').text(pg);
	}

	function displayRVs(x, a, b, c, d, e) {
		$('.rv').remove();
		$('.content').append( x[a] );
		$('.content').append( x[b] );
		$('.content').append( x[c] );
		$('.content').append( x[d] );
		$('.content').append( x[e] );
	}

	
	function changepage(x, y) {
		// should go down by 5
		var one = y; // 58
		var two = y - 1; // 57
		var three = y - 2; // 56
		var four = y - 3; // 55
		var five = y - 4; // 54
		displayRVs(x, one, two, three, four, five);
	}
		
	$.get('!rsrc/get-stuff.php', function(data) {
		$.getJSON('rvs.json', function(data) {
			$.each(data, function(index, rvs) {
				var setup = [];
				for(var i = 0; i < rvs.length; i++) {
					var name = '<li><h2>#' + rvs[i].number + ' ' + rvs[i].name + '</h2></li>';
					var user = '<li><strong>Submitted by:</strong> ' + rvs[i].user + '</li>';
					var tags = rvs[i].tags;
					if(tags) {
						var tags = '<li><strong>Tags:</strong> ' + tags + '</li>';
					}
					var description = '<li><strong>Description:</strong> ' + rvs[i].description + '</li>';
					var image = rvs[i].image;
					if(image) {
						var image = '<li><img src="' + image + '" /></li>';
					}							
					var date = '<li><strong>Spotted on:</strong> ' + rvs[i].date + '</li>';
					setup.push('<ul class="rv" id="' + rvs[i].number + '">' + name + user + tags + description + image + date + '</ul>');
				}
				var chNum = 5;
				var mult = 0;
				var pg = 1;
								
				$(document).on('click', '.nav-link', function() {
					var dir = $(this).data('direction');
					// increase or decrease the multiplier and the page numbers
					if(dir === 'next') {
						pg++;
						mult++;
					} else {
						pg--;
						mult--;
					}
					// multiply the number of RVs shown by the page number
					var newNum = chNum * mult;
					// fix the number of the array
					var display = setup.length - 1;
					changepage(setup, display - newNum);
					// send off the page number to enable or disable the buttons based on the page number
					pages(pg, display, chNum);
					
				});
								
				changepage(setup, setup.length-1);
				
			});
		});
	});
	
	
	
	$('.submitrv').on('click', function() {
	
		var username = $('#name').val();
		var rvname = $('#rvname').val();
		var tags = $('#tags').val();
		var description = $('#description').val();
		var image = $('#image').val();
		//console.log(username);	
	
		$.post('!rsrc/upload.php', {username:username, rvname:rvname,tags:tags,description:description, image:image}, function(data) {
			console.log(data);
		});
	});
		
});
