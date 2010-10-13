<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns="http://www.w3.org/1999/xhtml">
    <xsl:output method="xml" indent="yes" encoding="utf-8"
                doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <!-- Макет -->
    <xsl:template match="root">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
            <head>
                <title> Доставка пиццы суши и ролл в Казани</title>
                <meta name="keywords" content="{site/keywords}" />
                <meta name="description" content="{site/description}" />
                <link rel="icon" type="image/vnd.microsoft.icon"  href="/public/images/favicon.ico" />
                <link rel="stylesheet" type="text/css" href="/public/css/style.css" />
                <link rel="stylesheet" type="text/css" href="/public/js/libs/lightbox/css/jquery.lightbox.css" />
                <xsl:comment><![CDATA[[if IE]>
                <link href="/public/css/ie.css" rel="stylesheet" type="text/css" />
                <![endif]]]>
                </xsl:comment>
            </head>
            <body>
                <xsl:apply-templates select="header" />
                
				<script type="text/javascript">
                    <xsl:text>user_auth = '</xsl:text>
                    <xsl:value-of select="//user/is_auth" />';
                </script>
                <script type="text/javascript" src="/public/js/libs/libs.js"></script>
                <script type="text/javascript" src="/public/js/libs/jquery.swfobject.1-1-1.min.js"></script>
                <script type="text/javascript" src="/public/js/system.js"></script>
                <script type="text/javascript" src="/public/js/main.js"></script>
            </body>
        </html>
    </xsl:template>

    <!-- Заголовок страницы -->
    <xsl:template match="header">
    <div id="top_bg"></div>
        <table id="main_table">
	<tr class="header">
    	<td class="left">
        	<div class="logo">
				<a href="/" alt="FFMarket.ru"><img src="/public/images/logo.png" alt="FF Market" /></a><br />
                <div class="logo_desc">
                   
                </div>
            </div>
        </td>
        <td class="margin"></td>
        <td class="right">
        <div class="floatRight">
         	<div class="sait_name"><xsl:value-of select="//site/name" /></div> 
	        <div class="telephone"> <xsl:value-of select="//site/phone" /></div>
            <div class="clear"></div>
        	<div id="banner">

            </div>
            <div class="menu">
            <xsl:apply-templates select="content_menu/item" />

            </div>
        </div>
        </td>
    </tr>
    <tr class="menu">
    	<td></td>
        <td></td>
        <td class="lk_menu"><xsl:if test="//user/is_auth = 1"><a href="/user/view/{//user/user_id}"><xsl:value-of select="//user/user_login" /></a>, <a href="/user/logout">выход</a></xsl:if></td>
    </tr>
    <tr class="body">
    	<td class="left">
        	<div class="to_magaz">
            	<a href="/">В магазин</a>
            </div>
            
            <ul class="tree_menu">
                <li><a href="#" class="active trash_link_menu">Корзина</a></li>
            </ul>
        </td>
            <td class="margin"></td>
            <td class="right">
                <xsl:apply-templates select="content"  />
            </td>
        </tr>
    </table>

    </xsl:template>
<div id="copyright">
            <div class="left">&#169; 2010 Diar group
                <br />
                <br />Дизайн —
                <a href="http://bpirok.ru">Большой Пирок</a>
            </div>
            <div class="smi">
                При полном или частичном цитировании,
                заимствовании, использовании ссылка обязательна.
            </div>
            
        </div>
        <div id="bg_bottom"></div>
<xsl:template match="content_menu/item">
    <a href="/page/view/{content_uri}"><xsl:value-of select="content_title" /></a>
</xsl:template>


    
</xsl:stylesheet>