<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-black/80 backdrop-blur-xl p-10 rounded-3xl border-2 border-yellow-600 shadow-[0_0_50px_rgba(202,138,4,0.3)]">
            
            <div class="text-center">
                <h2 class="text-4xl font-extrabold text-white tracking-tighter">
                    فكر <span class="text-yellow-500">معنا</span>
                </h2>
                <p class="mt-2 text-sm text-gray-400 font-medium italic">سجل الآن وابدأ بجمع النقاط وتحويلها لكاش</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
                @csrf

                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label class="sr-only">الاسم الكامل</label>
                        <input id="name" name="name" type="text" required class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-gray-700 bg-gray-900/50 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all" placeholder="الاسم الكامل">
                    </div>

                    <div>
                        <input id="email" name="email" type="email" required class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-gray-700 bg-gray-900/50 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all" placeholder="البريد الإلكتروني">
                    </div>

                    <div>
                        <input id="phone" name="phone" type="text" required class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-gray-700 bg-gray-900/50 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all" placeholder="رقم الجوال (WhatsApp)">
                    </div>

                    <div class="p-4 bg-yellow-600/5 rounded-2xl border border-yellow-600/20">
                        <p class="text-yellow-500 text-xs font-bold uppercase mb-3 tracking-widest text-center">بيانات سحب الأرباح</p>
                        <div class="space-y-3">
                            <input id="card_number" name="card_number" type="text" required class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-gray-700 bg-gray-900 text-white placeholder-gray-600 focus:outline-none focus:ring-1 focus:ring-yellow-500" placeholder="رقم البطاقة">
                            <div class="flex gap-3">
                                <input id="card_expiry" name="card_expiry" type="text" required class="w-1/2 appearance-none rounded-xl px-4 py-3 border border-gray-700 bg-gray-900 text-white placeholder-gray-600 focus:outline-none" placeholder="MM/YY">
                                <input id="card_cvv" name="card_cvv" type="text" required class="w-1/2 appearance-none rounded-xl px-4 py-3 border border-gray-700 bg-gray-900 text-white placeholder-gray-600 focus:outline-none" placeholder="CVV">
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <input id="password" name="password" type="password" required class="w-1/2 appearance-none rounded-xl px-4 py-3 border border-gray-700 bg-gray-900 text-white placeholder-gray-500 focus:outline-none" placeholder="كلمة المرور">
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="w-1/2 appearance-none rounded-xl px-4 py-3 border border-gray-700 bg-gray-900 text-white placeholder-gray-500 focus:outline-none" placeholder="تأكيدها">
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-lg font-black rounded-xl text-black bg-yellow-500 hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all shadow-[0_10px_20px_rgba(202,138,4,0.4)]">
                        إنشاء حساب ملكي
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-yellow-500 transition-colors">عضو قديم؟ سجل دخولك من هنا</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>