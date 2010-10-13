<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <xsl:template match="/">
    
        <div class="title">Статистика</div>
        <div class="bg_block s_products">
            <div class="caption">Продукты</div>
            <div>
                <span>Всего на сайте: </span> <xsl:value-of select="//products/all" /><br/>
                <span>Нет в наличии: </span> <xsl:value-of select="//products/n_h" /><br/>
                <span>Со скидкой: </span> <xsl:value-of select="//products/d" /><br/>
                <span>На витрине: </span> <xsl:value-of select="//products/o_m" /><br/>
                <span>Новые:</span> <xsl:value-of select="//products/new" /><br/>
                <span>Рекомендованные:</span> <xsl:value-of select="//products/rd" /><br/>
                <span>Без фото:</span> <xsl:value-of select="//products/w_o_p" /><br/>
            </div>
        </div>
        <div class="bg_block s_orders">
            <div class="caption">Заказы</div>
            <div>
                <span>Всего: </span> <xsl:value-of select="//orders/all" /><br/>
                <span>Со скидкой:</span><br/>
                <span>Средняя цена:</span><br/>
                <span>Отмененные: </span> <xsl:value-of select="//orders/cancel" /><br/>
                <span>Повторные:</span><br/>
            </div>
        </div>
        <div class="bg_block s_clients">
            <div class="caption">Клиенты</div>
            <span>Всего: </span><xsl:value-of select="//clients/all" /><br/>
            <span>Мужчины: </span> <xsl:value-of select="//clients/m" /><br/>
            <span>Женщины: </span> <xsl:value-of select="//clients/w" /><br/>
            <span>Не определились: </span> <xsl:value-of select="//clients/o" /><br/>
        </div>
        
    </xsl:template>


</xsl:stylesheet>