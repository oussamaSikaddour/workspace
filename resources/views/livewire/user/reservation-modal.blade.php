@php
    $HoursOptions = app('my_constants')['HOURS'];
    $days = app('my_constants')['WEEK_DAYS'][app()->getLocale()];
@endphp

<div class="form__container">
    <form class="form" wire:submit="handleSubmit">

        <div class="row center">
            <x-form.input
            name="form.start_date"
           :label="__('modals.reservation.startDate')"
            type="date"
           html_id="rm-sd"
           role="filter"
           :min="$minStartDate"
            />
            <x-form.input
            name="form.end_date"
           :label="__('modals.reservation.endDate')"
            type="date"
           html_id="rm-ed"
           :min="$minEndDate"
            />
          </div>
        <div class="row center">
            <x-form.input
            name="form.capacity"
           :label="__('modals.reservation.capacity')"
            type="text"
           html_id="rm-ca"
           :min="1"
            />
            <x-form.check-box
            model="form.hourly"
            value="1"
            :label="__('modals.reservation.hourly')"
            :live="true"
            htmlId="rm-hour"/>
        </div>


        @if($form->hourly)
        <div class="row center">

            <x-form.selector
            htmlId="rm-st"
            name="form.start_time"
            :label="__('modals.reservation.startTime')"
            :data="$HoursOptions"
            :showError="true"
            />
            <x-form.selector htmlId="rm-et" name="form.end_time"
            :label="__('modals.reservation.endTime')" :data="$HoursOptions"        :showError="true" />
        </div>
        @endif
        <div class="column">
            <p>@lang('modals.reservation.days') :</p>
            @if(isset($days) && count($days)>0)
                <div class="checkbox__group">
                    <h2 id="checkbox-choices" class="sr-only">@lang('modals.reservation.days')</h2>
                    <div class="choices" day="groupe" aria-labelledby="checkbox-choices">
                        @foreach($days as $value => $key)
                            <x-form.check-box
                            model="form.reservation_days"
                            value="{{ $value }}"
                            label="{{ $key }}"
                             htmlId="day-m-{{ $value }}" />
                        @endforeach

                    </div>
                    @error("form.reservation_days")
                    <div class="input__error">{{ $message }}</div>
                @enderror
                </div>
            @endif
        </div>
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
