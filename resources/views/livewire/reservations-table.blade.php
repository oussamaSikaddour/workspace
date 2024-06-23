
@php
       $stateOptions = app('my_constants')['RESERVATION_STATE'][app()->getLocale()];
       $HoursOptions = app('my_constants')['HOURS'];
@endphp
<div class="table__container"
x-on:update-reservations-table.window="$wire.$refresh()"
>

<div class="table__header">
    <h3>@lang('tables.reservations.info')</h3>
   <div class="table__actions">
    @if($showForAdmin)

    <button class="button button--primary rounded hasToolTip"
    wire:click="generateReservationsExcel()">
    <span
    id="TT-ued"
    class="toolTip"
    role="tooltip"
    aria-label="{{__('toolTips.reservation.excel.donwload')}}"
  >
   @lang("toolTips.reservation.excel.download")
  </span>
        <i class="fa-solid fa-file-excel"></i>
    </button>
    @endif
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


        @if($showForAdmin)
            <x-form.input
            name="client"
            :label="__('tables.reservations.client')"
            type="text"
            html_id="tclient"
            role="filter"/>
        @endif
            <x-form.input
            name="classroom"
            :label="__('tables.reservations.classroom')"
            type="text"
            html_id="tclassroom"
            role="filter"/>

            <x-form.input
            name="dateStart"
           :label="__('tables.reservations.dateStart')"
            type="date"
           html_id="trDs"
           role="filter"
           :min="$minDateStart"
            />
           <x-form.input
           name="dateEnd"
           :label="__('tables.reservations.dateEnd')"
            type="date"
           html_id="trDe"
           role="filter"
           :min="$minDateEnd"
           />
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

    @if(isset($this->reservations) && $this->reservations->isNotEmpty())

    <div class="table__body">
      @if ($showForAdmin)


    <table>
        <thead>
            <tr>

        <x-table.sortable-th
                wire:key="trA-TH-3"
                name="name"
                :label="__('tables.reservations.client')"
                :$sortDirection :$sortBy/>
        @if (app()->getLocale() === 'ar')

        <x-table.sortable-th
        wire:key="trA-TH-1"
        name="name_ar"
        :label="__('tables.reservations.classroom')"
        :$sortDirection :$sortBy/>
        @else
        <x-table.sortable-th
        wire:key="trA-TH-2"
        name="name_fr"
        :label="__('tables.reservations.classroom')"
        :$sortDirection :$sortBy/>
       @endif
       <x-table.sortable-th
       wire:key="trA-TH-9"
       name="state"
       :label="__('tables.reservations.state')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="trA-TH-4"
       name="start_date"
       :label="__('modals.reservation.startDate')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="trA-TH-5"
       name="end_date"
       :label="__('modals.reservation.startDate')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="trA-TH-6"
       name="start_time"
       :label="__('modals.reservation.startTime')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="trA-TH-7"
       name="end_time"
       :label="__('modals.reservation.endTime')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="trA-TH-8"
       name="totalPrice"
       :label="__('tables.reservations.totalPrice')"
       :$sortDirection :$sortBy/>

        </tr>
        </thead>

        <tbody>
            @foreach ($this->reservations as $r)
            @php
            $classroom = app()->getLocale() === 'ar' ? $r->name_ar : $r->name_fr;
           @endphp

                <tr wire:key="{{ $r->id }}-pr">
                    <td scope="row">{{ $r->name }}</td>
                    <td >{{ $classroom }}</td>
                    <td  >
                        <livewire:table-selector
                        wire:key="st-P-{{ $r->id }}"
                        :data="$stateOptions"
                        :selectedValue="$r->state"
                        :entity="$r"
                      lazy
                      />
                    </td>
                    <td>
                        {{ $r->start_date }}
                    </td>
                    <td>
                        {{ $r->end_date }}
                    </td>
                    <td>
                        {{     $HoursOptions[$r->start_time]??'' }}
                    </td>
                    <td>
                        {{     $HoursOptions[$r->end_time]??''}}
                    </td>
                    <td>
                        {{  $r->total_price }}
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    @else
    <table>
        <thead>
            <tr>
        @if (app()->getLocale() === 'ar')

        <x-table.sortable-th
        wire:key="trU-TH-1"
        name="name_ar"
        :label="__('tables.reservations.classroom')"
        :$sortDirection :$sortBy/>
        @else
        <x-table.sortable-th
        wire:key="trU-TH-2"
        name="name_fr"
        :label="__('tables.reservations.classroom')"
        :$sortDirection :$sortBy/>
       @endif
       <x-table.sortable-th
       wire:key="trU-TH-4"
       name="start_date"
       :label="__('modals.reservation.startDate')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="trU-TH-5"
       name="end_date"
       :label="__('modals.reservation.startDate')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="trU-TH-6"
       name="start_time"
       :label="__('modals.reservation.startTime')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="trU-TH-7"
       name="end_time"
       :label="__('modals.reservation.endTime')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="trU-TH-8"
       name="totalPrice"
       :label="__('tables.reservations.totalPrice')"
       :$sortDirection :$sortBy/>

             <th scope="column"><div>@lang('tables.common.actions')</div></th>
        </tr>
        </thead>

        <tbody>
            @foreach ($this->reservations as $r)
            @php
            $classroom = app()->getLocale() === 'ar' ? $r->name_ar : $r->name_fr;

           @endphp

                <tr wire:key="{{ $r->id }}-pr">

                    <td >{{ $classroom }}</td>
                    <td>
                        {{ $this->parseDate($r->start_date) }}
                    </td>
                    <td>
                        {{ $this->parseDate($r->end_date)}}
                    </td>
                    <td>
                        {{     $HoursOptions[$r->start_time]??'' }}
                    </td>
                    <td>
                        {{     $HoursOptions[$r->end_time]??''}}
                    </td>
                    <td>
                        {{  $r->total_price }}
                    </td>
                    <td>
                        <livewire:open-dialog-button wire:key="'pr-d-e-'.{{ $r->id }}" classes="rounded"
                            content="<i class='fa-solid fa-trash'></i>"
                            :toolTipMessage="__('toolTips.reservation.delete')"
                            :data='[
                                     "question" => "dialogs.title.reservation",
                                     "details" =>["reservation",$r->created_at],
                                     "actionEvent"=>[
                                                     "event"=>"delete-reservation",
                                                     "parameters"=>$r
                                                     ]
                                     ]'
                             />

                             @if ($r->state==="valid")
                             <button class="button button--primary rounded hasToolTip"
                             wire:click="printConfirmationPdf({{ $r }})">
                             <span
                             id="rp-pdf-{{ $r->id }}"
                             class="toolTip"
                             role="tooltip"
                             aria-label="{{__('toolTips.reservation.pdf')}}"
                           >
                            @lang("toolTips.reservation.pdf")
                           </span>
                           <i class="fa-solid fa-file-pdf"></i>
                             </button>
                             @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    @endif

</div>
    {{ $this->reservations->links('components.pagination') }}
    @else
    <div class="table__footer">
    <h2>
        @lang('tables.reservations.not-found')
    </h2>
    </div>
   @endif

</div>

