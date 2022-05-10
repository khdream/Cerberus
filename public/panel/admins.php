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
                Admin Yönetimi
            </h1>
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 mt-4">
                <h1 class="text-2xl font-normal pb-3 text-indigo-600">Adminler</h1>
                <div class="text-right">
                    <a href="admins.php?o=add_admin" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Admin Ekle
                    </a>
                </div>
            </div>
            <?php require 'layouts/admins_table.php'; ?>
            <?php
                if (@$_GET['o'] === 'edit_admin' && isset($_GET['id'])) {
                    $edit_id = c($_GET['id']);
                    $query = $db->query("SELECT * FROM admins WHERE id = $edit_id")->fetch(PDO::FETCH_ASSOC);
                    require 'layouts/edit_admin_form.php';
                } else {
                    require 'layouts/add_admin_form.php';
                }
            ?>
        </div>
    </main>
</div>
</body>
</html>