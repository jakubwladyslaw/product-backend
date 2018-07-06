# jakub-product-backend



## Install

Simply add the following line to your `composer.json` and run install/update:
           
           require {
                "jakubwladyslaw/product-backend": "dev-master"
           }
          "repositories": [
            {
              "type": "vcs",
              "url": "https://github.com/jakubwladyslaw/product-backend"
            }
          ],
## Configuration

You will need to add the service provider to your `config/app.php`:

```php
'providers' => array(
  Jakub\ProductFrontend\ProductBackendServiceProvider::class
)

```
And make migration
```
    php artisan migrate 
```
    