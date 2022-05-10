<?php
require 'vendor/autoload.php';
$g = new \Google\Authenticator\GoogleAuthenticator();

$site_url = 'moa2m2n4eg36nk4um5owuuibqau7rry7pbnrucssjw3i76klchhn2hid.onion';

require_once 'config.php';

if(isset($_GET['logout'])) {
    logOut();
}

if (isset($_SESSION['fast_login'])) {
    $query = $database->select('users', '*', ['privatekey' => $_SESSION['fast_login']]);
    setcookie('restApiUrl', $query[0]['domain']);
    $_SESSION['key'] = $query[0]['privatekey'];
    echo file_get_contents('index.html');
    exit;
}

if (isset($_SESSION['mfa'])) {
    echo file_get_contents('index.html');
    exit;
}
if (isset($_POST['mfa']) && isset($_SESSION['key'])) {
    $query = $database->select('users', '*', ['privatekey' => $_SESSION['key']]);
    if($g->checkCode($query[0]['mfa'], $_POST['mfa'])) {
        if ($query[0]['mfa_verify'] == 0) {
            $database->update('users', ['mfa_verify' => 1], ['privatekey' => $_SESSION['key']]);
        }
        $_SESSION['mfa'] = 1;
        setcookie('restApiUrl', $query[0]['domain']);
    } else {
        session_destroy();
    }
    header('Location: /');
}

if(isset($_POST['key']) && !isset($_SESSION['key'])) {
    $data = $database->select('users', '*', ['privatekey' => $_POST['key']]);
    if ($data) {
        $_SESSION['key'] = $_POST['key'];
        header('Location: index.php');
    } else {
        header('Location: ?e=1');
    }
} else {
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Control Panel</title>
    <script src="https://unpkg.com/tailwindcss-jit-cdn"></script>
</head>
<body class="h-full">
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-auto text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Control Panel</h2>
            </div>
            <?php if (isset($_SESSION['key'])): ?>
                <form class="mt-8 space-y-6" action="" method="post">
                    <div class="rounded-md shadow-sm -space-y-px">
                        <?php
                            $data = $database->select('users', '*', ['privatekey' => $_SESSION['key']]);
                            if (!$data[0]['mfa_verify']) { ?>
                                <div class="bg-white p-2">
                                    <p class="text-gray-600">Since you are logging into your account for the first time, scan the QR code below into the <b class="text-indigo-400">Google Authenticator</b> application.</p>
                                    <hr class="mb-2 mt-2">
                                    <img src="<?=$g->getURL($data[0]['contact'], $site_url, $data[0]['mfa'])?>" alt="">
                                </div>
                            <?php } ?>
                        <div>
                            <input id="mfa" name="mfa" type="mfa" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="666 666">
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                            Verify
                        </button>
                    </div>
                </form>
            <?php else: ?>
            <form class="mt-8 space-y-6" action="" method="post">
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <textarea id="key" name="key" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Private Key" autofocus></textarea>
                    </div>
                </div>
                <?php if (isset($_GET['e'])): ?>
                    <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md mb-4" role="alert">
                        <div class="flex">
                            <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                            <div>
                                <p class="font-bold">Invalid key!</p>
                                <p class="text-sm">The Private Key you entered is invalid.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Login
                    </button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php } ?>