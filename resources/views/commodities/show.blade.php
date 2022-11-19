<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">

        <x-flash-message :message="session('notice')" />
        <x-validation-errors :errors="$errors" />
        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                タイトル:{{ $commodity->title }}</h2>
            {{-- commmodityモデルにpublic function user()を定義しているため、リレーションを使用して$commodity->user->nameで表示する --}}
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span
                    class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $commodity->created_at ? 'NEW' : '' }}</span>
                掲載日: {{ $commodity->created_at }}
            </p>
            {{-- 照会画面もimage_urlメソッドを使用するように修正します。 --}}
            <img src="{{ $commodity->image_url }}" alt="" class="mb-4">

            {{-- ブラウザ上で改行したいので、nl2br()で改行(\n)を<br>に置き換える<br>がエスケープされないように、{!! !!}で、エスケープを無効にする --}}
            <h3 class="text-gray-700 text-3xl text-base">商品の詳細: {!! nl2br(e($commodity->description)) !!}</h3>
            {{-- commmodityモデルにpublic function user()を定義しているため、リレーションを使用して$commodity->user->nameで表示する --}}
            <h3 class="text-gray-700 text-3xl text-base">出品者: {{ $commodity->user->name }}</h3>
            <h3 class="text-gray-700 text-3xl text-base">値段: {!! nl2br(e($commodity->price)) !!}円</h3>
        </article>
        {{-- ポリシーメッソドでは、showはviewで示す
            コントローラメソッド	ポリシー
            index	viewAny
            show	view
            create	create
            store	create   
            edit	update
            update	update
            destroy	delete --}}
        @can('view', $commodity)
            <div>
                <a href="{{ route('commodities.purchases.create', $commodity) }}"
                    class="relative inline-flex items-center px-12 py-3 overflow-hidden text-lg font-medium text-red-600 border-2 border-red-600 rounded-full hover:text-white group hover:bg-gray-50">
                    <span
                        class="absolute left-0 block w-full h-0 transition-all bg-red-600 opacity-100 group-hover:h-full top-1/2 group-hover:top-0 duration-400 ease"></span>
                    <span
                        class="absolute right-0 flex items-center justify-start w-10 h-10 duration-300 transform translate-x-full group-hover:translate-x-0 ease">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </span>
                    <span class="relative">購入</span>
                </a>
            </div>
        @endcan
        <div class="flex flex-col sm:flex-row items-center sm:justify-end text-center my-4">
            @can('update', $commodity)
                <a href="{{ route('commodities.edit', $commodity) }}"
                    class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32 sm:mr-2 mb-2 sm:mb-0">編集</a>
            @endcan
            @can('delete', $commodity)
                <form action="{{ route('commodities.destroy', $commodity) }}" method="post" class="w-full sm:w-32">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                        class="bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                </form>
            @endcan
        </div>
        @auth
            <hr class="my-4">
            <div class="flex justify-end">
                <a href="{{ route('commodities.comments.create', $commodity) }}"
                    class="bg-indigo-400 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline block">コメント登録</a>
            </div>
        @endauth
        <section class="font-sans break-normal text-gray-900 ">
            @foreach ($comments as $comment)
                <div class="my-2">
                    <span class="font-bold mr-3">{{ $comment->user->name }}</span>
                    <span class="text-sm">{{ $comment->created_at }}</span>
                    <p>{!! nl2br(e($comment->body)) !!}</p>
                    <div class="flex justify-end text-center">
                        @can('update', $comment)
                            <a href="{{ route('commodities.comments.edit', [$commodity, $comment]) }}"
                                class="text-sm bg-green-400 hover:bg-green-600 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
                        @endcan
                        @can('delete', $comment)
                            <form action="{{ route('commodities.comments.destroy', [$commodity, $comment]) }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                                    class="text-sm bg-red-400 hover:bg-red-600 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline w-20">
                            </form>
                        @endcan
                    </div>
                </div>
                <hr>
            @endforeach
        </section>
    </div>
</x-app-layout>
