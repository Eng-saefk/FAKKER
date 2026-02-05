<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Prediction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // مهم جداً لاستخدام المتجر

class GameController extends Controller
{
    // عرض المباريات
    public function index()
    {
        $games = Game::where('status', 'upcoming')->orderBy('game_time', 'asc')->get();
        return view('challenges', compact('games'));
    }

    // حفظ التوقع
    public function storePrediction(Request $request)
    {
        Prediction::create([
            'user_id' => auth()->id() ?? 1,
            'game_id' => $request->game_id,
            'predicted_winner' => $request->predicted_winner,
        ]);
        return back()->with('success', 'تم تسجيل توقعك! بانتظار النتيجة...');
    }

    // عرض صفحة إضافة مباراة (حل الخطأ في صورة image_1f026a)
    public function createGame()
    {
        return view('admin.create-game');
    }

    // حفظ المباراة (حل الخطأ في صورة image_1f0668)
    public function storeGame(Request $request)
    {
        Game::create([
            'team_a' => $request->team_a,
            'team_b' => $request->team_b,
            'game_time' => $request->game_time,
            'points_win' => $request->points_win,
            'status' => 'upcoming',
        ]);
        return redirect('/challenges')->with('success', 'تم إضافة المباراة بنجاح! 🔥');
    }

    // عرض المتجر (حل الخطأ في صورة image_1f6f80)
    public function shop()
    {
        $products = DB::table('products')->get();
        return view('shop', compact('products'));
    }

    // معالجة شراء جائزة
    public function buyProduct($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $user = auth()->user();

        if ($user && $user->points >= $product->points_cost) {
            User::where('id', $user->id)->decrement('points', $product->points_cost);
            return back()->with('success', 'تم طلب الجائزة بنجاح! سيتم التواصل معك قريباً 🎁');
        }

        return back()->with('error', 'نقاطك غير كافية لهذه الجائزة ❌');
    }

    // حسم المباراة وتوزيع النقاط
    public function settleGame(Request $request)
    {
        $gameId = $request->game_id;
        $winner = $request->winner;

        $predictions = Prediction::where('game_id', $gameId)->whereNull('is_correct')->get();

        foreach ($predictions as $prediction) {
            if ($prediction->predicted_winner == $winner) {
                $prediction->update(['is_correct' => true]);
                $user = User::find($prediction->user_id);
                if ($user) { $user->increment('points', $prediction->game->points_win); }
            } else {
                $prediction->update(['is_correct' => false]);
            }
        }

        Game::where('id', $gameId)->update(['status' => 'finished']);
        return back()->with('success', 'تم حسم المباراة وتوزيع النقاط! 🏆');
    }

    public function leaderboard()
    {
        $topUsers = User::orderBy('points', 'desc')->take(10)->get();
        return view('leaderboard', compact('topUsers'));
    }
}