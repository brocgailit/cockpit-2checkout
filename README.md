# Checkout for Cockpit CMS

## Installation
Install Cockpit CMS addon by extracting to the addons folder (/addons/2Checkout)

### Install Dependencies

```
$ cd /addons/2Checkout
$ composer install
```

### Add Checkout Config

```
checkout:
    vendorCode: YOUR_VENDOR_CODE
    sellerId: YOUR_ACCOUNT_ID
    secretKey: YOUR_SECRET_KEY
```