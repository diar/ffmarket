<?php

/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Главная страница, по умолчанию действие Index
 */
class user_Page extends View {
    /*
     * Инициализация контроллера
     */

    public static function initController($action) {

    }

    /*
     * авторизация по аяякс
     */

    public static function loginAjaxAction($id) {
        echo MD_Auth::login($_POST['login'], $_POST['password'], $_POST['remember']);
    }

    /*
     * Регистрация по аякс
     */

    public static function registrationAjaxAction($id) {
        echo MD_Auth::registration($_POST['name'], $_POST['mail'], $_POST['phone']);
    }

    /*
     * Страница входа
     */

    public static function authAction() {
        $error = null;
        if (!empty($_POST['login']) && !empty($_POST['login'])) {


            $remember = !empty($_POST['remember']) ? true : false;
            $login = MD_Auth::login($_POST['login'], $_POST['password'], $remember);

            switch ($login) {
                case 'SPACE':
                    $error = 'Заполните поле e-mail и пароль';
                    break;
                case 'NOT_EXIST':
                    $error = 'Неверный e-mail или пароль';
                    break;
                case 'OK':
                    Router::setPage('/');
                    die();
                    break;
                case 'LOGIN':
                    $error = 'Неверный логин';
                    break;
                default :
                    $error = $login;
                    break;
            }
        }
        self::$page['header']['content']['error'] = $error;
        self::showXSLT('pages/user/auth');
    }

    /**
     * Восстановление пароля
     */
    public static function rememberAction() {
        $error = null;
        if (!empty($_POST['login'])) {
            $response = MD_Auth::passwd($_POST['login']);
            switch ($response) {
                case 'SPACE':
                    $error = 'Введите e-mail';
                    break;
                case 'OK':
                    $error = '<span style="color:#009900">Пароль выслан</span>';
                    break;
                case 'LOGIN':
                    $error = 'Неверный логин';
                    break;
                default:
                    $error = $response;
            }
        }
        self::$page['header']['content']['message'] = $error;
        self::showXSLT('pages/user/remember');
    }

    /**
     * Регистрация
     */
    public static function registrationAction() {
        $error = null;

        if (!empty($_POST['email']) && !empty($_POST['name'])) {
            if (!isset($_POST['apply']) or $_POST['apply'] == false)
                $error = "Ознакомтесь с правилами";
            else {
                $response = MD_Auth::registration($_POST['name'], $_POST['email']);
                switch ($response) {
                    case 'SPACE':
                        $error = 'Заполните все поля предложенной формы';
                        break;
                    case 'OK':
                        //$error = '<span style="color: #009900;">Регистрация прошла успешно, пароль выслан на e-mail</span>';
                        Router::setPage('/');
                        break;
                    case 'NOT_MAIL':
                        $error = 'Неверный адрес электронный почты';
                        break;
                    case 'MAIL_EXIST':
                        $error = 'Вы уже зарегистрированы, <a href="/user/remember">восстановить пароль?</a>';
                        break;
                    default :
                        $error = 'Неизвестная ошибка';
                        break;
                }
            }
        }
        self::$page['header']['content']['message'] = $error;
        self::showXSLT('pages/user/registration');
    }


    /**
     * 
     */
    public static function trashAction() {
        $message = '';
        if (!empty($_POST['phone']) && !empty ($_POST['address'])) {
            $date_time = $_POST['day'].".".$_POST['month']." ".$_POST['time'];
            $get_myself = !empty($_POST['get_myself']) ? 1 : 0;
            $message = MD_Market::order($_POST['phone'], $_POST['address'], $get_myself ,$date_time);
            self::$page['header']['content']['message'] = 'Заказ принят. Скоро с Вами свяжуться';
        } elseif (empty($_POST['phone']) && empty ($_POST['address']) && !empty($_POST)){
            $message = 'Заполните пожалуйста поля телефон и адрес.';
        }
        
        $itog = 0;
        $trash = isset($_SESSION['trash']) ? $_SESSION['trash'] : "";
        if (!empty($trash)) {
            foreach ($trash as &$item) {
                $present = $item['is_present'] > 0 ? 200 : 0;
                $itog += $item['gen_price'] = $item['count'] * $item['price'] + $present;
                $item['tmb_image'] = DB::getValue('kazan_market_products', 'tmb_image',"id = '$item[item_id]'");
            }
        }
        self::$page['header']['content']['user'] = DB::getRecord('user_additional',"user_id = '$_SESSION[user_id]'");
        self::$page['header']['content']['message'] = $message;
        self::$page['header']['content']['itog'] = $itog;
        self::$page['header']['content']['trash'] = $trash;

        self::showXSLT('pages/user/trash');
    }

    public static function removeFromTrashAjaxAction() {
        if (isset($_SESSION['trash']) && count($_SESSION['trash']) > 0) {
            $z = 0;
            $trash = $_SESSION['trash'];
            unset($_SESSION['trash']);
            foreach ($trash as $item) {
                if ($item['item_id'] != $_POST['item_id']) {
                    $_SESSION['trash'][$z] = $item;
                    $z++;
                }
                
                
            }
            //print_r($_SESSION);
        }
    }

    public static function trashInfoAjaxAction() {
       $trash = !empty($_SESSION['trash']) ? $_SESSION['trash'] : null;
        if (sizeof($trash) > 0) {
            $gen_price = 0;
            foreach ($trash AS $item) {
                $gen_price+=$item['price'] * $item['count'];
            }
        } else $gen_price = 0;
        echo '<a href="/user/trash">Корзина</a><br>Заказ на <span id="trash_gen_price">'.$gen_price.'</span> Р';
    }

    /**
     * Выход
     */
    public static function logoutAction() {
        User::logout();
        Router::setPage("/");
    }

}