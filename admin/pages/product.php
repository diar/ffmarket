<?php

require_once "adminModule.class.php";

class Product extends AdminModule {

    protected static $_title = "Продукт";
    protected static $_DB_table = 'market_products';

    public static function initModule() {
        self::start();
    }

    // Добавление ресторана
    public static function add() {
        $parent_id = intval($_GET['parent_id']) > 0 ? intval($_GET['parent_id']) : null;
        $content = array(
            'page_title' => 'Новый продукт',
            'save_link' => '?page=product&action=save'
        );
        $boxes = DB::getRecords('list_market_box');
        $content['boxes'] = $boxes;
        $content['parent_id'] = $parent_id;
        $html = View::getXSLT($content, 'admin/form_product');
        self::showTemplate($html);
        //self::validate($form);
    }

    // Изменение информации о ресторане
    public static function edit() {
        $id = ELEMENT_ID;
        if (!empty($_POST)) {
            $record = $_POST;
        } else {
            $record = DBP::getRecord('market_products', "id =" . $id);
        }
        $boxes = DB::getRecords('list_market_box');
        $record['boxes'] = $boxes;
        $record['title'] = $record['title'];
        $record['save_link'] = '?page=product&action=saveEdit';
        $record['size_price'] = unserialize($record['size_price']);
        $html = View::getXSLT($record, 'admin/form_product');
        self::showTemplate($html);
    }

    public static function goEdit() {
        if (ELEMENT_ID) {
            $id = ELEMENT_ID;
            $_SESSION['admin']['restaurant_id'] = $id;
            $_SESSION['admin']['restaurant'] = DBP::getRecord('rest', 'id=' . DB::quote($id));
            header('Location: admin.php?page=restaurants&action=edit', true, 303);
            die();
        }
    }

    public static function save() {
        $data = array();
        unset($_POST['submit']);
        unset($_POST['id']);
        $data = $_POST;
        //объединение size и price
        $size_price = array_combine($data['size'], $data['price']);
        $z = 0;
        foreach ($size_price as $k => $v) {
            $data['size_price'][$z]['size'] = $k;
            $data['size_price'][$z]['price'] = $v;
            $z++;
        }
        //удаляем не нужные элементы из массива
        unset($data['size'], $data['price']);
        //Преобразовываем в строку
        $data['size_price'] = serialize($data['size_price']);
        if (!empty($_FILES['image']['name']))
            $data['image'] = File::saveFile('image', null, Config::getValue('path', 'upload') . 'images/products');
        //малое изображение
        if (!empty($_FILES['tmb_image']['name']))
            $data['tmb_image'] = File::saveFile('tmb_image', null, Config::getValue('path', 'upload') . 'images/products/tmb');
        //Сертификат
        if (!empty($_FILES['sertificat']['name']))
            $data['sertificat'] = File::saveFile('sertificat', null, Config::getValue('path', 'upload') . 'images/sertificat');
        DBP::insert('market_products', $data);

        $tree = array(
            'parent_id' => $data['parent_id'],
            'title' => $data['title'],
            'doc_id' => DBP::lastInsertId()
        );
        DBP::insert('market_tree', $tree);
        header('location: admin.php?page=product');
    }

    public static function saveEdit() {
        $data = array();
        unset($_POST['submit']);
        $data = $_POST;
        unset($_POST['id']);
        $id = ELEMENT_ID;

        //объединение size и price
        $size_price = array_combine($data['size'], $data['price']);
        $z = 0;
        foreach ($size_price as $k => $v) {
            $data['size_price'][$z]['size'] = $k;
            $data['size_price'][$z]['price'] = $v;
            $z++;
        }
        //Debug::dump($data);
        //удаляем не нужные элементы из массива
        unset($data['size'], $data['price']);
        //Преобразовываем в строку
        $data['size_price'] = serialize($data['size_price']);
        //Большое изображени
        if (!empty($_FILES['image']['name']))
            $data['image'] = File::saveFile('image', null, Config::getValue('path', 'upload') . 'images/products');
        //малое изображение
        if (!empty($_FILES['tmb_image']['name']))
            $data['tmb_image'] = File::saveFile('tmb_image', null, Config::getValue('path', 'upload') . 'images/products/tmb');
        //Сертификат
        if (!empty($_FILES['sertificat']['name']))
            $data['sertificat'] = File::saveFile('sertificat', null, Config::getValue('path', 'upload') . 'images/sertificat');
        DBP::update('market_products', $data, 'id =' . $id);
        $title = array('title'=>$data['title']);
        DBP::update('market_tree', $title, 'doc_id =' . $id);
        header('location: admin.php?page=product');
    }

    public static function showList() {
        self::showTemplate();
    }


    public static function delete() {
        $id = ELEMENT_ID;
        DBP::delete(self::getDbTable(), 'id =' . $id);
        DBP::delete('market_tree', 'doc_id =' . $id);
        echo 'OK';
    }

    public static function addToTree() {
        $data = $_POST;
        DBP::insert('market_tree', $data);
        $last_id = DBP::lastInsertId();
        echo $last_id;
    }

     public static function saveTree() {
        $data = $_POST;
        $exp = explode("&",$data['array']);
        //print_r($exp);
        
        $reg ="/list\[([0-9]*)\]=(.*)/is";
        foreach ($exp as $item) {
            preg_match_all($reg, $item, $out);
                $item_id = !empty($out[1][0]) ? $out[1][0] : 0;
                $parent_id = $out[2][0] == 'root' ? 0 : $out[2][0];
                $update = array('parent_id'=>$parent_id);
                //echo $item_id."=>".$parent_id."<br>";
                DB::update('kazan_market_tree', $update, "id = '$item_id'");
                $doc_id = DB::getValue ('kazan_market_tree','doc_id',"id = '$item_id'");
                DB::update('kazan_market_products', $update, "id = '$doc_id'");
                //var_dump($return);

        }

    }

    public static function deleteCategory() {
        $id = ELEMENT_ID;
        DB::delete('kazan_market_tree', "id = '$id'");
        DB::delete('kazan_market_tree', "parent_id = '$id'");
        DB::update('kazan_market_products',array('parent_id' => 0) , "parent_id = '$id'");
    }

}