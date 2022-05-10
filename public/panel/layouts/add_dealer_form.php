<div class="mt-10">
    <div class="sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="op.php?o=add_dealer" method="post">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="domain" class="block text-sm font-medium text-gray-700">
                                        Domain
                                    </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="domain" id="domain" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded sm:text-sm border-gray-300">
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label for="apicryptkey" class="block text-sm font-medium text-gray-700">API Anahtarı</label>
                                    <input type="text" name="apicryptkey" id="apicryptkey" autocomplete="apicryptkey" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-12 sm:col-span-6">
                                    <label for="privatekey" class="block text-sm font-medium text-gray-700">
                                        Kripto Anahtarı
                                    </label>
                                    <div class="mt-1">
                                        <textarea id="privatekey" name="privatekey" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"><?=generateRandomString(128, 0)?></textarea>
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="contact" class="block text-sm font-medium text-gray-700">İletişim Bilgisi</label>
                                    <input type="text" name="contact" id="contact" autocomplete="address-level2" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="serverinfo" class="block text-sm font-medium text-gray-700">Alt Bayi Adı</label>
                                    <input type="text" name="serverinfo" id="serverinfo" autocomplete="address-level1" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="other" class="block text-sm font-medium text-gray-700">Diğer Bilgiler</label>
                                    <input type="text" name="other" id="other" autocomplete="postal-code" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <label for="end_subscribe" class="block text-sm font-medium text-gray-700">Lisans Bitiş Tarihi</label>
                                    <input type="text" name="end_subscribe" id="end_subscribe" autocomplete="end_subscribe" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="2022-10-10">
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Ekle
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Yeni Bayi Ekle</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Bu alandan ekleyeceğiniz bayi kendi alt kullanıcılarını yönetebilecektir.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>