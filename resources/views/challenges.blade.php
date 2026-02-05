<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تحديات اليوم - فكر معنا</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: radial-gradient(circle, #1a202c 0%, #0d1117 100%); }
        .nav-glass { background: rgba(31, 41, 55, 0.8); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="text-white font-sans min-h-screen">

    <nav class="nav-glass border-b border-gray-700 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-6">
                <span class="text-2xl font-bold text-amber-500 tracking-tighter">🏆 فكر معنا</span>
                <div class="hidden md:flex gap-4 text-sm font-medium">
                    <a href="{{ url('/challenges') }}" class="text-amber-500 border-b-2 border-amber-500 pb-1">الرئيسية</a>
                    <a href="{{ url('/my-predictions') }}" class="text-gray-400 hover:text-white transition">توقعاتي</a>
                    <a href="{{ url('/leaderboard') }}" class="text-gray-400 hover:text-white transition">المتصدرين 🔥</a>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="bg-black/40 px-4 py-1.5 rounded-full border border-amber-500/50 flex items-center gap-2 shadow-lg">
                    <span class="text-amber-500 text-xs font-bold">رصيدك:</span>
                    <span class="text-xl font-black text-white leading-none">{{ auth()->user()->points ?? 0 }}</span>
                    <span class="text-amber-500 text-[10px] font-bold">نقطة</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto p-6">
        
        <header class="text-center py-10 flex flex-col items-center border-b border-gray-800 mb-10">
            <h1 class="text-4xl font-extrabold text-amber-500 mb-2 uppercase tracking-widest">توقعات اليوم</h1>
            <p class="text-gray-400 mb-6 font-medium">اختر فريقك المفضل واجمع النقاط لتحويلها لجوائز!</p>
            
            <a href="{{ url('/my-predictions') }}" class="inline-flex items-center bg-amber-500 hover:bg-amber-600 text-black px-8 py-2.5 rounded-full font-bold transition-all hover:scale-105 shadow-xl">
                📋 سجل توقعاتي
            </a>
        </header>

        @if(session('success'))
            <div class="bg-green-500/20 border-2 border-green-500 text-green-400 p-4 rounded-xl mb-8 text-center font-bold animate-bounce">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="grid gap-10">
            @forelse($games as $game)
            <div class="bg-gray-800/40 rounded-3xl p-10 border border-gray-700 shadow-2xl relative overflow-hidden group hover:border-amber-500/50 transition-all">
                
                <div class="flex justify-between items-center mb-8">
                    <span class="bg-amber-500 text-black text-[10px] font-black px-3 py-1 rounded-md uppercase">LIVE CHALLENGE</span>
                    <span class="text-gray-400 text-xs flex items-center gap-1">📅 {{ $game->game_time }}</span>
                </div>
                
                <div class="flex justify-around items-center relative z-10">
                    <div class="flex-1 text-center group/team">
                        <div class="text-4xl mb-4 transform transition-transform group-hover/team:scale-110">⚽</div>
                        <h2 class="text-2xl font-black mb-6">{{ $game->team_a }}</h2>
                        <form action="{{ url('/predict') }}" method="POST">
                            @csrf
                            <input type="hidden" name="game_id" value="{{ $game->id }}">
                            <input type="hidden" name="predicted_winner" value="{{ $game->team_a }}">
                            <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-black font-black py-3 rounded-xl transition shadow-lg active:scale-95">توقع الفوز</button>
                        </form>
                    </div>

                    <div class="px-6">
                        <span class="text-4xl font-black text-gray-700 italic opacity-50">VS</span>
                    </div>

                    <div class="flex-1 text-center group/team">
                        <div class="text-4xl mb-4 transform transition-transform group-hover/team:scale-110">⚽</div>
                        <h2 class="text-2xl font-black mb-6">{{ $game->team_b }}</h2>
                        <form action="{{ url('/predict') }}" method="POST">
                            @csrf
                            <input type="hidden" name="game_id" value="{{ $game->id }}">
                            <input type="hidden" name="predicted_winner" value="{{ $game->team_b }}">
                            <button type="submit" class="w-full bg-gray-700 hover:bg-gray-600 text-white font-black py-3 rounded-xl transition shadow-lg active:scale-95">توقع الفوز</button>
                        </form>
                    </div>
                </div>
                
                <div class="mt-8 pt-6 border-t border-gray-700/50 text-center">
                    <p class="text-gray-400 text-sm">جائزة التوقع الصحيح</p>
                    <span class="text-2xl font-black text-amber-500">+{{ $game->points_win }} نقطة</span>
                </div>

                @if(auth()->id() == 1)
                <div class="mt-8 p-6 bg-black/40 rounded-2xl border-2 border-dashed border-amber-500/30">
                    <p class="text-xs text-amber-500 mb-4 text-center font-bold">🛠️ لوحة الإدارة: إنهاء المباراة</p>
                    <form action="{{ url('/settle-game') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                        @csrf
                        <input type="hidden" name="game_id" value="{{ $game->id }}">
                        
                        <select name="winner" required class="flex-1 bg-gray-900 border border-gray-700 text-white text-sm rounded-xl p-3 focus:ring-2 focus:ring-amber-500">
                            <option value="" disabled selected>من فاز في الواقع؟</option>
                            <option value="{{ $game->team_a }}">{{ $game->team_a }}</option>
                            <option value="{{ $game->team_b }}">{{ $game->team_b }}</option>
                        </select>
                        
                        <button type="submit" class="bg-green-600 hover:bg-green-500 text-white text-sm font-bold px-6 py-3 rounded-xl transition shadow-xl" onclick="return confirm('هل أنت متأكد؟ سيتم توزيع النقاط حالاً!')">
                            توزيع الجوائز 🏆
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @empty
            <div class="text-center py-20 bg-gray-800/20 rounded-3xl border-2 border-dashed border-gray-700">
                <p class="text-gray-500 text-xl font-medium">لا توجد تحديات نشطة حالياً. انتظرونا قريباً!</p>
            </div>
            @endforelse
        </div>
    </div>
</body>
</html>