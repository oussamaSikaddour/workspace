
<div
role="alert"
aria-labelledby="errors_label"
class="errors__container"
id="defaultErrors"
x-bind:class="{ 'open': {{ $isOpen ? 'true' : 'false' }} }"
>
 <h2 id="errors_label " class="sr-only" >errors</h2>
    <button
    class="errors__closer"
    wire:click="toggleErrors()">
      <span ></span>
      <span ></span>
    </button>
     <ul class="errors" tabindex="0">
        @foreach ($errors as $error)
        <x-error :error="$error"/>
         @endforeach
    </ul>
</div>





@script
<script>
    $wire.on('handle-errors-state', () => {
          const errors = document.querySelector(".errors__container");
          if (@this.isOpen) {
                errors.classList.add("open");
                const closeErrors = document.querySelector(".errors__closer");
                closeErrors.focus();
            } else {
                errors.classList.remove("open");
            }
            const isOpen = errors.classList.contains("open");
          const setAriaAttributesEvent = new CustomEvent('set-aria-attributes-event' ,{
           detail: {
                   hidden:!isOpen,
                    tabindex: isOpen ? "0" : "-1",
                    element:errors
                   }
               });
            document.dispatchEvent(setAriaAttributesEvent);
          const toggleInertForAllExceptOpenedElementEvent = new CustomEvent('toggle-inert-for-all-except-opened-element' ,{
           detail: {
                    element:errors,
                    className:"open"
                   }
               });
            document.dispatchEvent(toggleInertForAllExceptOpenedElementEvent);
    });
</script>
@endscript
