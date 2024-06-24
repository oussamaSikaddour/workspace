<!-- resources/views/livewire/registration-form.blade.php -->

<form class="form form--1" wire:submit.prevent="handleSubmit" >
    <h3>@lang("forms.register.first-f.instruction")</h3>

    <div class="column">
        <x-form.input
        name="form.email"
       :label="__('forms.register.first-f.email')"
        type="email"
        html_id="registEmail" />
         <x-form.password-input
         name="form.password"
         :label="__('forms.register.first-f.password')"
          html_id="registPassword"/>
    </div>
    <div class="form__actions">

        <div wire:loading>
             <x-loading  />
        </div>
        <a class="button"    href="{{ route("loginPage") }}" >@lang("forms.register.first-f.login-link")</a>
         <button type="submit" class="button button--primary">@lang("forms.common.submit-btn")</button>
    </div>
</form>


@script
<script>
 const registerFirstForm = document.querySelector(".form--1");
const registerSecondForm = document.querySelector(".form--2");
const registrationEmail = localStorage.getItem('registration-email') ;
const registerForms = document.querySelector(".forms");
if(registrationEmail){
      addEventListener("DOMContentLoaded", (event) => {
        const registrationEmailEvent = new CustomEvent('email-registration-is-set',
             {
               detail: {email:registrationEmail}
              });
           document.dispatchEvent(registrationEmailEvent);
         });

         registerForms.classList.add("slide");
         registerFirstForm.setAttribute("inert", "");
         registerSecondForm.removeAttribute("inert");

} else {

         registerForms.classList.remove("slide");
         registerFirstForm.removeAttribute("inert");
         registerSecondForm.setAttribute("inert", "");

}

$wire.on("first-step-succeeded", () => {
    const firstFormSuccessEvent = new CustomEvent('register-first-step-succeeded',
{
 detail: {
            email:@this.registrationEmail
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
