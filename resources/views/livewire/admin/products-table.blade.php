
@php
       $statusOption = app('my_constants')['STATUS_OPTIONS'][app()->getLocale()];
@endphp
<div class="table__container"
x-on:update-products-table.window="$wire.$refresh()"
>

<div class="table__header">
    <h3>@lang('tables.products.info')</h3>
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
            :label="__('tables.products.name')"
            type="text"
            html_id="tName"
            role="filter"/>
            <x-form.input
            name="quantity"
            :label="__('modals.product.quantity')"
            type="text"
            html_id="tQuantity"
            role="filter"/>
            <x-form.input
            name="price"
            :label="__('modals.product.price')"
            type="text"
            html_id="tPrice"
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

    @if(isset($this->products) && $this->products->isNotEmpty())


    <div class="table__body">
    <table>
        <thead>
            <tr>

        @if (app()->getLocale() === 'ar')

        <x-table.sortable-th
        wire:key="prT-TH-1"
        name="name_ar"
        :label="__('modals.product.nameAr')"
        :$sortDirection :$sortBy/>
        @else
        <x-table.sortable-th
        wire:key="prT-TH-2"
        name="name_fr"
        :label="__('modals.product.nameFr')"
        :$sortDirection :$sortBy/>
       @endif
       <x-table.sortable-th
       wire:key="prT-TH-3"
       name="quantity"
       :label="__('modals.product.quantity')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="prT-TH-4"
       name="price"
       :label="__('modals.product.price')"
       :$sortDirection :$sortBy/>
       <x-table.sortable-th
       wire:key="prT-TH-5"
       name="status"
       :label="__('tables.products.status')"
       :$sortDirection :$sortBy/>

           <x-table.sortable-th wire:key="crt-TH-6"
           name="created_at"
           :label="__('tables.products.createdAt')"
            :$sortDirection
            :$sortBy/>

             <th scope="column"><div>@lang('tables.common.actions')</div></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($this->products as $p)
            @php
            $name = app()->getLocale() === 'ar' ? $p->name_ar : $p->name_fr;
           @endphp

                <tr wire:key="{{ $p->id }}-pr">
                    <td scope="row">{{ $name }}</td>
                    <td >{{ $p->quantity }}</td>
                    <td >{{ $p->price }}</td>
                    <td  >

                        <livewire:table-selector
                        wire:key="st-P-{{ $p->id }}"
                        :data="$statusOption"
                        :selectedValue="$p->status"
                        :entity="$p"
                      lazy
                      />

                        {{-- {{ app('my_constants')['STATUS_OPTIONS'][app()->getLocale()][$p->status] }} --}}
                    </td>
                    <td >{{ $p->created_at->format('Y-m-d')}}</td>
                    <td>
                        <livewire:open-dialog-button wire:key="'pr-d-e-'.{{ $p->id }}" classes="rounded"
                            content="<i class='fa-solid fa-trash'></i>"
                            :toolTipMessage="__('toolTips.product.delete')"
                            :data='[
                                     "question" => "dialogs.title.product",
                                     "details" =>["product",$name],
                                     "actionEvent"=>[
                                                     "event"=>"delete-product",
                                                     "parameters"=>$p
                                                     ]
                                     ]'
                             />
                        <livewire:open-modal-button  wire:key="pr-m-{{ $p->id }}" classes="rounded"
                            content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.product.update')"
                            :data='[
                                  "title" => "modals.product.for.update",
                                  "component" => [
                                                 "name" => "admin.product-modal",
                                                 "parameters" => ["id" => $p->id]
                                                 ],
                                    "containsTinyMce"=>true
                                    ]'
                        />
                        <x-table.link route="product"
                                :toolTipMessage="__('toolTips.product.view')"
                        parameter="{{ $p->id}}" icon="view" />
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    </div>
    {{ $this->products->links('components.pagination') }}
    @else
    <div class="table__footer">
    <h2>
        @lang('tables.products.not-found')
    </h2>
    </div>
   @endif

</div>

