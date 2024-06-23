<button class="button {{ $classes }} box__opener {{ $toolTipMessage !==""?'hasTooltip':''}}" wire:click="openDialog">

    @if($toolTipMessage)
    <span
    class="toolTip"
    role="tooltip"
    aria-label="{{ $toolTipMessage }}"
  >
   {{ $toolTipMessage }}
  </span>
    @endif
    {{ $title }}
      {!! $content !!}
</button>


@script
<script>
$wire.on("open-dialog",()=>{
const openDialogBoxEvent = new CustomEvent('open-dialog-box');
document.dispatchEvent(openDialogBoxEvent);
})
</script>
@endscript
