<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Commodity;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
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
    public function create(Commodity $commodity)
    {
        return view('comments.create', compact('commodity'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
        public function store(CommentRequest $request, Commodity $commodity)
    {
        $comment = new Comment($request->all());
        $comment->user_id = $request->user()->id;
        // トランザクション開始
        DB::beginTransaction();
        try {
            // 登録
            $commodity->comments()->save($comment);

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }
        //return redirectの場合、ビューに飛ばすのではなくて一旦ルーティングまで飛ばし、やり直しさせる
        return redirect()
            ->route('commodities.show', $commodity)
            ->with('notice', 'コメントを登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Commodity $commodity, Comment $comment)
    {
        return view('comments.edit', compact('commodity', 'comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
public function update(CommentRequest $request, Commodity $commodity, Comment $comment)
    {
        if ($request->user()->cannot('update', $comment)) {
            return redirect()->route('commodities.show', $commodity)
                ->withErrors('自分のコメント以外は更新できません');
        }

        $comment->fill($request->all());

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 更新
            $comment->save();

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }
        // dd($comment);
        return redirect()->route('commodities.show', $commodity)
            ->with('notice', 'コメントを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commodity $commodity, Comment $comment)
    {
        // トランザクション開始
        DB::beginTransaction();
        try {
            $comment->delete();

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('commodities.show', $commodity)
        ->with('notice', 'コメントを削除しました');
    }
}
