<div>
    <div x-data="{ 'showModal': false }" @keydown.escape="showModal = false">
        <!-- Trigger for Modal -->
        <button type="button" @click="showModal = true" class="bg-gray-100 px-1 py-1 rounded-md hover:bg-gray-200">
            @include('icons::trash')
        </button>

        <!-- Modal -->
        <div class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
            x-show="showModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">
            <!-- Modal inner -->
            <div class="max-w-[24rem] w-full px-6 py-4 mx-auto text-left bg-white rounded-lg shadow-lg"
                @click.away="showModal = false">
                <!-- Title / Close-->
                <div class="flex items-center justify-between">
                    <h5 class="mr-3 text-black w-full font-bold text-center text-lg uppercase">{{ $title }}</h5>
                </div>

                <!-- content -->

                <hr class="w-full my-2">

                {{-- Content --}}
                <div class="p-2 w-full flex flex-col items-cente justify-center my-2">
                    <div class="p-2 w-full text-center text-base font-semibold">
                        {{ $message }}
                    </div>
                    <div class="flex space-x-4 justify-between items center">
                        <button wire:click="deleteData" class="text-base bg-blue-500 px-2 py-1 w-full text-center font-semibold uppercase rounded-md hover:bg-blue-400 text-white">
                            {{ $confirm_text }}
                        </button>
                        <button @click="showModal= false"
                        class="text-base bg-red-500 px-2 py-1 w-full text-center font-semibold uppercase rounded-md hover:bg-red-400 text-white">
                            {{ $cancel_text }}
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
