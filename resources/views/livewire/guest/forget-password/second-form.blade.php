<form class="form form--2" wire:submit.prevent="handleSubmit" >
    <h3>      @lang("forms.forget-pwd.second-f.instruction")</h3>

    <div class="column">
        <x-form.input
        name="form.email"
        :label="__('forms.forget-pwd.second-f.email')"
        type="email"
        html_id="FPEmail" />
        <x-form.input
        name="form.code"
       :label="__('forms.forget-pwd.second-f.code')"
          type="text"
          html_id="FPPassword" />
    </div>
    <div class="column">
        <x-form.password-input
        :label="__('forms.forget-pwd.second-f.password')"
          name="form.password"
          html_id="FPNPassword"/>
    </div>
        <div class="form__actions">
            <div wire:loading>
                <x-loading />
            </div>
            <button
              type="submit" class="button button--primary">
                @lang("forms.common.submit-btn")</button>
        </div>
</form>


@script
<script>

document.addEventListener('email-forget-password-is-set', function(event) {
    @this.setEmail(event.detail.data.email);
 });

$wire.on("second-step-succeeded", () => {
const forgetPasswordSecondFormSucceededEvent = new CustomEvent('forget-password-second-step-succeeded' );
document.dispatchEvent(forgetPasswordSecondFormSucceededEvent);
})


$wire.on('form-submitted',()=>{
    const forgetPasswordSecondForm= document.querySelector(".form--2");

    const clearFormErrorsOnFocusEvent = new CustomEvent('clear-form-errors-on-focus' ,{
    detail: {
        form:forgetPasswordSecondForm
    }
});
document.dispatchEvent(clearFormErrorsOnFocusEvent);
     })
</script>
@endscript
