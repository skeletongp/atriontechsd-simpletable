<div class="relative w-max max-w-full mx-auto max-h-[92vh]" wire:key="{{ uniqid() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
    <div class="md:px-8 py-4 mx-auto  relative">
        @include('simpletable::loading')
        <div class="shadow px-4 mx-auto  rounded border-b border-gray-200">
            <table
                class="  bg-white  border border-gray-300 block {{ $expanded ? '' : 'max-h-[75vh]' }} overflow-y-scroll ">
                <thead class="bg-gray-800 sticky  top-0 text-white w-max mx-auto">
                    <tr>
                        <td colspan="{{ count($columns) }}">
                            <div
                                class="{{ $titleClass }} min-w-full text-left p-2 text-sm lg:text-2xl font-bold flex justify-between items-center space-x-4">
                                <div class="w-max  mx-auto">
                                    {{ $title }}
                                </div>
                                <div class="w-max mx-auto flex space-x-0 w-max mx-auto justify-end  max-w-xs">
                                    <form wire:submit.prevent="builder"
                                        class="flex space-x-0 w-max mx-auto justify-end  max-w-xs items-center px-2 bg-gray-200 rounded-md border-2 border-transparent overflow-hidden focus-within:border-blue-300">
                                        @include('icons::search')
                                        <input autofocus wire:model.debounce.500ms="search" id="{{ uniqid() }}"
                                            type="search"
                                            placeholder=" Buscar {{ implode(', ', array_column($searcheables, 'label')) }}"
                                            class="px-3 text-sm w-max mx-auto overflow-hidden overflow-ellipsis whitespace-nowrap py-2 bg-transparent outline-none focus:outline-none focus:ring-0">
                                    </form>
                                </div>
                                @if ($hideable && count($hideables) > 0)
                                    @include('simpletable::toggle')
                                @endif
                            </div>

                        </td>
                    </tr>
                    <tr class="">
                        @foreach ($columns as $ind => $head)
                            @if (!$head->hidden)
                                <th wire:click="setOrder({{ $head->sortable }},'{{ $head->name }}')"
                                    class=" text-left py-3 px-4 uppercase font-semibold text-sm table-cell space-x-4 items-center justify-between select-none whitespace-nowrap {{ $head->sortable ? 'cursor-pointer hover:text-blue-300' : '' }}">
                                    <span class="select-none">{{ $head->label }}</span>
                                    @if ($orderBy == $head->name && $ind != 0 && $head->isColumn)
                                        @if ($orderDirection == 'asc')
                                            <span class="bi bi-caret-up-fill"></span>
                                        @else
                                            <span class="bi bi-caret-down-fill"></span>
                                        @endif
                                    @endif
                                </th>
                            @endif
                        @endforeach

                    </tr>
                </thead>
                <tbody class="text-gray-700 w-max mx-auto ">
                    @if (count($data))
                        @foreach ($data as $item)
                            <tr class="odd:bg-gray-100 {{ $rowClass }} ">
                                @foreach ($columns as $element)
                                    @if (!$element->hidden)
                                        <td
                                            class=" text-left first:text-center first:bg-gray-800 first:w-max first:text-white py-2 px-3  {{ $element->ellipsis ? 'whitespace-nowrap overflow-hidden overflow-ellipsis max-w-xs' : '' }}  {{ $columnClass }} {{ $element->cellClass }} ">
                                            @switch($element->type)
                                                @case('string')
                                                    @php
                                                        $terms = explode(' ', $search);
                                                        $value = $item->{$element->alias};
                                                        foreach ($terms as $term) {
                                                            if ($value !== 'mark') {
                                                                $value = str_replace($term, "<mark >{$term}</mark>", $value);
                                                            }
                                                        }
                                                    @endphp
                                                    {!! $value !!}
                                                @break

                                                @case('date')
                                                    {{ formatDate($item->{$element->alias}, $element->dateFormat) }}
                                                @break

                                                @case('money')
                                                    {{ $element->format . formatNumber($item->{$element->alias}) }}
                                                @break

                                                @case('number')
                                                    {{ formatNumber($item->{$element->alias}) }}
                                                @break

                                                @case('modal')
                                                    @livewire($element->component, ['data' => (array) $item], key(uniqid()))
                                                @break

                                                @case('delete')
                                                    @livewire(
                                                        'modal-delete',
                                                        [
                                                            'table_name' => $element->table ?: $this->setTable(),
                                                            'key_name' => $element->key_name,
                                                            'key_value' => $item->{$element->key_name},
                                                            'confirm_text' => $element->confirm_text,
                                                            'cancel_text' => $element->cancel_text,
                                                            'title' => $element->title,
                                                            'message' => $element->message,
                                                        ],
                                                    
                                                        key(uniqid()),
                                                    )
                                                @break
                                            @endswitch
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="{{ count($columns) }}" class="  text-gray-500 py-2 px-3 text-center">
                                {{ $emptyMessage }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="py-4 hidden stick bottom-0 mb-8 mx-auto lg:flex lg:justify-end lg:space-x-4 lg:items-center">
                <div class="border border-transparent border-r-gray-800 px-4">
                    <label class="flex space-x-2 items-center" for="perpage">
                        <span>Mostrar</span>
                        <select name="perpage" id="perpage" wire:model="perPage"
                            class="text-center appearance-none px-2 focus:outline-none border border-transparent focus:border-blue-300 rounded-md border-b-gray-800">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="500">500</option>
                        </select>
                        <span> de {{ $total }}</span>
                    </label>
                </div>
                @if ($data->hasPages())
                    <div class="border border-transparent border-r-gray-800 px-4">
                        <label class="flex space-x-2 items-center" for="page">
                            <span>Ir a la página</span>
                            @if ($lastPage > 20)
                                <input type="text" id="page"
                                    class="px-2 w-12 focus:outline-none border border-transparent focus:border-blue-300 text-center rounded-md border-b-gray-800"
                                    wire:model.debounce.100ms="page">
                            @else
                                <select name="page" id="page" wire:model="page"
                                    class="text-center appearance-none px-2 focus:outline-none border border-transparent focus:border-blue-300 rounded-md border-b-gray-800">
                                    @for ($i = 1; $i <= $lastPage; $i++)
                                        <option value="{{ $i }}">
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            @endif
                        </label>
                    </div>

                @endif

                @if ($perPage > 10)
                    <div class="form-check form-switch">
                        <input wire:model="expanded"
                            class="form-check-input appearance-none w-9 -ml-10 rounded-full float-left h-5 align-top bg-white bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm"
                            type="checkbox" role="switch" id="expansion">
                        <label class="form-check-label inline-block text-gray-800"
                            for="expansion">{{ $expanded ? 'Contraer' : 'Expandir' }}</label>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
