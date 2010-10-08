
// Выполнение после загрузки на всех страницах
$(document).ready(function () {

		
		$(".present").change(function () {
			el = $(this).parent().parent();
			preparePrice (el);
			prepareItog();
		});

		$(".count").keyup(function () {
			el = $(this).parent().parent();
			preparePrice (el);
			prepareItog();
		});

                $(".delete").click(function(){
                    size = $(this).parents('td').children('input.size').val();
                    item_id = $(this).parents('td').children('input.item_id').val();
                    c_tr = $(this).parent().parent();
                    $.post('/user/removeFromTrash/',
                    {
                        'item_id':item_id,
                        'size':size
                    },function(data){
                       c_tr.remove();
                       prepareItog();
                       //alert(data);
                    });
                });
 
    
});






function getCount () {
	count = parseInt($(".count",el).val());
	if (isNaN(count)) count = 1;
	return count;	
}


function getPrice (el) {
	price = parseInt($(".price_per_one",el).html());
	return price;
}

function isPresent () {
	if ($(".present",el).attr('checked')) {
		return true;
	}
	else return false;
}


function preparePrice (el) {

	p_count = getCount(el);
	p_price = getPrice(el)*p_count;
	p_present = isPresent(el);
		
	if (p_present) p_price = p_price+200; 
	$(".gen_price",el).html(p_price);
}

function prepareItog() {
	var itog = 0;
	$(".gen_price").each(function(){
			itog += parseInt($(this).html());
		});
	$("#itog").html(itog);
}