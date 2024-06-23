
<div class="table__container"
x-on:update-messages-table.window="$wire.$refresh()"

>
    <div class="table__header">
         <h3>@lang('tables.messages.info')</h3>
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
                 :label="__('forms.message.name')"
                 type="text"
                 html_id="tM-n"
                 role="filter"/>
            <x-form.input
                 name="email"
                 :label="__('forms.message.email')"
                 type="email"
                 html_id="tM-email"
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
    @if(isset($this->messages) && $this->messages->isNotEmpty())



    <div class="table__body">
      <table>
          <thead>
             <tr>
             <x-table.sortable-th
                      wire:key="tm-TH-1"
                      name="name"
                      :label="__('forms.message.name')"
                      :$sortDirection :$sortBy/>
             <x-table.sortable-th
                      wire:key="tm-TH-2"
                      name="email"
                      :label="__('forms.message.email')"
                      :$sortDirection :$sortBy/>
             <x-table.sortable-th
                      wire:key="tm-TH-3"
                      name="created_at"
                      :label="__('tables.messages.createdAt')"
                      :$sortDirection :$sortBy/>



             <th scope="column"><div>@lang('tables.common.actions')</div></th>
             </tr>
          </thead>
          <tbody>




             @foreach ($this->messages as $m)
             <tr wire:key="m-t-{{ $m->id }}" scope="row">
             <td>{{ $m->name}}</td>
             <td>{{ $m->email}}</td>
             <td>{{ $m->created_at->format('Y-m-d')}}</td>
            <td>
            <livewire:open-dialog-button
                wire:key="'o-d-u-'.{{ $m->id }}"
                classes="rounded"
                content="<i class='fa-solid fa-trash'></i>"
                :toolTipMessage="__('toolTips.message.delete')"
                :data='[
                         "question" => "dialogs.title.message",
                         "details" =>["message", $m->name],
                         "actionEvent"=>[
                                         "event"=>"delete-message",
                                         "parameters"=>$m
                                         ]
                         ]'
                 />
           <livewire:open-modal-button
             wire:key="'o-b-u-'.{{ $m->id }}"
             classes="rounded"
              :toolTipMessage="__('toolTips.message.reply')"
            content="<i class='fa-solid fa-reply'></i>"
            :data='[
                    "title" => "modals.reply.for.reply",
                     "component" => [
                                     "name" => "admin.reply-modal",
                                     "parameters" => ["message"=>$m]
                                     ],
                    "containsTinyMce"=>true
                            ]'
             />

            </td>
         </tr>
       @endforeach

        </tbody>
    </table>
</div>
{{ $this->messages->links('components.pagination') }}
    @else
    <div class="table__footer">
        <h2>
            @lang('tables.messages.not-found')
        </h2>
    </div>
   @endif
</div>



