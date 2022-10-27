<?php

namespace Atriontechsd\SimpleTable;

class MakeModal
{
    public function createModal($name)
    {

        //base path is livewire base path
        $path = 'app/Http/Livewire';

        //if name has slash, subdir is substring before last slash, else subdir is null
        $subdir = strpos($name, '/') ? substr($name, 0, strrpos($name, '/')) : null;
        //component is substring after last slash
        $component = substr($name, strrpos($name, '/'));
        $component = strtolower($component);
        //if subdir is not null, component is subdir.component
        if ($subdir) {
            $component = $subdir . '.' . $component;
            $namespace = "App\Http\Livewire\\" . $subdir;
        } else {
            $namespace = "App\Http\Livewire";
        }

        //if component exists, return false
        if (file_exists(base_path($path . '/' . ucfirst($component) . 'ModalComponent.php'))) {
            return    $component . '-modal-component';;
        }

        //create file ucfiirst(component).php
        $file = fopen(base_path($path . '/' . ucfirst($component) . 'ModalComponent.php'), 'w');

        //content is string of class for livewire component
        $content = '<?php
        namespace ' . $namespace . ';

        use Livewire\Component;

        class ' . ucfirst($component) . 'ModalComponent extends Component{
            public $data;
            public function render(){
                return view(\'livewire.' . $component . '-modal-component\');
            }
        }';
        //write content to file
        fwrite($file, $content);

        //create file view name $component
        $file = fopen(base_path('resources/views/livewire/' . $component . '-modal-component.blade.php'), 'w');
        //content is string of view for livewire component
        $content =
            <<<'EOD'
            <div x-data="{ 'showModal': false }" @keydown.escape="showModal = false">
        <!-- Trigger for Modal -->
        <button type="button" @click="showModal = true"
            class="text-sm bg-gray-100 px-2 py-1 rounded-md hover:bg-gray-200">Open</button>
    
        <!-- Modal -->
        <div class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
            x-show="showModal"  x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">
            <!-- Modal inner -->
            <div class="max-w-xl w-full px-6 py-4 mx-auto text-left bg-white rounded shadow-lg" @click.away="showModal = false"
           >
                <!-- Title / Close-->
                <div class="flex items-center justify-between">
                    <h5 class="mr-3 text-black max-w-none">Title</h5>
    
                    <button type="button" class="z-50 cursor-pointer" @click="showModal = false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
    
                <!-- content -->
    
                <hr class="w-full my-2">
    
                {{-- Content --}}
                <div class="p-2 w-full my-2">
                    <p>This is the content</p>
                </div>
    
                <hr class="w-full my-2">
    
                {{-- Footer --}}
                <div class="flex justify-end space-x-4 w-full py-2 ">
                    <button @click="showModal = ! showModal"
                        class="px-2 py-1 text-sm bg-gray-100 rounded-md hover:bg-gray-200 font-semibold">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    EOD;


        //write content to file
        fwrite($file, $content);
        return  $component . '-modal-component';
    }
}
