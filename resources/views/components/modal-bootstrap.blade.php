<div {{ $attributes->class([$backdropClasses])->merge(['id' => $id, 'tabindex' => '-1']) }} x-ref="modalElement"
    x-data="{
        modal: null,
        init() {
            this.modal = new bootstrap.Modal($el);
        },
        openModal: function() {
            if (this.modal) this.modal.show();
        },
        closeModal: function() {
            if (this.modal) this.modal.hide();
        },
    
        behavior: {
            ['x-on:modal:show']() {
                this.openModal();
            },
            ['x-on:modal:close']() {
                this.closeModal();
            },
            ['x-on:keydown.escape.window']() {
                this.closeModal();
            },
        }
    }" x-bind="behavior" wire:ignore.self>

    <div class="{{ $containerClasses }}">
        <div class="{{ $windowClasses }}">

            @isset($header)
                <div {{ $header->attributes->class([$headerClasses]) }}>
                    {{ $header ?? '' }}
                    <button type="button" class="{{ $headerCloseBtnClasses }}" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
            @else
                <div class="modal-header">
                    <h5 class="modal-title">{{ $titleText }}</h5>
                    <button type="button" class="{{ $headerCloseBtnClasses }}" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
            @endisset

            @isset($body)
                <div {{ $body->attributes->class([$bodyClasses]) }}>
                    {{ $body ?? '' }}
                    {{ $slot ?? '' }}
                </div>
            @else
                <div class="{{ $bodyClasses }}">
                    {{ $slot ?? '' }}
                </div>
            @endisset


            @isset($footer)
                <div {{ $footer->attributes->class([$footerClasses]) }}>
                    {{ $footer }}
                    @if ($footer->attributes->has('defaultClose') && $footer->attributes->get('defaultClose'))
                        <button type="button" class="{{ $footerCloseBtnClasses }}" data-bs-dismiss="modal">Close</button>
                    @endif
                </div>
            @else
                <div class="{{ $footerClasses }}">
                    <button type="button" class="{{ $footerCloseBtnClasses }}" data-bs-dismiss="modal">Close</button>
                </div>
            @endisset

        </div>
    </div>

</div>
