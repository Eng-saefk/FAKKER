<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متجر الجوائز - فكر معنا</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: radial-gradient(circle, #1a202c 0%, #0d1117 100%); }
    </style>
</head>
<body class="text-white font-sans min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <header class="text-center py-10">
            <h1 class="text-4xl font-extrabold text-amber-500 mb-2">🎁 متجر الجوائز</h1>
            <p class="text-gray-400">استبدل نقاطك بهدايا حقيقية</p>
            <div class="mt-4 inline-block bg-amber-500 text-black px-6 py-2 rounded-full font-bold shadow-lg">
                رصيدك الحالي: {{ auth()->user()->points ?? 0 }} نقطة
            </div>
        </header>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-8 text-center font-bold shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded-lg mb-8 text-center font-bold shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10">
            @forelse($products as $product)
                <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl p-6 border border-gray-700 shadow-2xl hover:border-amber-500 transition-all text-center group">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform">🎁</div>
                    <h2 class="text-xl font-bold mb-2">{{ $product->name }}</h2>
                    <p class="text-amber-500 font-black text-2xl mb-6">{{ $product->points_cost }} <span class="text-sm">نقطة</span></p>
                    
                    <form action="{{ url('/buy-product/'.$product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-black font-bold py-3 rounded-xl transition shadow-md active:scale-95">
                            استبدال النقاط ✅
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-gray-800/30 rounded-2xl border border-dashed border-gray-700">
                    <p class="text-gray-500">لا توجد جوائز متاحة حالياً في المتجر.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12 text-center">
            <a href="{{ url('/challenges') }}" class="text-gray-400 hover:text-amber-500 underline transition">⬅️ العودة للتحديات</a>
        </div>
    </div>
</body>
</html>