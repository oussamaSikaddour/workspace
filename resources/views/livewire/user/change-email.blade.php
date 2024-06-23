<form class="form " wire:submit.prevent="handleSubmit" >
    <h3>
        @lang("forms.change-email.instruction")
    </h3>
    <div class="column">
        <x-form.input
        name="form.oldEmail"
        :label="__('forms.change-email.old-email')"
          type="email"
           html_id="FCPEmail" />
        <x-form.password-input
        :label="__('forms.change-email.pwd')"
        name="form.password"
         html_id="CEPassword" />
    </div>
    <div class="column">
        <x-form.input
        name="form.newEmail"
        :label="__('forms.change-email.new-email')"
          type="email"
           html_id="FCPNewEmail" />
    </div>
    <div class="form__actions">
        <div wire:loading>
            <x-loading />
        </div>
        <button type="submit" class="button button--primary">@lang("forms.common.submit-btn")</button>
    </div>
</form>

@script
<script>
$wire.on("redirect-page", () => {
    setTimeout(() => { @this.redirectPage() }, 4500)
})


      $wire.on('form-submitted',()=>{
        const clearFormErrorsOnFocusEvent = new CustomEvent('clear-form-errors-on-focus');
          document.dispatchEvent(clearFormErrorsOnFocusEvent);
         })

</script>
@endscript
