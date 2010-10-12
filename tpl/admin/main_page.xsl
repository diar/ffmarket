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
                <span>Всего на сайте:</span><br/>
                <span>Нет в наличии:</span><br/>
                <span>Со скидкой:</span><br/>
                <span>На витрине:</span><br/>
                <span>Новые:</span><br/>
                <span>Рекомендованные:</span><br/>
                <span>Без фото:</span><br/>
                <span>Средняя цена:</span><br/>
            </div>
        </div>
        <div class="bg_block s_orders">
            <div class="caption">Заказы</div>
            <div>
                <span>Всего:</span><br/>
                <span>Со скидкой:</span><br/>
                <span>Средняя цена:</span><br/>
                <span>Отмененные:</span><br/>
                <span>Повторные:</span><br/>
                <span>Не выполненные:</span><br/>
            </div>
        </div>
        <div class="bg_block s_clients">
            <div class="caption">Клиенты</div>
            <span>Всего:</span><br/>
            <span>Мужчины:</span><br/>
            <span>Женщины:</span><br/>
        </div>
        
    </xsl:template>


</xsl:stylesheet>