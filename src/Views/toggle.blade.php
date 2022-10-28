<div class="mx-2">
    <div class="w-full text-sm " x-data="{ open: false }" @click.away="open = false">
        <button
            class="p-2.5 w-full flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-gray-800 hover:text-white "
            @click="open = !open">
            <div class="flex justify-between w-full items-center">
                @include('icons::eye')
                <span class="text-[15px] ml-2  font-bold">Mostrar</span>
                <span class="text-sm ml-2" :class="open ? 'rotate-0' : 'rotate-180'" id="arrow">
                   @include('icons::chevron-down')
                </span>
            </div>
        </button>
        <div class="text-left text-sm mt-2 px-3 py-2  bg-white text-black rounded-md w-full mx-auto absolute font-bold flex flex-col space-y-2"
            x-show="open" x-transition>
            @foreach ($hideables as $hideable)
                <button wire:click="toggleHide('{{ $hideable['alias'] }}')" @click="open = false"
                    class="flex space-x-2 items-center {{ $hideable['status'] ? 'text-gray-300 line-through' : '' }}">
                    @if ($hideable['status'])
                        @include('icons::eye-slash')
                    @else
                        @include('icons::eye')
                    @endif
                    <span class="">{{ $hideable['label'] }}</span>
                </button>
            @endforeach
        </div>
    </div>

</div>
