
<button class="button {{ $classes }} modal__opener {{ $toolTipMessage !==""?'hasTooltip':''}}" wire:click="openModal">

    @if($toolTipMessage)
    <span
    class="toolTip"
    role="tooltip"
    aria-label="{{ $toolTipMessage }}"
  >
   {{ $toolTipMessage }}
  </span>
  @endIf
{{ $title }}
  {!! $content !!}
</button>


@script
<script>
$wire.on("open-modal",()=>{
const setAriaAttributesEvent = new CustomEvent('open-modal-js');
document.dispatchEvent(setAriaAttributesEvent);
})
</script>
@endscript
