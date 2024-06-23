@php
    $form = ($id !== '') ? 'updateForm' : 'addForm';
    $HoursOptions = app('my_constants')['HOURS'];
    $days = app('my_constants')['WEEK_DAYS'][app()->getLocale()];
@endphp

<div class="form__container">
    <form class="form" wire:submit="handleSubmit">

        <div class="row center">
            <x-form.input name="{{$form}}.name_fr" :label="__('modals.classroom.nameFr')" type="text" html_id="MA-name_fr" />
            <x-form.input name="{{$form}}.name_ar" :label="__('modals.classroom.nameAr')" type="text" html_id="MA-name_ar" />
            <x-form.input name="{{$form}}.capacity" :label="__('modals.classroom.capacity')" type="text" html_id="MA-capacity" />
        </div>

        <div class="column">
            <p>@lang('modals.classroom.descriptionFr') :</p>
            <livewire:tiny-mce-text-area htmlId="MAdescriptionfr" contentUpdatedEvent="set-description-fr" wire:key="MaDescriptionFr" :content="$descriptionFr" />
            <p>@lang('modals.classroom.descriptionAr') :</p>
            <livewire:tiny-mce-text-area htmlId="MAdescriptionAr" contentUpdatedEvent="set-description-ar" wire:key="MaDescriptionAr" :content="$descriptionAr" />
        </div>

        <div class="row center">
            <x-form.input name="{{$form}}.latitude" :label="__('modals.classroom.latitude')" type="text" html_id="MCR-latitude" />
            <x-form.input name="{{$form}}.longitude" :label="__('modals.classroom.longitude')" type="text" html_id="MCR-longitude" />
        </div>

        <div class="row center">
            <x-form.selector htmlId="MCRopenTime" name="{{ $form }}.open_time"
            :label="__('modals.classroom.openTime')" :data="$HoursOptions" type="filter" />
            <x-form.selector htmlId="MCRcloseTime" name="{{ $form }}.close_time"
            :label="__('modals.classroom.closeTime')" :data="$HoursOptions" type="filter" />
        </div>

        <div class="column">
            <p>@lang('modals.classroom.workingDays') :</p>
            @if(isset($days) && count($days)>0)
                <div class="checkbox__group">
                    <h2 id="checkbox-choices" class="sr-only">@lang('modals.classroom.workingDays')</h2>
                    <div class="choices" day="groupe" aria-labelledby="checkbox-choices">
                        @foreach($days as $value => $key)
                            <x-form.check-box model="{{ $form }}.working_days" value="{{ $value }}" label="{{ $key }}" htmlId="day-m-{{ $value }}" />
                        @endforeach
                        @error("{{ $form }}.working_days")
                            <div class="input__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endif
        </div>

        <div class="row center">
            <x-form.input name="{{$form}}.price_per_hour"
            :label="__('modals.classroom.pricePerHour')" type="number" html_id="MCR-pph" />
            <x-form.input name="{{$form}}.price_per_day"
            :label="__('modals.classroom.pricePerDay')" type="number" html_id="MCR-ppd" />
        </div>

        <div class="row center">
            <x-form.input name="{{$form}}.price_per_week"
            :label="__('modals.classroom.pricePerWeek')" type="number" html_id="MCR-ppw" />
            <x-form.input name="{{$form}}.price_per_month"
            :label="__('modals.classroom.pricePerMonth')" type="number" html_id="MCR-ppm" />
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
        :label="__('modals.classroom.image')" :multiple=true />

            <div x-show="uploading">
              <progress max="100" x-bind:value="progress"></progress>


          </div>

            </div>

        @if (is_array($temporaryImageUrls) && !empty($temporaryImageUrls))
            <div class="imgs__container">
                <div class="imgs">
                    @foreach ($temporaryImageUrls as $url)
                        <img class="img" src="{{ $url }}" alt="{{__('modals.classroom.images')}}" />
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


const dayChoices = document.querySelector(".checkbox__group > .choices");
const dayChoicesLabels= dayChoices.querySelectorAll("label")
const dayChoicesInputs= dayChoices.querySelectorAll("input[type='checkbox']")
dayChoicesLabels.forEach((label, index) => {
label.addEventListener('keydown', (e) => {
      if (e.key === ' ') {
        const checkBoxCheckedEvent = new CustomEvent('checkbox-checked-event' ,{
                   detail: {
                      checkBox:dayChoicesInputs[index]
                          }
                        });
        document.dispatchEvent(checkBoxCheckedEvent);
        @this.updatedaysOnKeydownEvent(dayChoicesInputs[index].value)
      }
    })
});

$wire.on('form-submitted',()=>{
const clearFormErrorsOnFocusEvent = new CustomEvent('clear-form-errors-on-focus');
 document.dispatchEvent(clearFormErrorsOnFocusEvent);
})

</script>
@endscript
