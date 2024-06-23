
<div class="form__container ">
    <form class="form" wire:submit="handleSubmit">

        <div class="row center">
            <x-form.input name="form.title_fr" :label="__('forms.aboutUs.titleFr')" type="text" html_id="FAU-tf" />
            <x-form.input name="form.title_ar" :label="__('forms.aboutUs.titleAr')" type="text" html_id="FAU-ta" />
        </div>


        <div class="row">
            <x-form.textarea
            name="form.description_fr"
            :label="__('forms.aboutUs.descriptionFr')"
            html_id="FAU-df"
            />
            <x-form.textarea
            name="form.description_ar"
            :label="__('forms.aboutUs.descriptionAr')"
            html_id="FAU-da"
            />
        </div>

        <div class="column center"

        x-data="{ uploading: false, progress: 0 }"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false"
        x-on:livewire-upload-cancel="uploading = false"
        x-on:livewire-upload-error="uploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
        >

        <x-form.upload-input model="form.image"
        :label="__('forms.aboutUs.image')" />

            <div x-show="uploading">
              <progress max="100" x-bind:value="progress"></progress>


          </div>

            </div>
        @if ($temporaryImageUrl !=="")
            <div class="imgs__container">
                <div class="imgs">
                    <img class="img" src="{{ $temporaryImageUrl }}" alt="{{__('forms.aboutUs.image')}}" />
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
