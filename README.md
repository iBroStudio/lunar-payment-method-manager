# Lunar Payment Method Manager

Package to manage payment methods in Lunar.

**FEATURES**:
- manage payment gateways with credentials securely saved in database
- manage payment methods
- manage and save securely customers payment methods

**WORK IN PROGRESS - NOT READY TO USE**

## Installation

```bash
composer require ibrostudio/lunar-payment-method-manager
```

```bash
php artisan lunar-payment-method-manager:install
```
Register plugin in panel
```php
protected function plugins(): array
    {
        return [
            \IBroStudio\PaymentMethodManager\PaymentMethodManagerPlugin::make(),
        ];
    }
```
