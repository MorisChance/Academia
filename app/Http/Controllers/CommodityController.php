<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommodityRequest;
use App\Models\Commodity;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CommodityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faculties = Faculty::all();
        return view('commodities.create', compact('faculties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommodityRequest $request)
    {
        //$request->all()でtitle,faculty_id,description,priceを受け取る
        $commodity = new Commodity($request->all());

        // $request->user()->idでログインユーザーのIDを取得してuser_id属性に代入する
        $commodity->user_id = $request->user()->id;
        // fileメソッドの引数は、画像ファイル用のinputタグのname属性を指定でアップロードする画像の情報を受け取る
        $file = $request->file('image');
        // $file->getClientOriginalName()で画像ファイルの名前を受け取り、YYYYMMDDhhmmss_ファイル名のファイル名を求めてimage属性に代入する
        $commodity->image = date('YmdHis') . '_' . $file->getClientOriginalName();
        // トランザクション開始
        DB::beginTransaction();
        try {
            // 登録
            $commodity->save();
            // 画像アップロード
            if (!Storage::putFileAs('images/commdities', $file, $commodity->image)) {
                // 例外を投げてロールバックさせる
                throw new \Exception('画像ファイルの保存に失敗しました。');
            }
            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }
        $commodity->image = date('YmdHis') . '_' . $file->getClientOriginalName();
        return redirect()->route('commodities.show', $commodity);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Commodity $commodity)
    {
    return view('commodities.show', compact('commodity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Commodity $commodity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commodity $commodity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commodity $commodity)
    {
        //
    }
}
