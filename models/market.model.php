<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления отображением баннеров
 */
class MD_Market extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel() {
        
    }

    /**
     * Оформление заказа
     * @return array
     */
    public static function order($phone, $address, $get_myself ,$date_time) {
        // Проверяем номер телефона
        if (!$phone = String::toPhone($phone))
            $error = "Введите номер телефона в правильном формате";

        if (empty($_SESSION['trash']) || sizeof($_SESSION['trash']) == 0)
            $error = "Вы должны добавить в корзину хотя бы 1 блюдо";

        

        $fmin = DB::getRecord('kazan_market_orders',
            'ip=' . DB::quote(Router::getClientIp()) .
            ' AND start_time > NOW() - INTERVAL 5 MINUTE'
        );
        if ($fmin)
            $error = 'С важего ip уже был отправлен заказ. Подождите 5 мин.';

        if (!empty($error))
            return $error;
        //Вставка в историю.


        


        $items = $_SESSION['trash'];
        $products = array();
        foreach ($items as $item) {
            array_push($products, $item['item_id']);
        }
        $unique = array_unique($products);
        $on = implode (',', $unique);
        DB::update('kazan_market_products', array('orders_count'=>'orders_count+1'), "id IN ($on)",FALSE);

        $user_id = intval($_SESSION['user_id']);
        $data = array(
            'items' => DB::quote(serialize($items)),
            'status' => 1,
            'start_time' => 'NOW()',
            'address' => DB::quote($address),
            'phone' => String::toPhone($phone),
            'ip' => DB::quote(Router::getClientIp()),
            'user_id' => intval($_SESSION['user_id']),
            'get_myself' => $get_myself == 1 ? 1 : 0
        );
        //Добавление или изменении данных о пользователе - телефон и адресс доставки
        $data_additional = array(
            'market_address' => $address,
            'market_phone' => String::toPhone($phone),
            'user_id' => $user_id
        );
        $inDB = DB::getCount('user_additional', "user_id = '$user_id'");
            if ($inDB) {
                DB::update('user_additional', $data_additional, "user_id = '$user_id'");
            } else {
                DB::insert('user_additional', $data_additional);
            }
        ////////////////////////////////////////////////
        DB::insert('kazan_market_orders', $data,FALSE);
        $admin_phone = String::toPhone(Config::getValue('site', 'mob_phone'));
        $text = 'Новый заказ';
        MD_Sms::sendSms($admin_phone, $text);

        $sms_user_text = 'Ваш заказ принят. Скоро вам позвонит наш менеджер';
        MD_Sms::sendSms($phone, $sms_user_text);

        return '<span style="color:green">Ваш заказ принят</span>';
    }

    public static function getTree($parent_id = 0,& $out='') {
        if (DB::getCount('kazan_market_tree', "parent_id = '$parent_id' AND doc_id=0") > 0) {
            $query = "SELECT * FROM kazan_market_tree WHERE parent_id = '$parent_id' AND doc_id=0 ORDER BY order_by";
            $result = mysql_query($query);
            if ($parent_id == 0) $class = 'class="tree_menu" id="tree_menu"'; else  $class = '';
            $out .=  '<ul ' . $class . '>';
            while ($row = mysql_fetch_array($result)) {
                if (Router::GetRouteIndex(3) == 'category' && Router::GetRouteIndex(4) == $row['id']) $active = 'class="active"';
                else $active = '';
                if (DB::getCount('kazan_market_products', "parent_id = '$row[id]'") > 0)
                $out .= "<li><a href='/product/list/category/$row[id]' $active >$row[title]</a>";
                else  $out .= "<li><div $active >$row[title]</div>";
                self::getTree($row['id'],$out); //recursive
                $out .= "</li>";
                
            }
            $out .= "</ul>";

        }
        return $out;
    }
    

}