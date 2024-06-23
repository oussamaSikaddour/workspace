
<section class="contact-us" id="contactUs">


    {!! $map !!}

    <div class="contact-us__form">


<div class="form__container">
    <form class="form" wire:submit="handleSubmit">


        <div class="column">
            <x-form.input name="form.name" :label="__('forms.message.name')" type="text" html_id="lc-m-n" />
            <x-form.input name="form.email" :label="__('forms.message.email')" type="email" html_id="lc-m-e" />

        </div>

        <div class="column ">
            <x-form.textarea
            name="form.message"
            :label="__('forms.message.message')"
            html_id="lc-m-m"
            />
        </div>
        <div class="form__actions">
            <div wire:loading wire:target="handleSubmit">
                <x-loading />
            </div>
            <button type="submit" class="button button--primary">@lang('modals.common.submit-btn')</button>
        </div>
    </form>
</div>
      </div>
    </section>


    @script

<script>

      $wire.on('form-submitted',()=>{
        const clearFormErrorsOnFocusEvent = new CustomEvent('clear-form-errors-on-focus');
          document.dispatchEvent(clearFormErrorsOnFocusEvent);
         })

</script>
@endscript
