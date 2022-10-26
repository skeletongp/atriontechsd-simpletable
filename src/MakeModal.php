<?php
namespace Atriontechsd\SimpleTable;
class MakeModal{
    public function createModal($name){
        
        //base path is livewire base path
        $path = 'app/Http/Livewire';

        //if name has slash, subdir is substring before last slash, else subdir is null
        $subdir = strpos($name, '/') ? substr($name, 0, strrpos($name, '/')) : null;
        //component is substring after last slash
        $component = substr($name, strrpos($name, '/'));
        $component=strtolower($component);
        //if subdir is not null, component is subdir.component
        if ($subdir) {
            $component = $subdir . '.' . $component;
            $namespace="App\Http\Livewire\\".$subdir;
        }
        else{
            $namespace="App\Http\Livewire";
        }
        
        //if component exists, return false
        if (file_exists(base_path($path . '/' . ucfirst($component) . 'Component.php'))) {
            return    $component . '-component';;
        }

        //create file ucfiirst(component).php
        $file = fopen(base_path($path . '/' . ucfirst($component) . 'Component.php'), 'w');
        
        //content is string of class for livewire component
        $content = '<?php
        namespace '.$namespace.';

        use Livewire\Component;

        class ' . ucfirst($component) . 'Component extends Component{
            public $data;
            public function render(){
                return view(\'livewire.' . $component . '-component\');
            }
        }';
        //write content to file
        fwrite($file, $content);

        //create file view name $component
        $file = fopen(base_path('resources/views/livewire/' . $component . '-component.blade.php'), 'w');
        //content is string of view for livewire component
        $content = '<div>
            <h1>Modal</h1>
            <p>Modal content</p>
        </div>';
        //write content to file
        fwrite($file, $content);
        return  $component . '-component';
    }
}