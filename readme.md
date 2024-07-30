# Modal Dialogs with Livewire 3

👉 For Backend Coding Enjoyers 😉

Create modal dialog easily with laravel project with livewire 3 + Alpinejs & manage modal dialog as livewire component.
> Still on alpha version

## Installation

```
composer require larawire-garage/larawire-modals
```

#### publish configurations

```
php artisan vendor:publish --tag=larawire-modals-configs
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


If you are using Livewire full page component for main pages.

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
Modal component has $modal public variable containing modal options.

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