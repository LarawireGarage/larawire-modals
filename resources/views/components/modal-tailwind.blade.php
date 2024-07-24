<div {!! $attributes->class([
    'fixed inset-0 z-50 backdrop-blur-sm bg-gray-800/30 text-gray-900 w-full h-screen overflow-y-auto transform transition-all',
    // $backdropClasses,
]) !!} role="dialog" wire:ignore.self x-data="{
    show: false,
    init() {},
    openModal: function() {
        this.show = true;
        document.body.classList.add('overflow-y-hidden');
    },
    closeModal: function() {
        this.show = false;
        document.body.classList.remove('overflow-y-hidden');
    },

    behavior: {
        ['x-show']() {
            return this.show;
        },
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
}" x-bind="behavior" x-cloak
    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <!-- modal container -->
    <div class="{{ $containerClasses }}">

        <!-- modal window -->
        <div x-show="show" @click.away="closeModal" class="{{ $windowClasses }}"
            x-transition:enter="{{ $animation_enter }}" x-transition:enter-start="{{ $animation_enter_start }}"
            x-transition:enter-end="{{ $animation_enter_end }}" x-transition:leave="{{ $animation_leave }}"
            x-transition:leave-start="{{ $animation_leave_start }}" x-transition:leave-end="{{ $animation_leave_end }}">

            <!-- modal header -->
            @isset($header)
                <div {{ $header->attributes->class([$headerClasses]) }}>
                    {{ $header }}
                    @if ($header->attributes->has('defaultClose') && $header->attributes->get('defaultClose'))
                        <button type="button" class="{{ $headerCloseBtnClasses }}" x-on:click="closeModal">
                            &times;
                        </button>
                    @endif
                </div>
            @else
                <div class="flex-none flex justify-between items-center rounded-t-lg px-5 border-b">
                    <div class="flex items-center font-bold">{{ $titleText ?? '' }}</div>
                    <button type="button" class="{{ $headerCloseBtnClasses }}" x-on:click="closeModal">
                        &times;
                    </button>
                </div>
            @endisset

            <!-- modal body -->
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

            <!-- modal footer -->
            @isset($footer)
                <div {{ $footer->attributes->class([$footerClasses]) }}>
                    {{ $footer ?? '' }}
                    @if ($footer->attributes->has('defaultClose') && $footer->attributes->get('defaultClose'))
                        <button type="button" class="{{ $footerCloseBtnClasses }}" x-on:click="closeModal">
                            Close
                        </button>
                    @endif
                </div>
            @else
                <div class="{{ $footerClasses }}">
                    {{ $footer ?? '' }}
                    <button type="button" class="{{ $footerCloseBtnClasses }}" x-on:click="closeModal">
                        Close
                    </button>
                </div>
            @endisset
        </div>
    </div>
</div>
