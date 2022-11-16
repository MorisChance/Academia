<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommodityRequest;
use App\Models\Commodity;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CommodityController extends Controller
{
    public function __construct()
    {
        return $this->authorizeResource(Commodity::class, 'commodity');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //indexアクションにRequestクラスの引数を追加
        $params = $request->query();
        //検索用のスコープ(scopeSearch)を追加するので、スコープにリクエストパラメーターを渡す,with([user, faculty])とすることによりN+1問題解決
        $commodities = Commodity::search($params)->with(['user', 'faculty'])->latest()->paginate(5);
        $commodities->appends($params);
        $faculties = Faculty::all();
        // return response()->json(compact('commodities', 'faculties'));
        return response()->json([$commodities, $faculties]);
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
        // $commodity->user_id = $request->user()->id;
        $commodity->user_id = $request->user_id;

        // fileメソッドの引数は、画像ファイル用のinputタグのname属性を指定でアップロードする画像の情報を受け取る
        $file = $request->file('image');

        // $file->getClientOriginalName()で画像ファイルの名前を受け取り、YYYYMMDDhhmmss_ファイル名のファイル名を求めてimage属性に代入する
        $commodity->image = date('YmdHis') . '_' . $file->getClientOriginalName();

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 登録
            $commodity->save();
            // Storage::putFileAs(保存先のパス, アップロードするファイル, アップロード後のファイル名)
            if (!Storage::putFileAs('images/commodities', $file, $commodity->image)) {
                // 例外を投げてロールバックさせる
                throw new \Exception('画像ファイルの保存に失敗しました。');
            }
            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
            logger($e->getMessage());
            return response(status: 500);
        }
        return response()->json($commodity, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Commodity $commodity)
    {
        $commodity->load('comments');
        return response()->json($commodity);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Commodity $commodity)
    {
        $faculties = Faculty::all();
        return view('commodities.edit', compact('faculties', 'commodity'));
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

        $file = $request->file('image');
        if ($file) {
            $delete_file_path = $commodity->image_path;
            $commodity->image = date('YmdHis') . '_' . $file->getClientOriginalName();
        }
        $commodity->fill($request->all());
        // トランザクション開始
        DB::beginTransaction();
        try {
            // 更新
            $commodity->save();
            if ($file) {
                // 画像アップロード
                if (!Storage::putFileAs('images/commodities', $file, $commodity->image)) {
                    // 例外を投げてロールバックさせる
                    throw new \Exception('画像ファイルの保存に失敗しました。');
                }              // 画像削除
                if (!Storage::delete($delete_file_path)) {
                    //アップロードした画像を削除する
                    Storage::delete($commodity->image_path);
                    //例外を投げてロールバックさせる
                    throw new \Exception('画像ファイルの削除に失敗しました。');
                }
            }
            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }
        return response()->json($commodity, 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commodity $commodity)
    {

        // トランザクション開始
        DB::beginTransaction();
        try {
            $commodity->delete();

            // 画像削除
            if (!Storage::delete($commodity->image_path)) {
                // 例外を投げてロールバックさせる
                throw new \Exception('画像ファイルの削除に失敗しました。');
            }

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return response()->json($commodity, 204);
    }
}
