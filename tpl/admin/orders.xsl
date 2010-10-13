<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <xsl:template match="/">
    <div class="left">
				<div class="title">Заказы</div>
                <div class="sort_menu">
                	<a href="admin.php?page=orders&amp;status=1">Новые</a>
                    <a href="admin.php?page=orders&amp;status=2">Исполняются</a>
                    <a href="admin.php?page=orders&amp;status=3">Выполненные</a>
                    <a href="admin.php?page=orders&amp;status=4">Отмененные</a>
                </div>
           </div>
           <div class="right">

                <div class="order_sort_form">
                	<form method='POST' >
                    	<div class="radio"><input type="radio" name="period" value="today" checked="checked" /> <label for="date">За сегодня</label></div>
                        <div class="radio"><input type="radio" name="period" value="day3"/> <label for="date">За 3 дня</label></div>
                        <div class="radio"><input type="radio" name="period" value="on_period"/> <label for="date">За периуд</label></div>
                        <table class="period_sort">
                        	<tr>
                            	<td class="caption">c</td>
                                <td><input type="text" name="s_date" /></td>
                            </tr>
                            <tr>
                            	<td class="caption">по</td>
                                <td><input type="text" name="e_date"/></td>
                            </tr>
                            <tr>
                            	<td class="caption"> </td>
                                <td><input type="submit" value="Показать заказы" /></td>
                            </tr>
                        </table>

                    </form>
                </div>
			<div class="orders">
            	<xsl:apply-templates select="root/orders" />
            </div>

           </div>
           <div class="clear"></div>
  </xsl:template>
<xsl:template match="orders/item">
	<div class="item">
            <div class="info">
            <span class="function_line2" >-</span> 
            <span class="number_order">№ <xsl:value-of select="id"/></span> 
            <span class="print_icon"><img src="images/print_icon.png" alt="Печать" /></span> 
            
            <div class="change_status_form"> 

            	<form action="admin.php?page=orders&amp;action=changeStatus&amp;id={id}" method="post">
                <select name="status">
                    <option value="Принят">Принят</option>
                    <option value="Исполняется">Исполняется</option>
                    <option value="Завершен">Завершен</option>
                    <option value="Отменен">Отменен</option>
                </select> <input type="submit" value="ok" name="sumbit" /></form>
	        </div>
	        <div class="change_status"> Статус:</div>
        </div>
        <table>
           <xsl:apply-templates select="items" />
        </table>
        <div class="address">
        Доставка: <xsl:value-of select="address" /> <br />
        Телефон: <xsl:value-of select="phone" /> 
        </div>
		<div class="trash_itogo">Итого:  <xsl:value-of select="gen_price" /> р</div>
    </div>
</xsl:template>

<xsl:template match="items/item">
 <tr>
            <xsl:if test="position() = count(../item)">
                <xsl:attribute name="class">last</xsl:attribute>
            </xsl:if>
                <td class="image">
                    <img src="/upload/images/products/tmb/{tmb_image}" alt="{title}" />
                </td>
                <td class="description">
                    <xsl:value-of select="title" /><br />
                    Вес: <xsl:value-of select="size" />		<br /><br />
                    <input type="checkbox" name="present" value="1" class="present">
                    <xsl:if test="is_present = 1"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if>
                    </input> В подарочной упаковке
                </td>
                <td class="number">
                <input type="number" class="count" value="{count}"/> шт.
                <div class="price_per_one" style="display:none;"><xsl:value-of select="price" /></div>
                </td>
                <td class="price"><span class="gen_price"><xsl:value-of select="gen_price" /></span> Р</td>
                <td class="functions">
                <input type="hidden" class="item_id" value="{item_id}" />
                <input type="hidden" class="size" value="{size}" />
                <img src="/public/images/trash_del_icon.jpg" class="delete" alt="Удалить"/></td>
            </tr>
</xsl:template>
</xsl:stylesheet>