<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة تحدي جديد</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-10">
    <div class="max-w-lg mx-auto bg-gray-800 p-8 rounded-3xl shadow-2xl border border-gray-700">
        <h1 class="text-2xl font-black text-amber-500 mb-6 text-center">🆕 إضافة مباراة جديدة</h1>
        
        <form action="{{ url('/admin/store-game') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs text-gray-400 mb-1">الفريق الأول</label>
                <input type="text" name="team_a" placeholder="مثلاً: ريال مدريد" class="w-full bg-gray-700 p-3 rounded-xl border border-gray-600 focus:border-amber-500 outline-none">
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">الفريق الثاني</label>
                <input type="text" name="team_b" placeholder="مثلاً: برشلونة" class="w-full bg-gray-700 p-3 rounded-xl border border-gray-600 focus:border-amber-500 outline-none">
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">وقت المباراة</label>
                <input type="datetime-local" name="game_time" class="w-full bg-gray-700 p-3 rounded-xl border border-gray-600 focus:border-amber-500 outline-none text-white">
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">نقاط الجائزة</label>
                <input type="number" name="points_win" value="100" class="w-full bg-gray-700 p-3 rounded-xl border border-gray-600 focus:border-amber-500 outline-none">
            </div>
            
            <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-black font-black py-4 rounded-2xl shadow-lg transition-all">نشر المباراة الآن ✅</button>
        </form>
    </div>
</body>
</html>