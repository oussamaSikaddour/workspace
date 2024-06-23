<form class="form" wire:submit="handelSubmit" x-on:redirect-page="setTimeout(() => { $wire.redirectPage() }, 10000)">
    <h3 >@lang("forms.change-pwd.instruction")</h3>
    <div class="column">
        <x-form.password-input
        :label="__('forms.change-pwd.pwd')"
        name="form.password"
         html_id="CPPassword" />
        <x-form.password-input
        :label="__('forms.change-pwd.new-pwd')"
         name="form.newPassword"
         html_id="newPassword" />
    </div>
    <div class="form__actions">
        <div wire:loading>
            <x-loading />
        </div>
        <button type="submit" class="button button--primary">@lang("forms.common.submit-btn")
        </button>
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
