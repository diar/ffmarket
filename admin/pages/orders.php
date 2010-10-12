<?php
require_once "adminModule.class.php";

class orders extends AdminModule {

    protected static $_title = "Страницы";
    protected static $_DB_table = 'market_content';

    public static function initModule () {
        self::addAction('add', 'Добавить страницу',7,true);
        self::start();
    }

    public static function add() {
        
    }

    public static function edit() {
       
    }

    public static function save() {
        $data = $_POST;
        DB::insert('market_content',$data);
    }

    public static function saveEdit() {
        $id = ELEMENT_ID;
        unset($_POST['id']);
        $data = $_POST;
        DB::update('market_content',$data,'id ='.$id);

    }

    public static function delete() {
        $id = ELEMENT_ID;
        DB::delete(self::getDbTable(),'id ='.$id);
        header('Location: admin.php?page=content', true, 303);
    }

    public static function showList() {

        $data['orders'] = self::getOrders();
        Debug::dump($data);
        $html = View::getXSLT($data, 'admin/orders');
        self::showTemplate($html);
    }

    public static function showJSON() {
        Debug::disable();
        $records = DB::getRecords("market_content", null, null, Array('select'=>'id,content_uri,content_title'));

        foreach ($records as &$record) {
            $editLink = self::getLink(PAGE, 'edit', $record['id']);
            $delLink = self::getLink(PAGE,'delete', $record['id']);
            $record['control']="<a href='$editLink'>Редактировать</a> | <a href='$delLink'>Удалить</a>";
        }

        echo Form::arrayToJqGrid($records, 1, 1, 1);
    }

    private static function getOrders($type=null,$date=null) {
        $orders = DB::getRecords('kazan_market_orders');

        foreach ($orders as &$item) {
            $item['items'] = unserialize($item['items']);
            $item['gen_price'] = 0;
            foreach ($item['items'] as &$product) {
                $item['gen_price'] +=$product['price']*$product['count'];
                $product['tmb_image'] = DB::getValue('kazan_market_products', 'tmb_image', "id = '$product[item_id]'");
            }

        }
        return $orders;
    }
}