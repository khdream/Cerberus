<?php
    session_start();
    date_default_timezone_set('Europe/Istanbul');

    $site_url = '2vqjlbjgbgvwprw75cuurypoyx7ppuga5acl457o5bkcn5gxeueulyyd.onion';
    $base_name = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);

    try {
        $db = new PDO('mysql:host=localhost;dbname=bot;charset=utf8', 'non-root', 'nH61N39rD');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    function c($input = null) {
        return htmlspecialchars(strip_tags($input));
    }

    function verify_admin() {
        if (!isset($_SESSION['login'])) {
            header('Location: index.php');
            exit();
        }
    }

    function create_log($log_type, $log_content = '') {
        global $db;
        if (isset($_SESSION['login'])) {
            $log_creator = $_SESSION['login'];
        } else {
            $log_creator = $_SERVER['REMOTE_ADDR'];
        }

        $query = $db->prepare('INSERT INTO logs SET log_type = ?, log_content = ?, log_creator = ?');
        $query->execute([$log_type, $log_content, $log_creator]);
    }

    function generateRandomString($length = 10, $mfa = 1) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($mfa == 1) $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }