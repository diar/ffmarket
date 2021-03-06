<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
    <head>
        <title><?=self::get('pageTitle');?> | Панель администратора</title>
        <link rel="stylesheet" type="text/css" href="/public/css/jquery-ui/flick/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="/admin/admin.css" />
        <link rel="stylesheet" type="text/css" href="/public/js/libs/grid/jquery.jqGrid.css" />
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("jquery", "1.4.2");
            google.load("jqueryui", "1.8");
            google.load("swfobject", "2.2");
        </script>
        <script type="text/javascript" src="/admin/js/jquery.form.js"></script>
        <script type="text/javascript" src="/admin/js/lib.js"></script>
        <script type="text/javascript" src="/admin/js/onload.js"></script>
     <script type="text/javascript" src="/engine/libs/ckeditor/ckeditor.js"></script>
       <script type="text/javascript" src="/engine/libs/filemanager/ajex.js"></script>
        <script type="text/javascript" src="/public/js/libs/grid/jquery.jqGrid.ru.js"></script>
        <script type="text/javascript" src="/public/js/libs/grid/jquery.jqGrid.min.js"></script>
        <script type="text/javascript" src="/public/js/libs/jquery.ui.nestedSortable.js"></script>
        


    </head>
    <body>
 <table>
	<tr class="header">
    	<td class="left">
        	<div class="logo">
				FF Market / CMS
            </div>
        </td>
        <td class="margin"></td>
        <td class="right">
	       <div class="menu">
				<a href="admin.php?page=settingsSite">Настройки сайта</a><a href="admin.php?page=content">Структура сайта</a><a href="admin.php?page=orders">Заказы</a><a href="admin.php">Статистика</a>
            </div>
        </td>
    </tr>
    <tr class="menu">
    	<td></td>
        <td></td>
        <?php $admin = self::get('admin');?>
        <div id="logout">
        </div>
        <td class="lk_menu"><?=$admin['login']?>, <a href="admin.php?logout">Выйти</a></td>
    </tr>
    <tr class="body">
    	<td class="left">

            <ul class="menu">
            	<li><a href="#" class="add_to_tree" rel="0">Добавить раздел</a></li>
            </ul>
            <?php AdminModule::get_tree();?>
            <div class="clear">
                <input type="button" id="save_tree" value="Сохранить структуру" />
            </div>
        </td>
        <td class="margin"></td>
        <td class="right">
        <div class="html">
          <?=self::get('html');?>
        </div>
        </td>
    </tr>
</table>

    </body>
</html>