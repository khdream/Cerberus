<?php
    require 'inc/head.php';
    require 'func.php';
?>

<body class="h-full">
    <?php
        if (!isset($_SESSION['login']) && !isset($_SESSION['mfa'])) {
            require 'layouts/login.php';
        } else if (isset($_SESSION['mfa'])) {
            require 'layouts/mfa.php';
        } else { ?>
            <div class="min-h-full">
                <?php require 'inc/navbar.php'; ?>
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h1 class="text-3xl font-bold text-gray-900">
                            Raporlar
                        </h1>
                    </div>
                </header>
                <main>
                    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                        <?php require 'layouts/stats.php'; ?>
                        <div class="grid grid-cols-2 mt-4">
                            <h1 class="text-2xl font-normal pb-3 text-indigo-600">Bayiler</h1>
                            <div class="text-right">
                                <a href="dealers.php?o=add_dealer" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Bayi Ekle
                                </a>
                            </div>
                        </div>
                        <?php require 'layouts/dealers_table.php'; ?>

                        <div class="grid grid-cols-2 mt-20">
                            <h1 class="text-2xl font-normal pb-3 text-indigo-600">Adminler</h1>
                            <div class="text-right">
                                <a href="admins.php?o=add_admin" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Admin Ekle
                                </a>
                            </div>
                        </div>
                        <?php require 'layouts/admins_table.php'; ?>
                    </div>
                </main>
            </div>
        <?php }
    ?>
</body>
</html>