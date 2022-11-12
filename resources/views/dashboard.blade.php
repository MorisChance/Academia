<x-app-layout>
    {{ $commodities }}
    <div class="container mx-auto w-3/5 my-8 px-4 py-4">
        <div>
            @foreach ($commodities as $c)
                <div class="bg-white w-full px-10 py-8 hover:shadow-2xl transition duration-500">
                    <div class="mt-4">
                        <div class="flex justify-between text-sm items-center mb-4">
                            <div class="border border-gray-900 px-2 h-7 leading-7 rounded-full">{{ $c->faculty->name }}
                            </div>
                        </div>
                        <h2 class="text-lg text-gray-700 font-semibold">{{ $c->title }}
                        </h2>
                        <p class="mt-4 text-md text-gray-600">
                            {{ Str::limit($c->description, 50, '...') }}
                        </p>
                        <img src="{{ $c->image_url }}" alt="" class="mb-4">
                        {{-- ブラウザ上で改行したいので、nl2br()で改行(\n)を<br>に置き換える<br>がエスケープされないように、{!! !!}で、エスケープを無効にする --}}
                        <h3 class="text-gray-700 text-base">{!! nl2br(e($c->description)) !!}</h3>
                        <h3 class="text-gray-700 text-base">{!! nl2br(e($c->price)) !!}円</h3>
                        <div class="flex justify-end items-center">
                            <a href="{{ route('commodities.show', $c) }}"
                                class="flex justify-center bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 mt-4 px-5 py-3 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
                                詳細
                            </a>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
            <div class="block mt-3">
                {{ $commodities ?? ('')->links() }}
            </div>
        </div>
    </div>

</x-app-layout>
