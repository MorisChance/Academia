<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">

        <x-flash-message :message="session('notice')" />
        <x-validation-errors :errors="$errors" />
        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                {{ $commodity->title }}</h2>
            {{-- commmodityモデルにpublic function user()を定義しているため、リレーションを使用して$commodity->user->nameで表示する --}}
            <h3>{{ $commodity->user->name }}</h3>
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span
                    class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $commodity->created_at ? 'NEW' : '' }}</span>
                {{ $commodity->created_at }}
            </p>
            {{-- 照会画面もimage_urlメソッドを使用するように修正します。 --}}
            <img src="{{ $commodity->image_url }}" alt="" class="mb-4">
            
            {{-- ブラウザ上で改行したいので、nl2br()で改行(\n)を<br>に置き換える<br>がエスケープされないように、{!! !!}で、エスケープを無効にする --}}
            <h3 class="text-gray-700 text-base">{!! nl2br(e($commodity->description)) !!}</h3>
            <h3 class="text-gray-700 text-base">{!! nl2br(e($commodity->price)) !!}円</h3>
        </article>
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
</x-app-layout>
