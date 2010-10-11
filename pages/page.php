<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Контентная страница, по умолчанию действие Index
 */
class page_Page extends View {
    /*
     * Инициализация контроллера
     */

    public static function initController($action) {
       
        

    }

    /*
     * Страница 
     */
    public static function viewAction($id) {
        self::$page['header']['content'] = DB::getRecord('market_content', "content_uri = '$id'");
        self::showXSLT('pages/page/index');
    }


}
