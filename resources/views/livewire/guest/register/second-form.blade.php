<form class="form form--2" id="myForm"
>
    <h3>@lang("forms.register.second-f.instruction")</h3>
    <div class="column">
        <x-form.input name="form.email"
        :label="__('forms.register.second-f.email')"
        type="email"
        html_id="registerSFEmail" />
        <x-form.input
        name="form.code"
       :label="__('forms.register.second-f.code')"
        type="text"
        html_id="registerVerificationCode" />
    </div>
    <div class="center">
        <button class="button" wire:click.prevent='setNewValidationCode'>
            @lang("forms.register.second-f.new-code-btn")
        </button>
    </div>
    <div class="form__actions">
        <div wire:loading>
            <x-loading  />
       </div>
        <button class="button button--primary" type='submit' wire:click.prevent="handleSubmit" id="validerButton">
            @lang("forms.common.submit-btn")
        </button>
    </div>
</form>

@script
<script>
 const form = document.getElementById('myForm');
 const validerButton = document.getElementById('validerButton');
 form.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            // Prevent the default form submission
            event.preventDefault();
            // Trigger a click event on the "Valider" button
            validerButton.click();
        }
});
 document.addEventListener('set-email-registration', function(event) {
    @this.setEmail(event.detail.data.email);
 });
$wire.on("second-step-succeeded", () => {
const registerSecondStepSucceededEvent = new CustomEvent('register-second-step-succeeded' );
document.dispatchEvent(registerSecondStepSucceededEvent);
})

$wire.on('form-submitted',()=>{
const registerSecondForm = document.querySelector(".form--2");
const clearFormErrorsOnFocusEvent = new CustomEvent('clear-form-errors-on-focus' ,{
         detail: {
               form:registerSecondForm
                 }
              });
document.dispatchEvent(clearFormErrorsOnFocusEvent);

 })
</script>
@endscript
