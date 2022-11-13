<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commodity;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{

    public function create(Commodity $commodity)
    {
        return view('purchases.create', compact('commodity'));
    }

    public function store(Commodity $commodity, Request $request)
    {
        //Commodity $commodityには商品のデータが入っている。Request $requestにはクレジットや暗証番号などが入っている。
        // Purchasの中のfillableをとってくるために、$purchase = new Purchase($request->all())を作成する。
        $purchase = new Purchase($request->all());
        // $request->user()->idでログインユーザーのIDを取得してuser_id属性に代入する
        $purchase->user_id = $request->user()->id;
        $purchase->commodity_id = $commodity->id;
        // トランザクション開始
        DB::beginTransaction();
        try {
            // 登録
            $purchase->save();
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()
        //ルーティングの名前がcommodities.purchasesになっているから、コメントの場合は'commodities.comments',になっているものの
        //商品のshow画面の中に入れCommodityControllerに送りたいため、commodities.showとなっている！！！！！
        //全てはルーティングの名前によってわかれる。。
            ->route('commodities.purchases.show', [$commodity, $purchase])
            ->with('notice', '商品を購入しました');
    }

    public function show(Commodity $commodity, Purchase $purchase)
    {
    //storeアクションで$commodityと$purchaseを送っているので使わなくても受け取らなければならない。
        return view('purchases.show', compact('purchase'));
    }
}
