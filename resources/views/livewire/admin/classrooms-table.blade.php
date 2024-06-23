
@php
       $statusOption = app('my_constants')['STATUS_OPTIONS'][app()->getLocale()];
@endphp
<div class="table__container"
x-on:update-classrooms-table.window="$wire.$refresh()"
>

<div class="table__header">
    <h3>@lang('tables.classrooms.info')</h3>
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
            :label="__('tables.classrooms.name')"
            type="text"
            html_id="tName"
            role="filter"/>
            <x-form.input
            name="capacity"
            :label="__('modals.classroom.capacity')"
            type="text"
            html_id="tcapacity"
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

    @if(isset($this->classrooms) && $this->classrooms->isNotEmpty())


    <div class="table__body">
    <table>
        <thead>
            <tr>

        @if (app()->getLocale() === 'ar')

        <x-table.sortable-th
        wire:key="crT-TH-1"
        name="name_ar"
        :label="__('modals.classroom.nameAr')"
        :$sortDirection :$sortBy/>
        @else
        <x-table.sortable-th
        wire:key="crT-TH-1"
        name="name_fr"
        :label="__('modals.classroom.nameFr')"
        :$sortDirection :$sortBy/>
       @endif

       <x-table.sortable-th
       wire:key="crT-TH"
       name="status"
       :label="__('tables.classrooms.status')"
       :$sortDirection :$sortBy/>

       <x-table.sortable-th
       wire:key="crT-TH-12"
       name="capacity"
       :label="__('modals.classroom.capacity')"
       :$sortDirection :$sortBy/>
           <x-table.sortable-th
           wire:key="crT-TH-3"
           name="latitude"
           :label="__('modals.classroom.latitude')"
           :$sortDirection :$sortBy/>
           <x-table.sortable-th
           wire:key="crT-TH-4"
           name="longitude"
           :label="__('modals.classroom.longitude')"
           :$sortDirection :$sortBy/>
           <x-table.sortable-th
           wire:key="crT-TH-9"
           name="open_time"
           :label="__('modals.classroom.openTime')"
           :$sortDirection :$sortBy/>
           <x-table.sortable-th
           wire:key="crT-TH-10"
           name="close_time"
           :label="__('modals.classroom.closeTime')"
           :$sortDirection :$sortBy/>
           <x-table.sortable-th
           wire:key="crT-TH-5"
           name="price_per_hour"
           :label="__('modals.classroom.pricePerHour')"
           :$sortDirection :$sortBy/>
           <x-table.sortable-th
           wire:key="crT-TH-6"
           name="price_per_day"
           :label="__('modals.classroom.pricePerDay')"
           :$sortDirection :$sortBy/>
           <x-table.sortable-th
           wire:key="crT-TH-7"
           name="price_per_week"
           :label="__('modals.classroom.pricePerWeek')"
           :$sortDirection :$sortBy/>
           <x-table.sortable-th
           wire:key="crT-TH-8"
           name="price_per_month"
           :label="__('modals.classroom.pricePerMonth')"
           :$sortDirection :$sortBy/>

           <x-table.sortable-th wire:key="crt-TH-11"
           name="created_at"
           :label="__('tables.classroom.createdAt')"
            :$sortDirection
            :$sortBy/>

             <th scope="column"><div>@lang('tables.common.actions')</div></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($this->classrooms as $cl)
            @php
            $name = app()->getLocale() === 'ar' ? $cl->name_ar : $cl->name_fr;
           @endphp

                <tr wire:key="{{ $cl->id }}">
                    <td scope="row">{{ $name }}</td>
                    {{-- <td  >{{ app('my_constants')['STATUS_OPTIONS'][app()->getLocale()][$cl->status] }}</td> --}}
                    <td><livewire:table-selector
                        wire:key="st-P-{{ $cl->id }}"
                        :data="$statusOption"
                        :selectedValue="$cl->status"
                        :entity="$cl"
                      lazy
                      /></td>
                    <td >{{ $cl->capacity }}</td>
                    <td >{{ $cl->latitude }}</td>
                    <td >{{ $cl->longitude }}</td>
                    <td >{{ $cl->open_time }}</td>
                    <td >{{ $cl->close_time }}</td>
                    <td >{{ $cl->price_per_hour }}</td>
                    <td >{{ $cl->price_per_day }}</td>
                    <td >{{ $cl->price_per_week }}</td>
                    <td >{{ $cl->price_per_month }}</td>
                    <td >{{ $cl->created_at->format('Y-m-d')}}</td>
                    <td>
                        <livewire:open-dialog-button wire:key="'p-d-e-'.{{ $cl->id }}" classes="rounded"
                            content="<i class='fa-solid fa-trash'></i>"
                            :toolTipMessage="__('toolTips.classroom.delete')"
                            :data='[
                                     "question" => "dialogs.title.classroom",
                                     "details" =>["classroom",$name],
                                     "actionEvent"=>[
                                                     "event"=>"delete-classroom",
                                                     "parameters"=>$cl
                                                     ]
                                     ]'
                             />
                        <livewire:open-modal-button
                        wire:key="p-p-m-{{ $cl->id }}"
                        classes="rounded"
                         :toolTipMessage="__('toolTips.classroom.update')"
                            content="<i class='fa-solid fa-pen-to-square'></i>"
                            :data='[
                                  "title" => "modals.classroom.for.update",
                                  "component" => [
                                                 "name" => "admin.classroom-modal",
                                                 "parameters" => ["id" => $cl->id]
                                                 ],
                                    "containsTinyMce"=>true
                                    ]'
                        />
                        <x-table.link
                        :toolTipMessage="__('toolTips.classroom.dayOff')"
                        route="dayoff"
                        parameter="{{ $cl->id}}"
                        icon="dayoff" />
                        <x-table.link
                        route="classroom"
                        :toolTipMessage="__('toolTips.classroom.view')"
                         parameter="{{ $cl->id}}"
                          icon="view" />
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    </div>
    {{ $this->classrooms->links('components.pagination') }}
    @else
    <div class="table__footer">
    <h2>
        @lang('tables.classrooms.not-found')
    </h2>
    </div>
   @endif

</div>


