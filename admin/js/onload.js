function send() {
//        var current = event[0].my.current;
//        var parent = event[0].my.parent;
//        var prev_sibling = event[0].my.prev_sibling;
        alert(1);
//        $.ajax({
//                type: "POST",
//                async: false,
//                url: "/ajax-move-node",
//                data: "parent="+parent+"&current="+current+"&prev_sibling="+prev_sibling
//        });
}

$(document).ready(
    function() {

	$('.add_to_tree').live('click',function(){
		$('input',$('#tree_menu')).parent().remove();
		level = parseInt($(this).attr('rel'));
		new_el = '<li rel='+level+'><input type="text" name="title" maxlength="150" size="10" id="input_el_title" /> <input type="button" value="ok" id="add_to_tree_el"/></li>'
		if (level == 0) $('#tree_menu').append(new_el);
		else $('li[rel='+level+'] ul:last',$('#tree_menu')).append(new_el);
		$('#tree_menu input').focus();
		return false;
	});
	
	$('.add_line').live('click',function(){
		add_line();
		set_line_function ();
	});
	
	$('.del_line').live('click',function(){
		$(this).parent().parent().remove();
		set_line_function ();
	});
	
	$("#add_to_tree_el").live('click',function(){
		title = $('#input_el_title').val();
		parent_id = $(this).parent().attr('rel');
		$.post('/admin/admin.php?page=product&action=addToTree',{
			'title':title,
			'parent_id':parent_id
			},function(data){
				if (data =='') {
					alert('Неудача.');
				} else {
					ul = $("#add_to_tree_el").parent().parent();
					$("#add_to_tree_el").parent().remove();
					ul.append('<li rel="'+data+'"><a href="#">'+title+'</a><a href="#" class="add_to_tree" rel="'+data+'"><img src="images/1.jpg" alt="Добавить раздел" /><a href="admin.php?page=product&action=add&parent_id='+data+'"><img src="images/add_product.jpg" alt="Добавить раздел" /></li>');
				}
		});
		
	});
//        $('ul#tree_menu div').live('click',function(){
//            _ul = $(this).parent().find('ul');
//            if (_ul.css('display') == 'none') _ul.show();
//            else _ul.hide();
//        });
        $('#tree_menu').NestedSortable(
	{
		accept: 'page-item1',
		noNestingClass: "no-nesting",
		opacity: .8,
		helperclass: 'placeholder',
		onChange: function(serialized) {
			alert(serialized[0].hash);
		},
		autoScroll: true,
		handle: '.sort-handle'
	}
);

//        $('ul#tree_menu').nestedSortable({
//					disableNesting: 'no-nest',
//					forcePlaceholderSize: true,
//					handle: 'div',
//					items: 'li',
//					opacity: .6,
//					placeholder: 'placeholder',
//					tabSize: 25,
//					tolerance: 'pointer',
//					toleranceElement: '> div',
//                                        autoScroll: true,
//                                        onChange:send
//
//
//				});
});

function add_line(){
	newline = '<tr><td><input type="text" name="size[]" /></td><td><input type="text" name="price[]" /></td><td><div class="function_line add_line">+</div></td></tr>';
	$('#size_price').append(newline);
	set_line_function ();
}



function set_line_function (){
	$('tr td div', $('#size_price')).html('-').attr('class','function_line del_line');
	$('tr td:last div', $('#size_price')).html('+').attr('class','function_line add_line');
}



