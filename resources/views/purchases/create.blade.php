<x-app-layout>
    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-indigo-900 shadow-md rounded-md">
        <h2 class="text-center text-lg text-white font-bold pt-6 tracking-widest">決済フォーム</h2>

        <x-validation-errors :errors="$errors" />

        <form action="{{ route('commodities.purchases.store', $commodity) }}" method="POST" enctype="multipart/form-data"
            class="rounded pt-3 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label class="block text-white mb-2" for="title">
                    商品名
                </label>
                <input type="text" name="title"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="商品名" value="{{ old('title', $commodity->title) }}">
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2" for="credit">
                    クレジットカード番号入力
                </label>
                <input type="text" name="credit"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="クレジットカード番号" value="{{ old('credit') }}">
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2" for="security">
                    セキュリティー番号
                </label>
                
                <input type="text" name="security"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-half py-2 px-3"
                    required placeholder="セキュリティー番号" value="{{ old('security') }}">
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2 " for="price">
                    値段
                </label>
                <input type="string" name="price"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-half py-2 px-3"
                    required placeholder="値段" value="{{ old('price', $commodity->price) }}">
            </div>
            <input type="submit" value="決済"
                class="w-full flex justify-center bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
        </form>
    </div>
</x-app-layout>
