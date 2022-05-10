<?php
    require 'func.php';
    require 'vendor/autoload.php';
    $g = new \Google\Authenticator\GoogleAuthenticator();

    $operation = c($_GET['o']);
    switch ($operation) {
        case 'login':
            $username = c($_POST['username']);
            $password = md5(c($_POST['password']));
            $query = $db->query("SELECT * FROM admins WHERE username = '$username' AND password = '$password' AND status = 1")->fetch(PDO::FETCH_ASSOC);
            if ($query) {
                $_SESSION['mfa'] = $query['id'];
            } else {
                create_log('invalid_login');
            }
            break;
        case 'mfa':
            $id = $_SESSION['mfa'];
            $query = $db->query("SELECT * FROM admins WHERE id = $id AND status = 1")->fetch(PDO::FETCH_ASSOC);
            if ($query) {
                if ($g->checkCode($query['mfa'], c($_POST['mfa']))) {
                    if ($query['mfa_verify'] == 0) {
                        $query2 = $db->prepare("UPDATE admins SET mfa_verify = ? WHERE id = $id");
                        $update = $query2->execute([1]);
                    }
                    unset($_SESSION['mfa']);
                    $_SESSION['login'] = $query['username'];
                    create_log('login');
                } else {
                    create_log('invalid_mfa', c($_POST['mfa']));
                    session_destroy();
                }
            }
            break;
        case 'logout':
            create_log('logout');
            session_destroy();
            break;
        case 'remove_admin':
            verify_admin();
            $id = c($_GET['id']);
            create_log('remove_admin', $id);
            $query = $db->prepare('DELETE FROM admins WHERE id = ?');
            $delete = $query->execute([$id]);
            break;
        case 'add_admin':
            verify_admin();
            $username = c($_POST['username']);
            $password = md5(c($_POST['password']));
            $status = c($_POST['status']);
            $mfa = generateRandomString();

            $query = $db->query("SELECT * FROM admins WHERE username = '$username'")->fetch(PDO::FETCH_ASSOC);
            if (!$query) {
                $query = $db->prepare('INSERT INTO admins SET username = ?, password = ?, mfa = ?, status = ?');
                $insert = $query->execute([$username, $password, $mfa, $status]);
                create_log('add_admin', $username);
                header('Location: admins.php');
            } else {
                header('Location: admins.php?e=already_exists');
            }
            exit;
            break;
            case 'edit_admin':
                verify_admin();
                $id = c($_GET['id']);
                $username = c($_POST['username']);
                $password = md5(c($_POST['password']));
                $status = c($_POST['status']);

                $query = $db->prepare("UPDATE admins SET username = ?, password = ?, status = ? WHERE id = $id");
                $update = $query->execute([$username, $password, $status]);
                create_log('edit_admin', $username);

                if ($_SESSION['login'] == $username) {
                    header('Location: op.php?o=logout');
                    exit;
                }
                break;
        case 'show_mfa':
            if (@!$_SESSION['mfa']) {
                verify_admin();
                $id = c($_GET['id']);
                $query = $db->query("SELECT * FROM admins WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
            } else {
                $id = $_SESSION['mfa'];
                $query = $db->query("SELECT * FROM admins WHERE id = $id AND mfa_verify = 0")->fetch(PDO::FETCH_ASSOC);
            }
            create_log('show_mfa', $id);
            if ($query) {
                header('Content-type:image/png');
                readfile($g->getURL($query['username'], $site_url, $query['mfa']));
            }
            exit;
            break;
        case 'show_mfa_dealer':
            if (@!$_SESSION['mfa']) {
                verify_admin();
                $id = c($_GET['id']);
                $query = $db->query("SELECT * FROM users WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
            } else {
                $id = $_SESSION['mfa'];
                $query = $db->query("SELECT * FROM users WHERE id = $id AND mfa_verify = 0")->fetch(PDO::FETCH_ASSOC);
            }
            create_log('show_mfa_dealer', $id);
            if ($query) {
                header('Content-type:image/png');
                readfile($g->getURL($query['contact'], $site_url, $query['mfa']));
            }
            exit;
            break;
        case 'add_dealer':
            verify_admin();
            $mfa = generateRandomString();
            $query = $db->prepare('INSERT INTO users SET privatekey = ?, contact = ?, serverinfo = ?, `domain` = ?, apicryptkey = ?, other = ?, end_subscribe = ?, mfa = ?');
            $insert = $query->execute([$_POST['privatekey'], $_POST['contact'], $_POST['serverinfo'], $_POST['domain'], $_POST['apicryptkey'], $_POST['other'], $_POST['end_subscribe'], $mfa]);
            create_log('add_dealer', $_POST['contact']);
            break;
        case 'remove_dealer':
            verify_admin();
            $id = c($_GET['id']);
            $query = $db->prepare('DELETE FROM users WHERE id = ?');
            $delete = $query->execute([$id]);
            create_log('remove_dealer', $id);
            break;
            break;
        case 'edit_dealer':
            verify_admin();
            $id = c($_GET['id']);
            $query = $db->prepare("UPDATE users SET privatekey = ?, contact = ?, serverinfo = ?, `domain` = ?, apicryptkey = ?, other = ?, end_subscribe = ? WHERE id = $id");
            $update = $query->execute([$_POST['privatekey'], $_POST['contact'], $_POST['serverinfo'], $_POST['domain'], $_POST['apicryptkey'], $_POST['other'], $_POST['end_subscribe']]);
            create_log('edit_dealer', $_POST['contact']);
            break;
        case 'fast_login':
            verify_admin();
            $id = c($_GET['id']);
            $query = $db->query("SELECT * FROM users WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
            $_SESSION['fast_login'] = $query['privatekey'];
            create_log('fast_login', $id);
            header('Location: ../');
            exit;
            break;
        case 'delete_all_logs':
            verify_admin();
            $delete = $db->exec("DELETE FROM logs");
            create_log('delete_logs');
            header('Location: logs.php');
            exit;
            break;
        default:
            header('Location: index.php');
            break;
    }
    header('Location: index.php');