
@php
       $statusOption = app('my_constants')['STATUS_OPTIONS'][app()->getLocale()];
@endphp
<div class="table__container"
x-on:update-our-qualities-table.window="$wire.$refresh()"
>
<div class="table__header">
    <h3>@lang('tables.ourQualities.info')</h3>
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
            :label="__('tables.ourQualities.name')"
            type="text"
            html_id="tName"
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

    @if(isset($this->ourQualities) && $this->ourQualities->isNotEmpty())


    <div class="table__body">
    <table>
        <thead>
            <tr>

        @if (app()->getLocale() === 'ar')

        <x-table.sortable-th
        wire:key="oqT-TH-1"
        name="name_ar"
        :label="__('modals.ourQuality.nameAr')"
        :$sortDirection :$sortBy/>
        @else
        <x-table.sortable-th
        wire:key="oqT-TH-2"
        name="name_fr"
        :label="__('modals.ourQuality.nameFr')"
        :$sortDirection :$sortBy/>
       @endif
       <x-table.sortable-th
       wire:key="oqT-TH-5"
       name="status"
       :label="__('tables.ourQualities.status')"
       :$sortDirection :$sortBy/>

           <x-table.sortable-th wire:key="crt-TH-6"
           name="created_at"
           :label="__('tables.ourQualities.createdAt')"
            :$sortDirection
            :$sortBy/>

             <th scope="column"><div>@lang('tables.common.actions')</div></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($this->ourQualities as $oQ)
            @php
            $name = app()->getLocale() === 'ar' ? $oQ->name_ar : $oQ->name_fr;
           @endphp

                <tr wire:key="{{ $oQ->id }}-pr">
                    <td scope="row">{{ $name }}</td>
                    <td  >
                        <livewire:table-selector
                        wire:key="st-P-{{ $oQ->id }}"
                        :data="$statusOption"
                        :selectedValue="$oQ->status"
                        :entity="$oQ"
                      lazy
                      />

                        {{-- {{ app('my_constants')['STATUS_OPTIONS'][app()->getLocale()][$oQ->status] }} --}}
                    </td>
                    <td >{{ $oQ->created_at->format('Y-m-d')}}</td>
                    <td>
                        <livewire:open-dialog-button wire:key="'pr-d-e-'.{{ $oQ->id }}" classes="rounded"
                            content="<i class='fa-solid fa-trash'></i>"
                                :toolTipMessage="__('toolTips.ourQuality.delete')"
                            :data='[
                                     "question" => "dialogs.title.ourQuality",
                                     "details" =>["ourQuality",$name],
                                     "actionEvent"=>[
                                                     "event"=>"delete-ourQuality",
                                                     "parameters"=>$oQ
                                                     ]
                                     ]'
                             />
                        <livewire:open-modal-button  wire:key="pr-m-{{ $oQ->id }}" classes="rounded"
                            content="<i class='fa-solid fa-pen-to-square'></i>"
                                  :toolTipMessage="__('toolTips.ourQuality.update')"
                            :data='[
                                  "title" => "modals.ourQuality.for.update",
                                  "component" => [
                                                 "name" => "admin.our-quality-modal",
                                                 "parameters" => ["id" => $oQ->id]
                                                 ],
                                    ]'
                        />
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    </div>
    {{ $this->ourQualities->links('components.pagination') }}
    @else
    <div class="table__footer">
    <h2>
        @lang('tables.ourQualitys.not-found')
    </h2>
    </div>
   @endif

</div>

