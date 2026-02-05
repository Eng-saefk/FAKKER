<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>توقعاتي - فكر معنا</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans p-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold text-amber-500">📋 سجل توقعاتي</h1>
            <a href="{{ url('/challenges') }}" class="text-sm bg-gray-700 px-4 py-2 rounded-lg hover:bg-gray-600">العودة للمباريات</a>
        </div>

        <div class="space-y-4">
            @forelse($predictions as $prediction)
            <div class="bg-gray-800 p-6 rounded-xl border-l-4 {{ $prediction->is_correct === null ? 'border-amber-500' : ($prediction->is_correct ? 'border-green-500' : 'border-red-500') }}">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">{{ $prediction->game->game_time }}</p>
                        <h3 class="text-lg font-bold">{{ $prediction->game->team_a }} vs {{ $prediction->game->team_b }}</h3>
                        <p class="mt-2">توقعك: <span class="text-amber-500 font-bold">{{ $prediction->predicted_winner }}</span></p>
                    </div>
                    <div class="text-left">
                        @if($prediction->is_correct === null)
                            <span class="bg-amber-500/10 text-amber-500 px-3 py-1 rounded-full text-xs">قيد الانتظار</span>
                        @elseif($prediction->is_correct)
                            <span class="bg-green-500/10 text-green-500 px-3 py-1 rounded-full text-xs">توقع صحيح (+{{ $prediction->game->points_win }} نقطة)</span>
                        @else
                            <span class="bg-red-500/10 text-red-500 px-3 py-1 rounded-full text-xs">توقع خاطئ</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-10 bg-gray-800 rounded-xl">
                <p class="text-gray-500">لم تقم بأي توقعات بعد.</p>
            </div>
            @endforelse
        </div>
    </div>
</body>
</html>