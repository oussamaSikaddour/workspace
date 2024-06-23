
<form class="form form--2" wire:submit.prevent="handleSubmit"  >
        <h3>
        @lang("forms.site-params.second-f.instruction")
        </h3>
        <div class="column center">

            <div class="radio__group">
            <div class="choices">

            <x-form.radio-button
             model="form.maintenance"
             value="1"
            :label="__('forms.site-params.second-f.enable')"
             htmlId="m-m-rb-y"/>
            <x-form.radio-button
             model="form.maintenance"
             value="0"
           :label="__('forms.site-params.second-f.disable')"
             htmlId="m-m-rb-n"/>
            </div>
            @error("form.maintenance")
            <div class="input__error">
                {{ $message }}
            </div>
            @enderror

            </div>
        </div>

        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            @if ($generalSettings?->maintenance)
           <button class="button " wire:click.prevent="downloadDatabase"> @lang("forms.site-params.second-f.db-download-btn")</button>
           @endif
            <button type="submit" class="button button--primary">@lang("forms.common.submit-btn")</button>
        </div>
</form>


@script

<script>

const siteStates = document.querySelector(".radio__group > .choices");
const siteStatesLabels= siteStates.querySelectorAll("label")
const siteStatesInputs= siteStates.querySelectorAll("input[type='radio']")

siteStatesLabels.forEach((label, index) => {
label.addEventListener('keydown', (e) => {
      if (e.key === ' ') {
        const RadioButtonCheckedEvent = new CustomEvent('radio-button-checked-event' ,{
                   detail: {
                      radioButton:siteStatesInputs[index]
                          }
                        });
               document.dispatchEvent(RadioButtonCheckedEvent);
        @this.updateMaintenanceOnKeydownEvent(siteStatesInputs[index].value)
      }
    })
});

$wire.on('form-submitted',()=>{
const siteParamsSecondForm= document.querySelector(".form--2");
const clearFormErrorsOnFocusEvent = new CustomEvent('clear-form-errors-on-focus' ,{
    detail: {
        form:siteParamsSecondForm
    }
});
document.dispatchEvent(clearFormErrorsOnFocusEvent);
 })
</script>


@endscript
