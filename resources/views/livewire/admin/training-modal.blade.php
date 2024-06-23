@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
@endphp

<div class="form__container">
    <form class="form" wire:submit="handleSubmit">

        <div class="row center">
            <x-form.input name="{{$form}}.name_fr" :label="__('modals.training.nameFr')" type="text" html_id="MTr-name_fr" />
            <x-form.input name="{{$form}}.name_ar" :label="__('modals.training.nameAr')" type="text" html_id="MTr-name_ar" />
        </div>
        <div class="row center">
            <x-form.input name="{{$form}}.capacity" :label="__('modals.training.capacity')" type="number" html_id="MTr-capacity" />
            <x-form.selector
            htmlId="MTr-formatter"
            name="{{$form}}.user_id"
           :label="__('modals.training.formatter')"
            :data="$formatterOptions"
            :showError="true"
        />
        </div>

        <div class="row center">
            <x-form.input name="{{$form}}.price_per_session" :label="__('modals.training.pricePerSession')" type="number" html_id="MTr-pT" />
            <x-form.input name="{{$form}}.price_total" :label="__('modals.training.priceTotal')" type="nubmer" html_id="MTr-pps" />
        </div>

    <div class="row center">
        <x-form.input
        name="{{$form}}.start_at"
        :label="__('modals.training.start_at')"
         type="date"
        html_id="MTr_SAt"
        role="filter"
        :min="$minDateStart"
         />
        <x-form.input
        name="{{$form}}.end_at"
        :label="__('modals.training.end_at')"
         type="date"
        html_id="MTr_EAt"
        :min="$minDateEnd"
        />
    </div>

        <div class="column">
            <p>@lang('modals.training.descriptionFr') :</p>
            <livewire:tiny-mce-text-area htmlId="MAdescriptionfr" contentUpdatedEvent="set-description-fr" wire:key="MTrDescriptionFr" :content="$descriptionFr" />
            <p>@lang('modals.training.descriptionAr') :</p>
            <livewire:tiny-mce-text-area htmlId="MAdescriptionAr" contentUpdatedEvent="set-description-ar" wire:key="MTrDescriptionAr" :content="$descriptionAr" />
        </div>

        <div class="column center"

        x-data="{ uploading: false, progress: 0 }"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false"
        x-on:livewire-upload-cancel="uploading = false"
        x-on:livewire-upload-error="uploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
        >

        <x-form.upload-input model="{{ $form }}.image"
        :label="__('modals.training.image')"  />

            <div x-show="uploading">
              <progress max="100" x-bind:value="progress"></progress>


          </div>

            </div>
        @if ($temporaryImageUrl !=="")
            <div class="imgs__container">
                <div class="imgs">
                        <img class="img" src="{{ $temporaryImageUrl }}" alt="{{__('modals.training.image')}}" />
                </div>
            </div>
        @endif

        <div class="form__actions">
            <div wire:loading wire:target="handleSubmit">
                <x-loading />
            </div>
            <button type="submit" class="button button--primary">@lang('modals.common.submit-btn')</button>
        </div>
    </form>
</div>

@script
<script>

$wire.on('form-submitted',()=>{
const clearFormErrorsOnFocusEvent = new CustomEvent('clear-form-errors-on-focus');
 document.dispatchEvent(clearFormErrorsOnFocusEvent);
})

</script>
@endscript
