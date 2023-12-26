@props([
    'question'
])

<div class="
    rounded dark:bg-gray-800/50 shadow shadow-blue-500/50 p-3
    dark:text-gray-400 flex justify-between items-center
">
    <span>{{ $question->question }}</span>
    <div>
        <x-form :action="route('question.like', $question)">
            <button class="flex items-start space-x-2 text-green-500">
                <x-icons.thumbs-up class="w-5 h-5 hover:text-green-300 cursor-pointer" id="thumbs-up"/>
                {{-- propriedade computada, acessada na App\Models\Question --}}
                <span>{{ $question->likes }}</span>
            </button>
        </x-form>

        <x-form :action="route('question.like', $question)">
            <button class="flex items-start space-x-2 text-red-500">
                <x-icons.thumbs-down class="w-5 h-5 hover:text-red-300 cursor-pointer" id="thumbs-up"/>
                {{-- propriedade computada, acessada na App\Models\Question --}}
                <span>{{ $question->unlikes }}</span>
            </button>
        </x-form>
    </div>

</div>
