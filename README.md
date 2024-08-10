# Modal Dialogs with Livewire 3

👉 For Backend Coding Enjoyers 😉

Create modal dialog easily with laravel project with livewire 3 + Alpinejs & manage modal dialog as livewire component.
> Still on beta version

- [Installation](#installation)
- [Setup](#setup)
    - [Publish Configurations](#publish-configurations)
    - [Themes](#themes)
        - [Bootstrap Installation](#bootstrap-installation)
        - [Tailwind Installation](#tailwind-installation)
        - [Change Theme](#change-theme)
- [Usage](#usage)
    - [Create Modal](#usage)
    - [Show Modal](#to-show-the-modal-dialog)
    - [Hide Modal](#to-close-the-modal-dialog)
    - [Options](#options)
        - [Available Options](#available-options)
    - [Methods](#methods)
- [Customizaion](#customizaion)
- [Animation](#animation)
- [Not Working ?](#not-working-correctly)

# Installation

```
composer require larawire-garage/larawire-modals
```

# Setup
#### publish configurations

```
php artisan vendor:publish --tag=larawire-modals-configs
``` 
 
## Themes
Currently supports 2 themes.
* Bootstrap
* Tailwind

### <ins>Bootstrap Installation</ins>
You can use CDN Link to apply bootstrap.</br>
If you are using package managers like `npm` use [Bootstrap Documentation](https://getbootstrap.com/docs/5.3/getting-started/download/#npm)  to install. 
When [Importing Bootstrap](https://getbootstrap.com/docs/5.3/getting-started/vite/#import-bootstrap) add below code to `app.js` file.

```js
// Import all of Bootstrap's JS
import * as bootstrap from 'bootstrap'

window.bootstrap = bootstrap; // 👈 required 
```

### <ins>Tailwind Installation</ins>
You can use CDN Link to apply Tailwindcss.</br>
If you are using package managers like `npm` use [Tailwindcss Documentation](https://tailwindcss.com/docs/installation)  to install. Then Add below code to `tailwind.config.js` file.
```js
/** @type {import('tailwindcss').Config} */
module.exports = { 
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/larawire-garage/larawire-modals/**/*.blade.php", // 👈 Add this line
    ], 
    //...
}
```
If not working correctly? [Check Here](#not-working-correctly)
### <ins>Change Theme</ins>
You can add theme your proejct used in `larawire-modals` config file. 
```php
// configs/larawire-modals.php
return [
    'theme' => 'bootstrap',
    // OR
    'theme' => 'tailwind',

    // ....
];
```
Also you can change theme in your modal variable inside the modal component.
```php
// app/Livewire/MODAL_PATH/MYMODAL.php

class MYMODAL extends ModalComponent{
    public array $modal = [
        'theme' => 'bootstrap',
        // OR
        'theme' => 'tailwind',
        //...
    ];
}
```

# Usage
create modal component using below command.
```
php artisan make:modal MyModal
```

Now you can use modal component like regular livewire component. 
By default this command create component:
* `Class` : app/Livewire/Modals
* `View` : resources/views/livewire/modals 

directories. You can change it in the `larawire-modals` config file. 
```php
// configs/larawire-modals.php
return [
    'class_namespace' => 'App\\Livewire\\Modals',
     
    'view_path' => resource_path('views/livewire/modals'),

    // ....
];
```

### To show the modal dialog
```php
$this->dispatch('show')->to(MyModal::class);
```
### To close the modal dialog
* From other component:
```php
$this->dispatch('close')->to(MyModal::class);
```
* From modal component:
```php
$this->dispatch('close')->self();
//or
$this->closeModal();
```

## Options
Modal component has `$modal` public variable containing modal options.

```php
public array $modal = [
    'id' => 'my-modal',
    'title' => 'My Modal',
    //...
];
```

### Available Options
* `id` - Modal ID
* `title` - Modal title text on the header
* `theme` - Theme using in the project (bootstrap or tailwind). Can be defind in the larawire-modals config file
* `resetBeforeShow` - if this is true, public variables in the modal component automatically reset before show the modal. Can be defind in the larawire-modals config file
* `resetValidationBeforeShow` - if this is true, Reset the validation error bag of modal component automatically before show the modal. Can be defind in the larawire-modals config file


## Methods
* `showModal()` - Show the modal dialog
* `closeModal()` - Close the modal dialog

You can define:
* `beforeShow()` - Runs before show the modal dialog
* `beforeClose()` - Runs before close the modal dialog

# Customizaion
In the larawire-modals config file you can change classes of the containers of the modal. Also can change in the modal variable of the modal component.

```php
// configs/larawire-modals.php

return [
    // ...
     'theme-classes'             => [
        'bootstrap' => [
            'backdropClasses'       => '',
            'containerClasses'      => '',
            'windowClasses'         => '',
            'headerClasses'         => '',
            'headerCloseBtnClasses' => '',
            'bodyClasses'           => '',
            'footerClasses'         => '',
            'footerCloseBtnClasses' => '',
        ],
        'tailwind'  => [
            'backdropClasses'       => '',
            'containerClasses'      => '',
            'windowClasses'         => '',
            'headerClasses'         => '',
            'headerCloseBtnClasses' => '',
            'bodyClasses'           => '',
            'footerClasses'         => '',
            'footerCloseBtnClasses' => '',
        ],
    ],
];
``` 
```php
// app/Livewire/MODAL_PATH/MYMODAL.php

class MYMODAL extends ModalComponent{
    public array $modal = [
        /** available if needs to customize */
        'backdropClasses'       => '',
        'containerClasses'      => '',
        'windowClasses'         => '',
        'headerClasses'         => '',
        'headerCloseBtnClasses' => '',
        'bodyClasses'           => '',
        'footerClasses'         => '',
        'footerCloseBtnClasses' => '',
        //...
    ];
}
``` 

Changing classes still not working for you ?</br>
To customize appearance of the modal, you can publish the views and edit it.
```
php artisan vendor:publish --tag=larawire-modals-views
```

# Animation

Also you can change animation of the modal.

`Bootstrap Theme` :<br>
In bootstrap, follow bootstrap documentation to change the modal animation. 

`Tailwind Theme` :<br>
In tailwind theme under `animation` key in them larawire-modals config file.
Also you can change it in the modal variable in the modal component.

```php
// app/Livewire/MODAL_PATH/MYMODAL.php

class MYMODAL extends ModalComponent{
    public array $modal = [
        /** Only for tailwind */
        'animation' => 'slide-down', // <==  slide-down, scale-up
        //...
    ];
}
```
For deep customize animation classes check under `animation-classes` key in larawire-modals config file.
 In Tailwind theme, modal use alpinejs & tailwindcss animation classes to animate modals. 

## Not Working Correctly
#### Tailwind
In case modal not working correctly,
Eg: 
   * Modal not rendering correctly
   * Animation not working

Add below array of classes to `safelist` array

_If you change the classes in config file or in class modal variable, that classes also need to include here_
```js
/** @type {import('tailwindcss').Config} */
module.exports = { 
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/larawire-garage/larawire-modals/**/*.blade.php", // 👈 Add this line
    ], 

    /**
     * ⚠️⚠️⚠️ If in-case (content path) 👆 not working.⚠️⚠️⚠️ 
     * 👇 Add this block
     */ 
    safelist: [ 
        'backdrop-blur-sm',
        'bg-white', 'bg-gray-400', 'bg-gray-800/30', 'bg-red-300',
        'border', 'border-b', 'border-t',
        'dark:bg-gray-900', 'dark:text-gray-100',
        'duration-200', 'duration-300',
        'ease-in', 'ease-out',
        'fixed', 'inset-0',
        'flex', 'flex-none', 'grow', 'items-center', 'justify-between', 'self-end',
        'font-bold', 
        'h-fit', 'h-screen',
        'hover:bg-gray-800', 'hover:text-gray-100', 'hover:text-red-600',
        'opacity-0', 'opacity-100',
        'overflow-y-auto', 'overflow-y-hidden',
        'p-5', 'px-2', 'px-5', 'py-1', 'py-2', 'py-3', 'md:p-14',
        'rounded-b-lg', 'rounded-lg', 'rounded-t-lg',
        'sm:scale-100', 'sm:scale-95',
        'text-3xl', 'text-black', 'text-end', 'text-gray-900',
        'transform',
        'transition', 'transition-all',
        'translate-y-0', 'translate-y-4', 'sm:translate-y-0', '-translate-y-8',
        'w-full', 'w-3/5',
        'z-50',
    ]
    //...
}
```

 !!! :tada::tada::tada: Enjoy :tada::tada::tada: !!!