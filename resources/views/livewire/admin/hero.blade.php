
<div class="form__container">
    <form class="form" wire:submit="handleSubmit">


        <div class="row center ">
            <x-form.input name="form.title_fr" :label="__('forms.hero.title-fr')" type="text" html_id="FH-tf" />
            <x-form.input name="form.title_ar" :label="__('forms.hero.title-ar')" type="text" html_id="FH-ta" />

        </div>
        <div class="row  center">
            <x-form.input name="form.sub_title_fr" :label="__('forms.hero.sub-title-fr')" type="text" html_id="FH-stf" />
            <x-form.input name="form.sub_title_ar" :label="__('forms.hero.sub-title-ar')" type="text" html_id="FH-sta" />

        </div>


        <div class="column center"

        x-data="{ uploading: false, progress: 0 }"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false"
        x-on:livewire-upload-cancel="uploading = false"
        x-on:livewire-upload-error="uploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
        >

        <x-form.upload-input model="form.images"
        :label="__('forms.hero.image')" :multiple=true />

            <div x-show="uploading">
              <progress max="100" x-bind:value="progress"></progress>


          </div>

            </div>
        @if (is_array($temporaryImageUrls) && !empty($temporaryImageUrls))
            <div class="imgs__container">
                <div class="imgs">
                    @foreach ($temporaryImageUrls as $url)
                        <img class="img" src="{{ $url }}" alt="{{__('forms.hero.images')}}" />
                    @endforeach
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
