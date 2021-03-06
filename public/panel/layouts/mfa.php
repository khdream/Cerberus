<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-auto text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">2 Adımlı Doğrulama</h2>
        </div>
        <form class="mt-8 space-y-6" action="op.php?o=mfa" method="post">
            <div class="rounded-md shadow-sm -space-y-px">
                <?php
                    $id = @$_SESSION['mfa'];
                    $query = $db->query("SELECT * FROM admins WHERE id = $id AND status = 1")->fetch(PDO::FETCH_ASSOC);
                    if (!$query['mfa_verify']) { ?>
                        <div class="bg-white p-2">
                            <p class="text-gray-600">Hesabınıza ilk defa giriş yaptığınız için aşağıda yer alan QR kodunu <b class="text-indigo-400">Google Authenticator</b> uygulamasına okutun.</p>
                            <hr class="mb-2 mt-2">
                            <img src="op.php?o=show_mfa" alt="">
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
                    Doğrula
                </button>
            </div>
        </form>
    </div>
</div>