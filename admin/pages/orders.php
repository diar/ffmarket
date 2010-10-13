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

        $type = !empty($_GET['status']) ? $_GET['status'] : null;
        $period = !empty($_POST['period']) ? $_POST['period'] : null;
        $s_date = !empty($_POST['s_date']) ? strtotime($_POST['s_date']) : null;
        $e_date = !empty($_POST['e_date']) ? strtotime($_POST['e_date']) : null;
        $data['orders'] = self::getOrders($type,$period,$s_date,$e_date);
        //Debug::dump($data);
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

    private static function getOrders($status=null,$period=null,$s_date=null,$e_date = null) {
        $where = '1=1 ';
        if(!empty($status)) $where .=" AND o_status = $status";
        else $where .= ' AND o_status = 1';
        if(!empty($period)) {
            switch ($period) {
                case 'today':
                    $s_date = date('Y-m-d');
                    $where .= " AND start_time > '$s_date'";
                    break;
                case 'day3':
                    $s_date = date('Y-m-d',time()-60*60*24*3);
                    $where .= " AND start_time > '$s_date'";
                    break;
                case 'on_period':
                    $s_date = !empty($s_date) ? date('Y-m-d',$s_date) : date('Y-m-d');
                    $e_date = !empty($e_date) ? date('Y-m-d',$e_date) : date('Y-m-d');
                    $where .= " AND start_time > $s_date AND start_time < $s_date";
            }
        }

        $orders = DB::getRecords('kazan_market_orders',$where);
        if (!empty($orders)) {
        foreach ($orders as &$item) {
            $item['items'] = unserialize($item['items']);
            $item['gen_price'] = 0;
            foreach ($item['items'] as &$product) {
                $product['gen_price'] = $product['price']*$product['count'];
                $item['gen_price'] +=$product['price']*$product['count'];
                $product['tmb_image'] = DB::getValue('kazan_market_products', 'tmb_image', "id = '$product[item_id]'");
            }

        }
        return $orders;
        }
    }
    public static function changeStatus() {
        $id = ELEMENT_ID;
        $status = !empty($_POST['status']) ? $_POST['status'] : 'Принят';
        $data = array(
            'o_status' => $status
        );
        DB::update('kazan_market_orders', $data, "id = $id");
        header('location: '.$_SERVER['HTTP_REFERER']);
    }
}