<form class="form form--1" wire:submit="handleSubmit">
    <h3>
    @lang("forms.site-params.first-f.instruction")
    </h3>
    <div class="column">
        <x-form.input
        name="form.email"
         :label="__('forms.site-params.first-f.email')"
          type="email"
          html_id="loginEmail" />
        <x-form.password-input
        name="form.password"
       :label="__('forms.site-params.first-f.password')"
        html_id="loginPassword"/>
   </div>

   <div class="form__actions">

       <div wire:loading>
            <x-loading  />
       </div>
       <button type="submit" class="button button--primary">@lang("forms.common.submit-btn")</button>

   </div>
  </form>

  @script
<script>
 const sitParamsFirstForm = document.querySelector(".form--1");
const sitParamsSecondForm = document.querySelector(".form--2");
const sitParamsForms = document.querySelector(".forms");
    sitParamsForms.classList.remove("slide");
    sitParamsFirstForm.removeAttribute("inert");
    sitParamsSecondForm.setAttribute("inert", "");
$wire.on("first-step-succeeded", () => {
const firstFormSuccessEvent = new CustomEvent('site-params-first-step-succeeded');
 document.dispatchEvent(firstFormSuccessEvent);
})

$wire.on('form-submitted',()=>{
 const clearFormErrorsOnFocusEvent = new CustomEvent('clear-form-errors-on-focus');
 document.dispatchEvent(clearFormErrorsOnFocusEvent);
 })

</script>
@endscript
