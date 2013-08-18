var cheerio = require('cheerio');

exports.parse = function parse(html) {
	var groups = [];
	var current_group = null;

	// get a jQuery-like context
	var $ = cheerio.load(html);

	// forums are listed in the second table - the first is the current time
	var forumTable = $('#ctl00_cphRoblox_CenterColumn').children('table').eq(1);
	
	forumTable.find('tr').each(function parseRow() {
		var cells;
		// forum group rows have an id
		if($(this).attr('id')) {
			var link = $(this).find('a');
			current_group = {
				id: +link.attr('href').match(/ForumGroupID=(\d+)/)[1],
				name: link.text().trim(),
				forums: []
			}
			groups.push(current_group);
		}
		//entry
		else if(cells = $(this).children('td'), cells.length == 5) {
			var summary = cells.eq(1);
			var link = summary.find('a')
			var desc = summary.find('span')
			var forum = {
				id:   +link.attr('href').match(/ForumID=(\d+)/)[1],
				name: link.text().trim(),
				desc: desc.text().trim()
			}
			
			if(!current_group) throw Error('no group found for ' + JSON.stringify(forum))
			current_group.forums.push(forum);
		}
	});

	return groups;
}
