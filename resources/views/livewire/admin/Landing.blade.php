
<div class="form__container">
    <form class="form" wire:submit="handleSubmit">


        <div class="row center">
            <x-form.input name="form.email" :label="__('forms.landing.email')" type="email" html_id="FL-e" />
            <x-form.input name="form.phone" :label="__('forms.landing.phone')" type="text" html_id="Fl-phone" />
        </div>
        <div class="row center">
            <x-form.input name="form.landline" :label="__('forms.landing.landline')" type="text" html_id="FL-ll" />
            <x-form.input name="form.fax" :label="__('forms.landing.fax')" type="text" html_id="FL-f" />
        </div>


        <div class="column center">
            <x-form.textarea
            name="form.map"
            :label="__('forms.landing.map')"
            html_id="FL-m"
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

        <x-form.upload-input model="form.logo"
        :label="__('forms.landing.logo')" />

            <div x-show="uploading">
              <progress max="100" x-bind:value="progress"></progress>


          </div>

            </div>
        @if ($temporaryImageUrl !=="")
            <div class="imgs__container">
                <div class="imgs">
                    <img class="img" src="{{ $temporaryImageUrl }}" alt="{{__('forms.landing.logo')}}" />
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
