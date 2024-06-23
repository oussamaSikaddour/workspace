
<div class="table__container"
x-on:update-users-table.window="$wire.$refresh()"

>
    <div class="table__header">
         <h3>@lang('tables.users.info')</h3>
        <div class="table__actions">
            <button class="button button--primary rounded hasToolTip"
            wire:click="generateUsersExcel()">
            <span
            id="TT-ued"
            class="toolTip"
            role="tooltip"
            aria-label="{{__('toolTips.user.excel.donwload')}}"
          >
           @lang("toolTips.user.excel.download")
          </span>
                <i class="fa-solid fa-file-excel"></i>
            </button>

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
                 name="fullName"
                 :label="__('tables.users.fullName')"
                 type="text"
                 html_id="fullNameUT"
                 role="filter"/>
            <x-form.input
                   name="email"
                  :label="__('tables.users.email')"
                   type="text"
                   html_id="usersEmailUT"
                   role="filter"/>


            @if(isset($filters) && is_array($filters) && count($filters) > 0)
            @foreach ($filters as $filter)
                    <x-form.selector
                     htmlId="{{ 'TU-'.$filter['name']}}"
                     :name="$filter['name']"
                     :label="$filter['label']"
                     :data="$filter['data']"
                     :toTranslate="$filter['toTranslate']"
                     type="filter"
                     />

            @endforeach
        @endif

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
    @if(isset($this->users) && $this->users->isNotEmpty())



    <div class="table__body">
      <table>
          <thead>
             <tr>
             <x-table.sortable-th
                      wire:key="U-TH-2"
                      name="name"
                      :label="__('tables.users.fullName')"
                      :$sortDirection :$sortBy/>
             <x-table.sortable-th
                       wire:key="U-TH-3"
                       name="email"
                       :label="__('tables.users.email')"
                        :$sortDirection :$sortBy/>
             <x-table.sortable-th
                       wire:key="U-TH-4"
                       name="created_at"
                       :label="__('tables.users.registration-date')"
                       :$sortDirection :$sortBy/>
             <x-table.sortable-th
                       wire:key="U-TH-4"
                        name="tel"
                        :label="__('tables.users.phone')"
                        :$sortDirection :$sortBy/>
             <x-table.sortable-th
                       wire:key="U-TH-5"
                        name="card_number"
                        :label="__('tables.users.card_number')"
                        :$sortDirection :$sortBy/>
             <x-table.sortable-th
                       wire:key="U-TH-6"
                        name="birth_date"
                        :label="__('tables.users.birth_date')"
                        :$sortDirection :$sortBy/>
             <x-table.sortable-th
                       wire:key="U-TH-6"
                        name="birth_place"
                        :label="__('tables.users.birth_place')"
                        :$sortDirection :$sortBy/>
             <x-table.sortable-th
                       wire:key="U-TH-7"
                        name="address"
                        :label="__('tables.users.address')"
                        :$sortDirection :$sortBy/>

             <th scope="column"><div>@lang('tables.common.actions')</div></th>
             </tr>
          </thead>
          <tbody>




             @foreach ($this->users as $u)
             <tr wire:key="{{ $u->id }}" scope="row">
             <td>{{ $u->name}}</td>
             <td>{{ $u->email}}</td>
             <td>{{ $u->created_at->format('d/m/Y')}}</td>
            <td>{{ $u->tel}}</td>
            <td>{{ $u->card_number}}</td>
            <td>{{ $u->birth_date}}</td>
            <td>{{ $u->birth_place}}</td>
            <td>{{ $u->address}}</td>
            <td>
            <livewire:open-dialog-button
                wire:key="'o-d-u-'.{{ $u->id }}"
                classes="rounded"
                content="<i class='fa-solid fa-trash'></i>"
                :toolTipMessage="__('toolTips.user.delete')"
                :data='[
                         "question" => "dialogs.title.user",
                         "details" =>["user", $u->name],
                         "actionEvent"=>[
                                         "event"=>"delete-user",
                                         "parameters"=>$u
                                         ]
                         ]'
                 />
           <livewire:open-modal-button
             wire:key="'o-b-u-'.{{ $u->id }}"
             classes="rounded"
              :toolTipMessage="__('toolTips.user.update')"
            content="<i class='fa-solid fa-pen-to-square'></i>"
            :data='[
                    "title" => "modals.user.for.update-employee",
                     "component" => [
                                     "name" => "admin.user-modal",
                                     "parameters" => ["id"=>$u->id]
                                     ]
                    ]'
             />
             <livewire:open-modal-button
                wire:key="'o-b-m-u-'.{{ $u->id }}"
                classes="rounded"
                  :toolTipMessage="__('toolTips.user.manage')"
                 content="<i class='fa-solid fa-link'></i>"
                 :data='[
                         "title" => "modals.role.for.manage",
                         "component" => [
                                         "name" => "admin.manage-roles-modal",
                                         "parameters" => ["id" => $u->id]
                                         ]
                         ]'
              />

              @if ($u->cv_url)
              <a class="button rounded hasToolTip"
              href="{{$u->cv_url}}"
              target="_blank"
              >
              <span
              class="toolTip"
              role="tooltip"
              aria-label="__('toolTips.user.cv')"
            >
          @lang('toolTips.user.cv')
            </span>
              <i class="fa-solid fa-file-pdf"></i>
              </a>
              @endif

            </td>
         </tr>
       @endforeach

        </tbody>
    </table>
</div>
{{ $this->users->links('components.pagination') }}
    @else
    <div class="table__footer">
        <h2>
            {{$customNoUserFoundMessage ?? $defaultNoUserFoundMessage }}
        </h2>
    </div>
   @endif
</div>



