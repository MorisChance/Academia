<x-app-layout>
    <div class="container mx-auto bg-slate-100 w-4/5 my-8 px-4 py-4">
        <div class="flex justify-between">
            <div class="w-1/5">
                <h3 class="mb-3 text-gray-400 text-sm">検索条件</h3>
                <ul>
                    <li class="mb-4">
                        {{-- /のルーティングに行く --}}
                        <a href="/"
                            class="hover:text-blue-500 {{ Request::get('faculty_id') ?: 'text-green-500 font-bold' }}">
                            全て
                        </a>
                    </li>
                    @foreach ($faculties as $f)
                        <li class="mb-4 ">
                            {{-- /がないとcomodities/commoditiesに行ってしまう --}}
                            <a href="/commodities/?faculty_id={{ $f->id }}"
                                class="hover:text-blue-500 {{ Request::get('faculty_id') == $f->id ? 'text-green-500 font-bold' : '' }}">
                                {{ $f->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="container max-w-7xl mx-auto px-4 md:px-12 pb-3 mt-3">
                <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-4">
                    @foreach ($commodities as $c)
                        <article class="px-4 md:w-1/2 text-xl text-gray-800 pb-8 leading-normal">
                            <div class="bg-white w-full px-10 py-8 hover:shadow-2xl transition duration-500">
                                <div class="mt-4">
                                    <div class="flex justify-between text-sm items-center mb-4">
                                        <div class="border border-gray-900 px-2 h-7 leading-7 rounded-full">
                                            {{ $c->faculty->name }}
                                        </div>
                                        <span class="font-normal ml-2">{{ $c->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h2 class="text-2xl text-gray-700 font-semibold">タイトル: {{ $c->title }}
                                    </h2>
                                    {{-- <p class="mt-4 text-md text-gray-600">
                                {{ Str::limit($c->description, 50, '...') }}
                            </p> --}}
                                    <img src="{{ $c->image_url }}" alt="" class="object-contain w-96 h-96 mb-4">
                                    <div class="flex justify-between items-center">
                                        <div class="mt-4 flex items-center space-x-4 py-6">
                                            <div class="text-5xl font-semibold">
                                                {{ $c->price }}円
                                            </div>
                                            {{-- <div class="text-sm font-semibold">
                                        {{ $c->user->name }}
                                        <span class="font-normal ml-2">{{ $c->created_at->diffForHumans() }}</span>
                                    </div> --}}
                                        </div>
                                        {{-- collectionに対しての空の判定は,issetではなくていsEmtyで後ろに持て来る。
                                リレーションで設定しているため、$c->purchasesで商品の購入に要素まで持ってこれる
                                以下は、商品の購入が空でなければ、SOLD OUT --}}
                                        @if (!$c->purchases->isEmpty())
                                            <div class="font-extrabold text-red-500 text-2xl">
                                                SOLD
                                            </div>
                                        @else
                                            <div>
                                                <a href="{{ route('commodities.show', $c) }}"
                                                    class="flex justify-center bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 mt-4 px-5 py-3 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
                                                    詳細
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </article>
                    @endforeach
                </div>
                {{-- 対象オブジェクト(表示するデータ)に対してlinks()メソッド , --}}
                <div class="block mt-3">
                    {{ $commodities->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
