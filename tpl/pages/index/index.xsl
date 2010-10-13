<?xml version="1.0" encoding="UTF-8"?>
<!-- Главная страница -->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>

    <!-- Импорт макета -->
    <xsl:include href="../../layouts/layout.xsl" />
    <xsl:template match="/">
        <xsl:apply-templates select="root" />
    </xsl:template >

    <!-- Код страницы -->
    

    <xsl:template match="content">
		<div class="title" style="margin-left:1em;"><xsl:value-of select="title" /></div>
        <div id="list">
        	<xsl:apply-templates select="products/item" />
        </div>	
        <div class="clear"></div>
    </xsl:template>

    <xsl:template match="products/item"> 
        <div class="item" id="dish_{id}" >
            <xsl:choose>
                <xsl:when test="type = 'Новый продукт'">
                	<xsl:attribute name="class">item new</xsl:attribute>
                </xsl:when>
                <xsl:when test="type = 'Рекомендовано'">
	                <xsl:attribute name="class">item recomended</xsl:attribute>
                </xsl:when>
            </xsl:choose>
                    <div class="foto">
                        <a href="/product/view/{url}">
                            <img src="/upload/images/products/tmb/{tmb_image}" alt="{title}" />
                        </a>
                    </div>
                    <div class="title">
                        
                        <xsl:choose>
                <xsl:when test="type = 'Новый продукт'">
                	<span class="new">Новинка!</span> 
                </xsl:when>
                <xsl:when test="type = 'Рекомендовано'">
	                <span class="recomended">Рекомендуем!</span>
                </xsl:when>
            </xsl:choose>
                        <a href="/product/view/{url}"><xsl:value-of select="title" /></a>
                    </div>
                    
                    <div class="clear"></div>
                    <div class="description"><xsl:value-of select="description" /></div>
                    <xsl:choose>
                    	<xsl:when test="discount > 0">
                        <div class="sale"><span><xsl:value-of select="price" /></span> <xsl:value-of select="discount_price" /> Р</div>
                        </xsl:when>
                        <xsl:when test="expired =1">
                        <div class="sale">Нет в наличии</div>
                        </xsl:when>
                        <xsl:otherwise>
                        <div class="price"><xsl:value-of select="price" /> Р</div>
                        </xsl:otherwise>
                    </xsl:choose>
                    
		</div>
    </xsl:template>



</xsl:stylesheet>