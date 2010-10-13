<?xml version="1.0" encoding="UTF-8"?>
<!-- Главная страница -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <!-- Импорт макета -->
    <xsl:include href="../../layouts/trash.xsl" />
    <xsl:template match="/">
        <xsl:apply-templates select="root" />
    </xsl:template >

    <!-- Код страницы -->
    

    <xsl:template match="content">
		<div class="title">Способы оплаты</div>
            <div class="pay_mode">
            	<div class="message_red"><xsl:value-of select="message" disable-output-escaping="yes"/></div>
                <ul>
                    <li><input type="radio" name="pay_mode" disabled="disabled" /><span class="disabled">Картой Visa (кроме Visa Electron) или MasterCard</span></li>
                    <li><input type="radio" name="pay_mode" disabled="disabled" /><span class="disabled">WebMoney</span></li>
                    <li><input type="radio" name="pay_mode" disabled="disabled" /><span class="disabled">Яндекс.Деньги</span></li>
                    <li><input type="radio" name="pay_mode" disabled="disabled" /><span class="disabled">QIWI — Мобильный кошелек</span></li>
                    <li><input type="radio" name="pay_mode" checked="checked" />Пост оплата (Мы товар-вы деньги)</li>
                </ul>
            </div>
            <form method="post" action="/user/trash">
            <div class="title">Доставка по Казани (бесплатно)</div>
            <div class="trash_form">
            	<div class="phone">Контактный телефон: <input type="text" id="phone" name="phone" value="{user/market_phone}"/></div>
                <div class="address">Адрес:<br />
				<textarea name="address" id="address"><xsl:value-of select="user/market_address" /></textarea>
                </div>
				<div class="time">Удобное время: 
                <input type="text" id="day" name="day" value="{//date_today/day}" /> 
                <select name="month" id="month">
                    <option value="Января">
                    <xsl:if test="//date_today/month_number = 1">
                    	<xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    	Января
                    </option>
                    <option value="Февраля">
                     <xsl:if test="//date_today/month_number = 2">
                    	<xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    Февраля
                    </option>
                    <option value="Марта">
                     <xsl:if test="//date_today/month_number = 3">
                    	<xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    Марта
                    </option>
                    <option value="Апреля">
                     <xsl:if test="//date_today/month_number = 4">
                    	<xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    Апреля</option>
                    <option value="Мая">
                     <xsl:if test="//date_today/month_number = 5">
                    	<xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    Мая</option>
                    <option value="Июня"> 
                    <xsl:if test="//date_today/month_number = 6">
                    	<xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    Июня</option>
                    <option value="Июля">
                     <xsl:if test="//date_today/month_number = 7">
                    	<xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    Июля</option>
                    <option value="Августа">
                     <xsl:if test="//date_today/month_number = 8">
                    	<xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    Августа</option>
                    <option value="Сентября"> 
                    <xsl:if test="//date_today/month_number = 9">
                    	<xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if
                    >Сентября</option>
                    <option value="Октября">
                     <xsl:if test="//date_today/month_number = 10">
                    	<xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    Октября</option>
                    <option value="Ноября"> 
                    <xsl:if test="//date_today/month_number = 11">
                    	<xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    Ноября
                    </option>
                    <option value="Декабря"> 
                    <xsl:if test="//date_today/month_number = 12">
                    	<xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    Декабря
                    </option>
                </select>
                <input type="text" id="time" name="time" value="20:00"/>
                </div>
				<div class="get_myself">Забрать самому <input type="checkbox" name="get_myself" id="get_myself"/></div>
            </div>
            <xsl:if test="trash != ''">
            <div class="title">Товар<span>(Проверьте правильность заказа)</span></div>
            <div class="trash_list">
            	<table>
                	<xsl:apply-templates select="trash/item" />
                </table>
            </div>
            
            <div class="trash_itogo">Итого с доставкой: <span id="itog"><xsl:value-of select="itog" /></span> Р</div>
            <div class="trash_rules">Нажимая кнопку “Купить” Вы соглашаетесь с нашими <a href="/page/view/rules" target="_blank">правилами</a> магазина</div>
            
            <div class="trash_buy_button">
            	<input type="submit" value="Купить" id="buy" />
            </div>
            </xsl:if>
            </form>
            
    </xsl:template>

<xsl:template match="trash/item">
    <tr>
    <xsl:if test="position() = count(../item)">
    	<xsl:attribute name="class">last</xsl:attribute>
    </xsl:if>
        <td class="image">
        	<img src="/upload/images/products/tmb/{tmb_image}" alt="" />
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