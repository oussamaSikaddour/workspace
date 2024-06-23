@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
@endphp

<div class="form__container">
    <form class="form" wire:submit="handleSubmit">

        <div class="row center">
            <x-form.input name="{{$form}}.name_fr" :label="__('modals.product.nameFr')" type="text" html_id="MP-name_fr" />
            <x-form.input name="{{$form}}.name_ar" :label="__('modals.product.nameAr')" type="text" html_id="MP-name_ar" />
        </div>
        <div class="row center">
            <x-form.input name="{{$form}}.quantity" :label="__('modals.product.quantity')" type="number" html_id="MP-quantity" />
            <x-form.input name="{{$form}}.price" :label="__('modals.product.price')" type="number" html_id="MP-price" />

        </div>

        <div class="column">
            <p>@lang('modals.product.descriptionFr') :</p>
            <livewire:tiny-mce-text-area htmlId="MAdescriptionfr" contentUpdatedEvent="set-description-fr" wire:key="MPDescriptionFr" :content="$descriptionFr" />
            <p>@lang('modals.product.descriptionAr') :</p>
            <livewire:tiny-mce-text-area htmlId="MAdescriptionAr" contentUpdatedEvent="set-description-ar" wire:key="MPDescriptionAr" :content="$descriptionAr" />
        </div>

        <div class="column center"

        x-data="{ uploading: false, progress: 0 }"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false"
        x-on:livewire-upload-cancel="uploading = false"
        x-on:livewire-upload-error="uploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
        >

        <x-form.upload-input model="{{ $form }}.images"
        :label="__('modals.product.image')" :multiple=true />

            <div x-show="uploading">
              <progress max="100" x-bind:value="progress"></progress>


          </div>

            </div>
        @if (is_array($temporaryImageUrls) && !empty($temporaryImageUrls))
            <div class="imgs__container">
                <div class="imgs">
                    @foreach ($temporaryImageUrls as $url)
                        <img class="img" src="{{ $url }}" alt="{{__('modals.prodcut.images')}}" />
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
