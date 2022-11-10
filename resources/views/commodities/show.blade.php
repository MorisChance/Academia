<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">

        <x-flash-message :message="session('notice')" />
        <x-validation-errors :errors="$errors" />
        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">{{ $commodity->title }}</h2>
            {{-- commmodityモデルにpublic function user()を定義しているため、リレーションを使用して$commodity->user->nameで表示する --}}
            <h3>{{ $commodity->user->name }}</h3>
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $commodity->created_at ? 'NEW' : '' }}</span>
                {{ $commodity->created_at }}
            </p>
            <img src="{{ $commodity->image_url}}" alt="" class="mb-4">
            {{-- ブラウザ上で改行したいので、nl2br()で改行(\n)を<br>に置き換える<br>がエスケープされないように、{!! !!}で、エスケープを無効にする --}}
            <h3 class="text-gray-700 text-base">{!! nl2br(e($commodity->description)) !!}</h3>
            <h3 class="text-gray-700 text-base">{!! nl2br(e($commodity->price)) !!}円</h3>
        </article>
        <div class="flex flex-row text-center my-4">
            @can('update', $commodity)
                <a href="{{ route('commodities.edit', $commodity) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
            @endcan
            @can('delete', $commodity)
                <form action="{{ route('commodities.destroy', $commodity) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                </form>
            @endcan
        </div>
        {{-- @auth
            <hr class="my-4">

            <div class="flex justify-end">
                <a href="{{ route('commodities.comments.create', $post) }}" class="bg-indigo-400 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline block">コメント登録</a>
            </div>
        @endauth --}}
    </div>
</x-app-layout>
