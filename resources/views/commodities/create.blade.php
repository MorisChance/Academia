<x-app-layout>
    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-indigo-900 shadow-md rounded-md">
        <h2 class="text-center text-lg text-white font-bold pt-6 tracking-widest">商品登録</h2>

        <x-validation-errors :errors="$errors" />

        <form action="{{ route('commodities.store') }}" method="POST" enctype="multipart/form-data" class="rounded pt-3 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label class="block text-white mb-2" for="title">
                    タイトル
                </label>
                <input type="text" name="title"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('title') }}">
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2" for="faculty_id">
                    学部
                </label>
                <select name="faculty_id"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required>
                    <option disabled selected value="">選択してください</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}" @if ($faculty->id == old('faculty_id')) selected @endif>
                            {{ $faculty->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2" for="description">
                    商品説明
                </label>
                <textarea name="description" rows="10"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="詳細">{{ old('description') }}</textarea>
            </div>
            {{-- 値段を入れる欄 --}}
            <div class="mb-4">
                <label class="block text-white mb-2 " for="price">
                    値段
                </label>
                <input type="string" name="price" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-half py-2 px-3"
                required placeholder="値段" value="{{ old('price') }}">
            </div>
            {{-- 写真アップロード機能 --}}
            {{-- イメージは、commodityコントローラーで別に処理を書く --}}
            <div class="mb-4">
                <label class="block text-white mb-2" for="image">
                    商品の写真
                </label>
                <input type="file" name="image" class="border-gray-300">
            </div>
            <input type="submit" value="登録"
                class="w-full flex justify-center bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
        </form>
    </div>
</x-app-layout>
