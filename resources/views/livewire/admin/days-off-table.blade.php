
<div class="table__container"
x-on:update-days-off-table.window="$wire.$refresh()"
>

<div class="table__header">
    <h3>@lang('tables.days-off.info')</h3>
   <div class="table__actions">
       <button class="button rounded table__filters__btn hasToolTip"
       id="filter" >
        <span
        id="TT-Mf"
        class="toolTip"
        role="tooltip"
        aria-label="manage Filters"
        aria-haspopup="true"
         aria-expanded="false"
         aria-controls="tableFilters"
         >
         @lang("toolTips.common.filters")
      </span>
      <i class="fa-solid fa-filter" ></i>
       </button>
       <x-form.selector
       htmlId="TU-upp"
       name="perPage"
       :label="__('tables.common.perPage')"
       :data="$perPageOpations"
       type="filter"
       />
   </div>
</div>
    <div class="table__filters" wire:ignore>
            <x-form.input
            name="dateStart"
            :label="__('modals.days-off.days-off-start')"
            type="date"
            html_id="tDO-ds"
            role="filter"/>
            <x-form.input
            name="dateEnd"
            :label="__('modals.days-off.days-off-end')"
            type="date"
            html_id="tDO-de"
            role="filter"/>
            <button
            class="button button--primary rounded table__filters__btn--reset hasToolTip"
             wire:click="resetFilters">

             <span
             id="trashToolTip3"
             class="toolTip"
             role="tooltip"
             aria-label="resest Filters"
           >
           @lang("toolTips.common.resetFilters")
           </span>
                <i class="fa-solid fa-arrows-rotate"></i>
            </button>
    </div>

    @if(isset($this->daysOff) && $this->daysOff->isNotEmpty())


    <div class="table__body">
    <table>
        <thead>
            <tr>
           <x-table.sortable-th wire:key="cdo-TH-1"
           name="days_off_start"
           :label="__('modals.days-off.days-off-start')"
            :$sortDirection
            :$sortBy/>
           <x-table.sortable-th wire:key="cdo-TH-2"
           name="days_off_end"
           :label="__('modals.days-off.days-off-end')"
            :$sortDirection
            :$sortBy/>

             <th scope="column"><div>@lang('tables.common.actions')</div></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($this->daysOff as $d)

                <tr wire:key="{{ $d->id }}-do">
                    <td scope="row">{{ $d->days_off_start }}</td>
                    <td >{{ $d->days_off_end }}</td>
                    <td>
                        <livewire:open-dialog-button wire:key="'p-d-e-'.{{ $d->id }}" classes="rounded"
                            content="<i class='fa-solid fa-trash'></i>"
                              :toolTipMessage="__('toolTips.dayOff.delete')"
                            :data='[
                                     "question" => "dialogs.title.days-off",
                                     "details" =>[
                                      "days-off",
                                       $d->days_off_start,
                                     ],
                                     "actionEvent"=>[
                                                     "event"=>"delete-days-off",
                                                     "parameters"=>$d
                                                     ]
                                     ]'
                             />
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    </div>
    {{ $this->daysOff->links('components.pagination') }}
    @else
    <div class="table__footer">
    <h2>
        @lang('tables.days-off.not-found')
    </h2>
    </div>
   @endif

</div>


