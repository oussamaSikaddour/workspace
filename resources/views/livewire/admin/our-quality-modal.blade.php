@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
@endphp

<div class="form__container">
    <form class="form" wire:submit="handleSubmit">

        <div class="row center">
            <x-form.input name="{{$form}}.name_fr" :label="__('modals.ourQuality.nameFr')" type="text" html_id="Moq-nfr" />
            <x-form.input name="{{$form}}.name_ar" :label="__('modals.ourQuality.nameAr')" type="text" html_id="Moq-nAr" />
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
        :label="__('modals.ourQuality.image')"  />

            <div x-show="uploading">
              <progress max="100" x-bind:value="progress"></progress>


          </div>

            </div>
        @if ($temporaryImageUrl !=="")
            <div class="imgs__container">
                <div class="imgs">
                        <img class="img" src="{{ $temporaryImageUrl }}" alt="{{__('modals.ourQuality.image')}}" />
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
