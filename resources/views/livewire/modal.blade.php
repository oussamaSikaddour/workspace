
<div
role="dialog"
aria-labelledby="dialog_label"
 class="modal"
 id="defaultModal"
 x-bind:class="{ 'open': {{ $isOpen ? 'true' : 'false' }} }"
 >
  <div class="modal__content">
    <div class="modal__header">
      <h2 id="dialog_label" class="sr-only" >info Modal</h2>
      <h2 >@lang($title)</h2>
      <button class="modal__closer" >
        <span></span>
        <span></span>
      </button>

    </div>
    <div class="modal__body">
        @switch($type)

               @case("simple_img")
               <div class="form__container">
                   <img src="{{ $component }}" alt="lettre ">
                </div>
                @break
            @default
            @if(isset($component) && is_array($component) && count($component) > 0)
            @livewire($component['name'], $component['parameters'])
        @endif
        @endswitch
    </div>

  </div>
</div>



@script
  <script>
  document.addEventListener('model-will-be-close', function(event) {
        @this.closeModal();
        if(@this.containsTinyMce === true){
        window.location.reload();
        }
    });
  </script>
@endscript

