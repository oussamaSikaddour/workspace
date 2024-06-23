
<div
class="form__container"
>
    <form
    class="form"
    wire:submit="handleSubmit" >

    <div class="column">
        <x-form.input
        name="form.days_off_start"
        :label="__('modals.days-off.days-off-start')"
         type="date"
        html_id="MDO_dOs"
        role="filter"
        :min="$minDateStart"
         />
        <x-form.input
        name="form.days_off_end"
        :label="__('modals.days-off.days-off-end')"
         type="date"
        html_id="MDO_dOe"
        :min="$minDateEnd"
        />
    </div>

<div class="form__actions">
            <div wire:loading wire:target="handleSubmit">
                <x-loading  />
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
