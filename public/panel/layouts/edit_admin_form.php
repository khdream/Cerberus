<div class="mt-10">
    <div class="sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <?php if(@$_GET['e'] == 'already_exists'): ?>
                    <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md mb-4" role="alert">
                        <div class="flex">
                            <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                            <div>
                                <p class="font-bold">Kullanıcı adı mevcut!</p>
                                <p class="text-sm">Bu kullanıcı adıyla kayıtlı bir admin var! Başka bir kullanıcı adı deneyin.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <form action="op.php?o=edit_admin&id=<?=$query['id']?>" method="post">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="username" class="block text-sm font-medium text-gray-700">Kullanıcı Adı</label>
                                    <input type="text" name="username" id="username" autocomplete="username" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="<?=$query['username']?>">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Parola</label>
                                    <input type="text" name="password" id="password" autocomplete="password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                                    <select id="role" name="role" autocomplete="role" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option>Admin</option>
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Durum</label>
                                    <select id="status" name="status" autocomplete="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="1" <?=$query['status'] == 1 ? 'selected' : false; ?>>Aktif</option>
                                        <option value="0" <?=$query['status'] == 0 ? 'selected' : false; ?>>Pasif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Kaydet
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Admin Düzenle</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Bu alandan ilgili yöneticiyi düzenleyebilirsiniz.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>