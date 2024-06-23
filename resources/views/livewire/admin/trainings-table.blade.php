
@php
       $statusOption = app('my_constants')['STATUS_OPTIONS'][app()->getLocale()];
@endphp
<div class="table__container"
x-on:update-trainings-table.window="$wire.$refresh()"
>
<div class="table__header">
    <h3>@lang('tables.trainings.info')</h3>
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
            name="name"
            :label="__('tables.trainings.name')"
            type="text"
            html_id="trName"
            role="filter"/>
            <x-form.input
            name="capactity"
            :label="__('modals.training.capacity')"
            type="text"
            html_id="trCapacity"
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

    @if(isset($this->trainings) && $this->trainings->isNotEmpty())


    <div class="table__body">
    <table>
        <thead>
            <tr>

        @if (app()->getLocale() === 'ar')

        <x-table.sortable-th
        wire:key="trT-TH-1"
        name="name_ar"
        :label="__('modals.training.nameAr')"
        :$sortDirection :$sortBy/>
        @else
        <x-table.sortable-th
        wire:key="trT-TH-2"
        name="name_fr"
        :label="__('modals.training.nameFr')"
        :$sortDirection :$sortBy/>
       @endif
       <x-table.sortable-th
       wire:key="trT-TH-5"
       name="status"
       :label="__('tables.trainings.status')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="trT-TH-3"
       name="capacity"
       :label="__('modals.training.capacity')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="trT-TH-9"
       name="price_per_session"
       :label="__('modals.training.pricePerSession')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="trT-TH-10"
       name="price_total"
       :label="__('modals.training.priceTotal')"
       :$sortDirection :$sortBy/>

       <x-table.sortable-th wire:key="crt-TH-7"
       name="start_at"
       :label="__('modals.training.start_at')"
        :$sortDirection
        :$sortBy/>
       <x-table.sortable-th wire:key="crt-TH-8"
       name="end_at"
       :label="__('modals.training.end_at')"
        :$sortDirection
        :$sortBy/>
           <x-table.sortable-th wire:key="crt-TH-6"
           name="created_at"
           :label="__('tables.trainings.createdAt')"
            :$sortDirection
            :$sortBy/>

             <th scope="column"><div>@lang('tables.common.actions')</div></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($this->trainings as $tr)
            @php
            $name = app()->getLocale() === 'ar' ? $tr->name_ar : $tr->name_fr;
           @endphp

                <tr wire:key="{{ $tr->id }}-pr">
                    <td scope="row">{{ $name }}</td>
                    <td  >

                        <livewire:table-selector
                        wire:key="st-P-{{ $tr->id }}"
                        :data="$statusOption"
                        :selectedValue="$tr->status"
                        :entity="$tr"
                      lazy
                      />

                        {{-- {{ app('my_constants')['STATUS_OPTIONS'][app()->getLocale()][$tr->status] }} --}}
                    </td>
                    <td >{{ $tr->capacity}}</td>
                    <td >{{ $tr->price_per_session}}</td>
                    <td >{{ $tr->price_total}}</td>
                    <td >{{ $tr->start_at}}</td>
                    <td >{{ $tr->end_at}}</td>
                    <td >{{ $tr->created_at->format('Y-m-d')}}</td>
                    <td>
                        <livewire:open-dialog-button wire:key="'trT-d-e-'.{{ $tr->id }}" classes="rounded"
                            content="<i class='fa-solid fa-trash'></i>"
                              :toolTipMessage="__('toolTips.training.delete')"
                            :data='[
                                     "question" => "dialogs.title.training",
                                     "details" =>["training",$name],
                                     "actionEvent"=>[
                                                     "event"=>"delete-training",
                                                     "parameters"=>$tr
                                                     ]
                                     ]'
                             />
                        <livewire:open-modal-button  wire:key="trt-m-{{ $tr->id }}" classes="rounded"
                            content="<i class='fa-solid fa-pen-to-square'></i>"
                                 :toolTipMessage="__('toolTips.training.update')"
                            :data='[
                                  "title" => "modals.training.for.update",
                                  "component" => [
                                                 "name" => "admin.training-modal",
                                                 "parameters" => ["id" => $tr->id]
                                                 ],
                                    "containsTinyMce"=>true
                                    ]'
                        />
                        <x-table.link route="training"
                             :toolTipMessage="__('toolTips.training.view')"
                        parameter="{{ $tr->id}}" icon="view" />
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    </div>
    {{ $this->trainings->links('components.pagination') }}
    @else
    <div class="table__footer">
    <h2>
        @lang('tables.trainings.not-found')
    </h2>
    </div>
   @endif

</div>

