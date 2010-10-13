<?php
require_once "adminModule.class.php";

class Main extends AdminModule {

    public static function add() {
        self::setTitle("Добавить страницу");
        self::showTemplate();
    }

    public static function save() {
        return true;
    }

    public static function edit() {
        return true;
    }

    public static function apply() {
        return true;
    }

    public static function saveEdit() {
        return true;
    }

    public static function showList() {
        $data['clients']['all'] = DB::getCount('user');
        $data['clients']['m'] = DB::getCount('user','user_profile_sex = 1');
        $data['clients']['w'] = DB::getCount('user','user_profile_sex = 2');
        $data['clients']['o'] = DB::getCount('user','user_profile_sex = 3');
        $data['products']['all'] = DB::getCount('kazan_market_products');
        $data['products']['n_h'] = DB::getCount('kazan_market_products','expired = 1');
        $data['products']['d'] = DB::getCount('kazan_market_products','discount > 0');
        $data['products']['o_m'] = DB::getCount('kazan_market_products','on_main = 1');
        $data['products']['new'] = DB::getCount('kazan_market_products','type = 1');
        $data['products']['rd'] = DB::getCount('kazan_market_products','type = 2');
        $data['products']['w_o_p'] = DB::getCount('kazan_market_products','image = ""');
        $data['orders']['all'] = DB::getCount('kazan_market_orders');
        $data['orders']['cancel'] = DB::getCount('kazan_market_orders','o_status = 4');
        $html = View::getXSLT($data, 'admin/main_page');
        self::showTemplate($html);
    }


}