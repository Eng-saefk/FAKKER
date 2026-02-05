<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>متصدري التوقعات - فكر معنا</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans p-6">
    <div class="max-w-2xl mx-auto">
        <header class="text-center mb-10">
            <h1 class="text-4xl font-black text-amber-500 mb-2">🔥 قائمة المتصدرين</h1>
            <p class="text-gray-400">أفضل 10 خبراء توقع في الموقع</p>
        </header>

        <div class="bg-gray-800 rounded-3xl overflow-hidden shadow-2xl border border-gray-700">
            <table class="w-full text-right">
                <thead class="bg-gray-700/50">
                    <tr>
                        <th class="p-4 text-amber-500">المركز</th>
                        <th class="p-4 text-amber-500">المستخدم</th>
                        <th class="p-4 text-amber-500 text-left">إجمالي النقاط</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topUsers as $index => $user)
                    <tr class="border-b border-gray-700 hover:bg-gray-700/30 transition">
                        <td class="p-4">
                            @if($index == 0) <span class="text-2xl">🥇</span> 
                            @elseif($index == 1) <span class="text-2xl">🥈</span>
                            @elseif($index == 2) <span class="text-2xl">🥉</span>
                            @else <span class="text-gray-500 font-bold px-2">{{ $index + 1 }}</span> @endif
                        </td>
                        <td class="p-4 font-bold">{{ $user->name }}</td>
                        <td class="p-4 text-left text-amber-500 font-black text-xl">{{ $user->points }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ url('/challenges') }}" class="text-gray-400 hover:text-amber-500">العودة للتحديات</a>
        </div>
    </div>
</body>
</html>