@props(['name','label','sortBy','sortDirection', 'sortBy'])

<th {{ $attributes }} scope="column" wire:click="setSortBy('{{ $name }}')" scope="col"><div>
    {{ $label }}
    @if($sortBy !== $name)
    <i class="fa-solid fa-sort"></i>
    @elseif ($sortDirection ==="ASC")
    <i class="fa-solid fa-sort-up"></i>
    @else
    <i class="fa-solid fa-sort-down"></i>
    @endif
</div>
</th>
