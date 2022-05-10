<?php
require 'inc/head.php';
require 'func.php';
verify_admin();
?>
<body class="h-full">
<div class="min-h-full">
    <?php require 'inc/navbar.php'; ?>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Log Yönetimi
            </h1>
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 pt-10">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="inline-flex rounded-md shadow-sm pb-4" role="group">
                            <a href="?f=" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-l-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                Tümü
                            </a>
                            <a href="?f=login,fast_login" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                Başarılı Girişler/Çıkışlar
                            </a>
                            <a href="?f=invalid_login,invalid_mfa" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                Başarısız Girişler/Çıkışlar
                            </a>
                            <a href="?f=remove_admin,add_admin,edit_admin,delete_logs" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                Admin İşlemleri
                            </a>
                            <a href="?f=add_dealer,remove_dealer,edit_dealer" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                Bayi İşlemleri
                            </a>
                            <a href="?f=show_mfa,show_mfa_dealer" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                2 Adımlı İşlemleri
                            </a>
                            <a href="op.php?o=delete_all_logs" class="py-2 px-4 text-sm font-medium text-white bg-red-600 rounded-r-md border border-gray-200 hover:bg-red-500 focus:z-10 focus:ring-2 focus:ring-red-700">
                                Logları Temizle
                            </a>
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            İşlem
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Durum
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kullanıcı
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            İçerik
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tarih
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php
                                    if (c($_GET['f'])) {
                                        $f = explode(',' , c($_GET['f']));
                                        $sql = '';
                                        for ($i = 0; $i < count($f); $i++) {
                                            $sql .= "log_type = '$f[$i]' OR ";
                                        }
                                        $sql .= '1=0';
                                    } else {
                                        $sql = '1=1';
                                    }

                                    $p = c($_GET['p'] ?? 1);
                                    $limit = 10;
                                    $start = ($p - 1) * $limit;
                                    $page_count = $db->query("SELECT * FROM logs WHERE $sql")->rowCount();
                                    $page_count = ceil($page_count / $limit);

                                    $query = $db->query("SELECT * FROM logs WHERE $sql ORDER BY id DESC LIMIT $start, $limit", PDO::FETCH_ASSOC);
                                    if ($query->rowCount()) {
                                        foreach ($query as $row) { ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <?php
                                                            switch ($row['log_type']) {
                                                                case 'invalid_login': $err = 1; ?>
                                                                    <div class="rounded-full bg-yellow-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Giriş
                                                                        </div>
                                                                    </div>
                                                                <?php break;
                                                                case 'login': $err = 0; ?>
                                                                    <div class="rounded-full bg-gray-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Giriş
                                                                        </div>
                                                                    </div>
                                                                <?php break;
                                                                case 'invalid_mfa': $err = 1; ?>
                                                                    <div class="rounded-full bg-yellow-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Hatalı 2FA
                                                                        </div>
                                                                    </div>
                                                                <?php break;
                                                                case 'fast_login': $err = 0; ?>
                                                                    <div class="rounded-full bg-gray-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Hızlı Giriş
                                                                        </div>
                                                                    </div>
                                                                    <?php break;
                                                                case 'logout': $err = 0; ?>
                                                                    <div class="rounded-full bg-gray-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Çıkış
                                                                        </div>
                                                                    </div>
                                                                <?php break;
                                                                case 'remove_admin': $err = 0; ?>
                                                                    <div class="rounded-full bg-gray-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Admin Sil
                                                                        </div>
                                                                    </div>
                                                                <?php break;
                                                                case 'add_admin': $err = 0; ?>
                                                                    <div class="rounded-full bg-gray-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Admin Ekle
                                                                        </div>
                                                                    </div>
                                                                <?php break;
                                                                case 'edit_admin': $err = 0; ?>
                                                                    <div class="rounded-full bg-gray-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Admin Düzenle
                                                                        </div>
                                                                    </div>
                                                                <?php break;
                                                                case 'add_dealer': $err = 0; ?>
                                                                    <div class="rounded-full bg-gray-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Bayi Ekle
                                                                        </div>
                                                                    </div>
                                                                <?php break;
                                                                case 'edit_dealer': $err = 0; ?>
                                                                    <div class="rounded-full bg-gray-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Bayi Düzenle
                                                                        </div>
                                                                    </div>
                                                                <?php break;
                                                                case 'remove_dealer': $err = 0; ?>
                                                                    <div class="rounded-full bg-gray-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Bayi Sil
                                                                        </div>
                                                                    </div>
                                                                <?php break;
                                                                case 'show_mfa': $err = 0; ?>
                                                                    <div class="rounded-full bg-gray-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Admin MFA Görüntüle
                                                                        </div>
                                                                    </div>
                                                                <?php break;
                                                                case 'show_mfa_dealer': $err = 0; ?>
                                                                    <div class="rounded-full bg-gray-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Bayi MFA Görüntüle
                                                                        </div>
                                                                    </div>
                                                                    <?php break;
                                                                case 'delete_logs': $err = 0; ?>
                                                                    <div class="rounded-full bg-gray-200 text-center">
                                                                        <div class="flex items-center justify-center h-10 w-10">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            Logları Temizle
                                                                        </div>
                                                                    </div>
                                                                    <?php break;
                                                            }
                                                        ?>

                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <?php if($err == 1): ?>
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Hata
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Başarılı
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?=$row['log_creator']?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?php if($row['log_content']): ?>
                                                        <input class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text" value="<?=$row['log_content']?>">
                                                    <?php endif; ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?=$row['log_date']?>
                                                </td>
                                            </tr>
                                    <?php }} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white py-3 flex items-center justify-between border-t border-gray-200 float-right">
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <?php if($p != 1): ?>
                        <a href="?f=<?=c($_GET['f']) ? c($_GET['f']) : false?>&p=<?=$p-1?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php endif; ?>
                    <?php
                        for ($i = 1; $i < $page_count+1; $i++) { ?>
                            <a href="?f=<?=c($_GET['f']) ? c($_GET['f']) : false?>&p=<?=$i?>" class="<?=($p == $i) ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : false; ?> relative inline-flex items-center px-4 py-2 border text-sm font-medium"><?=$i?></a>
                        <?php }
                    ?>
                    <?php if($p < $page_count): ?>
                        <a href="?f=<?=c($_GET['f']) ? c($_GET['f']) : false?>&p=<?=$p+1?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </main>
</div>
</body>
</html>