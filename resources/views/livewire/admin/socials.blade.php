
<div class="form__container small">
    <form class="form" wire:submit="handleSubmit">


        <div class="column ">
            <x-form.input name="form.youtube" :label="__('forms.socials.youtube')" type="text" html_id="FS-Y" />
            <x-form.input name="form.facebook" :label="__('forms.socials.facebook')" type="text" html_id="FS-f" />
            <x-form.input name="form.instagram" :label="__('forms.socials.instagram')" type="text" html_id="FS-i" />
            <x-form.input name="form.linkedin" :label="__('forms.socials.linkedin')" type="text" html_id="FS-l" />
            <x-form.input name="form.github" :label="__('forms.socials.github')" type="text" html_id="FS-g" />
            <x-form.input name="form.tiktok" :label="__('forms.socials.tiktok')" type="text" html_id="FS-t" />

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

$wire.on('form-submitted',()=>{
const clearFormErrorsOnFocusEvent = new CustomEvent('clear-form-errors-on-focus');
 document.dispatchEvent(clearFormErrorsOnFocusEvent);
})

</script>
@endscript
