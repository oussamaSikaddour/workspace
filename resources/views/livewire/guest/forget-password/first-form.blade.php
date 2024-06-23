<!-- resources/views/livewire/registration-form.blade.php -->

<form class="form form--1" wire:submit.prevent="handleSubmit" >
    <h3>
        @lang("forms.forget-pwd.first-f.instruction")
    </h3>
    <div class="column">
        <x-form.input
        name="form.email"
        :label="__('forms.forget-pwd.first-f.email')"
          type="email"
           html_id="FFPEmail" />
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


 const forgetPasswordFirstForm = document.querySelector(".form--1");
const forgetPasswordSecondForm = document.querySelector(".form--2");
const forgetPasswordForms = document.querySelector(".forms");
forgetPasswordForms.classList.remove("slide");
forgetPasswordFirstForm.removeAttribute("inert");
forgetPasswordSecondForm.setAttribute("inert", "");
$wire.on("first-step-succeeded", () => {
const firstFormSuccessEvent = new CustomEvent('forget-password-first-step-succeeded',
{
 detail: {
            email:@this.forgetPasswordEmail
        }
});
 document.dispatchEvent(firstFormSuccessEvent);
})

$wire.on('form-submitted',()=>{
 const clearFormErrorsOnFocusEvent = new CustomEvent('clear-form-errors-on-focus');
 document.dispatchEvent(clearFormErrorsOnFocusEvent);
 })
</script>
@endscript
