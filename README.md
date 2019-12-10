# Checkout for Cockpit CMS

## Installation
Install Cockpit CMS addon by extracting to the addons folder (/addons/Checkout)

### Install Dependencies

```
$ cd /addons/Checkout
$ composer install
```

### Add Checkout Config

```
checkout:
    privateKey: YOUR_PRIVATE_KEY
    sellerId: YOUR_ACCOUNT_ID
    mode: [sandbox|production] (Default: sandbox)
```