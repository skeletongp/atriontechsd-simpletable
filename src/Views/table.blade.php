<div class="relative">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
    <div class="md:px-8 py-4 w-full" wire:key="{{ uniqid() }}">
        
        <div class="shadow overflow-hidden overflow-x-auto lg:w-max mx-auto rounded border-b border-gray-200">
            <div class="py-4 flex items-center justify-end" wire:ignore>
                <div
                    class="flex space-x-0 items-center px-2 bg-gray-200 rounded-md border-2 border-transparent overflow-hidden focus-within:border-blue-300">
                    <i class="bi bi-search"></i>
                    <input autofocus wire:model.debounce.300ms="search" id="{{ uniqid() }}" type="search"
                        class="px-3 py-2 bg-transparent outline-none focus:outline-none focus:ring-0">
                </div>
    
            </div>
            <table class="w-max mx-auto bg-white table-auto ">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        @foreach ($columns as $head)
                            <th wire:click="setOrder({{ $head->sortable }},'{{ $head->name }}')"
                                class=" text-left py-3 px-4 uppercase font-semibold text-sm table-cell space-x-4 items-center justify-between {{ $head->sortable ? 'cursor-pointer hover:text-blue-300' : '' }}">
                                <span>{{ $head->label }}</span>
                                @if ($orderBy == $head->name)
                                    @if ($orderDirection == 'asc')
                                        <span class="bi bi-caret-up-fill"></span>
                                    @else
                                        <span class="bi bi-caret-down-fill"></span>
                                    @endif
                                @endif
                            </th>
                        @endforeach

                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($data as $item)
                        <tr class="odd:bg-gray-200">
                            @foreach ($columns as $element)
                                <td
                                    class=" text-left py-2 px-3 whitespace-nowrap overflow-hidden overflow-ellipsis max-w-xs w-max">
                                    @switch($element->type)
                                        @case('string')
                                            @php
                                                $terms = explode(' ', $search);
                                                $value = $item->{$element->alias};
                                                foreach ($terms as $term) {
                                                    $value = str_replace($term, "<mark >{$term}</mark>", $value);
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

                                        @case('edit')
                                            @php
                                                $edit= new \Atriontechsd\SimpleTable\Components\Edit();
                                                $edit->setTable($element->table);
                                                $edit->setKeyName($element->key);
                                                $edit->setKeyValue($item->{$element->key});
                                                @endphp
                                        @break
                                    @endswitch
                                </td>
                            @endforeach
                        </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($columns) }}" class=" text-gray-500 py-2 px-3 text-center">
                                    {{ $emptyMessage }}
                                </td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>
                <div class="py-2 hidden lg:block">
                    {{ $data->onEachSide(1)->links() }}
                </div>
                <div class="py-2 w-full lg:hidden">
                    {{ $data->links('pagination::simple-tailwind') }}
                </div>
            </div>
        </div>
    </div>

    </div>
