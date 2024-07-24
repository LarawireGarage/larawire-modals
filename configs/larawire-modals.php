<?php


return [

    /*
    |---------------------------------------------------------------------------
    | Class Namespace
    |---------------------------------------------------------------------------
    |
    | This value sets the root class namespace for Livewire component classes in
    | your application. This value will change where component auto-discovery
    | finds components. It's also referenced by the file creation commands.
    |
    */

    'class_namespace'           => 'App\\Livewire\\Modals',

    /*
    |---------------------------------------------------------------------------
    | View Path
    |---------------------------------------------------------------------------
    |
    | This value is used to specify where Livewire component Blade templates are
    | stored when running file creation commands like `artisan make:livewire`.
    | It is also used if you choose to omit a component's render() method.
    |
    */

    'view_path'                 => resource_path('views/livewire/modals'),

    /*
    |---------------------------------------------------------------------------
    | Reset Before Show
    |---------------------------------------------------------------------------
    |
    | Reset Modal variables before show the modal.
    |
    */
    'resetBeforeShow'           => true,

    /*
    |---------------------------------------------------------------------------
    | Reset Validation Before Show
    |---------------------------------------------------------------------------
    |
    | Reset validation errors before show the modal.
    |
    */
    'resetValidationBeforeShow' => true,

    /*
    |---------------------------------------------------------------------------
    | Theme
    |---------------------------------------------------------------------------
    |
    | Modal Theme
    |
    | Supported values - bootstrap, tailwind
    |
    */
    'theme'                     => 'bootstrap',

    /*
    |---------------------------------------------------------------------------
    | Theme Classes
    |---------------------------------------------------------------------------
    |
    | CSS classes for main sections of the modal
    |
    | Supported values - bootstrap, tailwind
    |
    */
    'theme-classes'             => [
        'bootstrap' => [
            'backdropClasses'       => 'modal fade',
            'containerClasses'      => 'modal-dialog',
            'windowClasses'         => 'modal-content',
            'headerClasses'         => 'modal-header',
            'headerCloseBtnClasses' => 'btn-close btn-dark',
            'bodyClasses'           => 'modal-body',
            'footerClasses'         => 'modal-footer',
            'footerCloseBtnClasses' => 'btn btn-secondary',
        ],
        'tailwind'  => [
            'backdropClasses'       => 'fixed inset-0 z-50 backdrop-blur-sm bg-gray-800/30 text-gray-900 w-full h-screen overflow-y-auto transform transition-all bg-red-300',
            'containerClasses'      => 'w-3/5 h-fit p-5 md:p-14',
            'windowClasses'         => 'rounded-lg bg-white text-black dark:bg-gray-900 dark:text-gray-100 transform transition-all',
            'headerClasses'         => 'flex-none flex justify-between items-center rounded-t-lg px-5 border-b',
            'headerCloseBtnClasses' => 'text-3xl py-2 hover:text-red-600',
            'bodyClasses'           => 'grow py-2 px-5',
            'footerClasses'         => 'flex-none self-end w-full h-fit rounded-b-lg border-t px-5 py-3 text-end',
            'footerCloseBtnClasses' => 'border bg-gray-400 text-black px-2 py-1 rounded-lg hover:bg-gray-800 hover:text-gray-100',
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Animation
    |---------------------------------------------------------------------------
    |
    | Modal Animation style.
    | Only for Tailwind theme. For Bootstrap slide-down style fixed for now.
    |
    | Supported values - slide-down, scale-up
    |
    */
    'animation'                 => 'slide-down',

    /*
    |---------------------------------------------------------------------------
    | Animation Classes
    |---------------------------------------------------------------------------
    |
    | Animation classes for the modal. (Tailwind theme only)
    | Note: Only for Tailwind. Bootstrap use their own styles for animation.
    |
    */
    'animation-classes'         => [
        'scale-up'   => [
            'enter'       => "ease-out duration-300",
            'enter-start' => "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95",
            'enter-end'   => "opacity-100 translate-y-0 sm:scale-100",
            'leave'       => "ease-in duration-200",
            'leave-start' => "opacity-100 translate-y-0 sm:scale-100",
            'leave-end'   => "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95",
        ],
        'slide-down' => [
            'enter'       => "transition ease-out duration-300",
            'enter-start' => "opacity-0 -translate-y-8 transform",
            'enter-end'   => "opacity-100 translate-y-0 transform",
            'leave'       => "transition ease-out duration-300",
            'leave-start' => "opacity-100 translate-y-0 transform",
            'leave-end'   => "opacity-0 -translate-y-8 transform",
        ],
    ],
];