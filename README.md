# E-commerce - Laravel 10

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
- [App Directory Structure](#app-directory-structure)

## Requirements

Ensure that your system meets the following requirements:

- **PHP**: Version 8.1 or higher
- [astrotomic/laravel-translatable](https://packagist.org/packages/astrotomic/laravel-translatable): Version ^11.12
- [barryvdh/laravel-dompdf](https://packagist.org/packages/barryvdh/laravel-dompdf): Version ^2.0
- [guzzlehttp/guzzle](https://packagist.org/packages/guzzlehttp/guzzle): Version ^7.2
- [laravel/framework](https://packagist.org/packages/laravel/framework): Version ^10.10
- [laravel/passport](https://packagist.org/packages/laravel/passport): Version ^11.8
- [laravel/sanctum](https://packagist.org/packages/laravel/sanctum): Version ^3.2
- [laravel/telescope](https://packagist.org/packages/laravel/telescope): Version ^4.16
- [laravel/tinker](https://packagist.org/packages/laravel/tinker): Version ^2.8
- [spatie/laravel-medialibrary](https://packagist.org/packages/spatie/laravel-medialibrary): Version ^10.12
- [spatie/laravel-permission](https://packagist.org/packages/spatie/laravel-permission): Version ^5.11
- [stevebauman/location](https://packagist.org/packages/stevebauman/location): Version ^7.0

### Development Requirements

For development, you will also need the following packages:

- [fakerphp/faker](https://packagist.org/packages/fakerphp/faker): Version ^1.9.1
- [laravel/pint](https://packagist.org/packages/laravel/pint): Version ^1.0
- [laravel/sail](https://packagist.org/packages/laravel/sail): Version ^1.18
- [mockery/mockery](https://packagist.org/packages/mockery/mockery): Version ^1.4.4
- [nunomaduro/collision](https://packagist.org/packages/nunomaduro/collision): Version ^7.0
- [pestphp/pest](https://packagist.org/packages/pestphp/pest): Version ^2.0
- [pestphp/pest-plugin-laravel](https://packagist.org/packages/pestphp/pest-plugin-laravel): Version ^2.0
- [spatie/laravel-ignition](https://packagist.org/packages/spatie/laravel-ignition): Version ^2.0

## Autoload Configuration

Ensure the following autoload configurations are set in your `composer.json` file:

```yaml
"autoload" {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/"
    },
},
"autoload-dev": {
    "psr-4": {
        "Tests\\": "tests/"
    }
}
```

## Installation

To get started with E-commerce, follow these steps:

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/abdulrhmanak213/e-commerce-laravel-10.git
    cd e-commerce-laravel-10
    ```

2. **Install Dependencies:**

    ```bash
    composer install
    ```

3. **Copy the Environment File:**

    ```bash
    cp .env.example .env
    ```

4. **Generate the Application Key:**

    ```bash
    php artisan key:generate
    ```

5. **Configure the Database:**

   Update the `.env` file with your database connection details:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=your-database-host
    DB_PORT=your-database-port
    DB_DATABASE=your-database-name
    DB_USERNAME=your-database-username
    DB_PASSWORD=your-database-password
    ```

6. **Install Passport:**

    ```bash
    php artisan passport:install
    ```

   This will create the encryption keys needed to generate secure access tokens.

7. **Run Migrations and Seed the Database:**

    ```bash
    php artisan migrate --seed
    ```

8. **Link the Storage Folder:**

    ```bash
    php artisan storage:link
    ```

9. **Start the Development Server:**

    ```bash
    php artisan serve
    ```

   e-commerce-laravel-10 should now be running on [http://localhost:8000](http://localhost:8000).

10. **Access the API Documentation:**

    The API documentation is available at [http://localhost:8000/docs/api](http://localhost:8000/docs/api). Explore and
    test the available endpoints.

11. **Explore e-commerce-laravel-10 Experience:**

    Open your browser and navigate to [http://localhost:8000](http://localhost:8000) to explore e-commerce-laravel-10.

For any additional configuration or customization, refer to the [Configuration](#configuration) section.

## Database

e-commerce-laravel-10 uses a relational database to store its data (MySql).

## Usage

### User Role

#### 1. Review Products

- As a **User**, you can browse and review various Products listed on the e-commerce.
- Access Products details, including descriptions, images.

#### 2. Add Product to Cart

- Save your products to your personal cart on  the e-commerce.

#### 3. Checkout and pay your products

- you can checkout and pay with strip to get your products

### Admin Role

#### 1. Admin Dashboard

- The **Admin** dashboard provides comprehensive control over the e-commerce.
- Manage and oversee all aspects of the platform, including users, orders, invoices, products and overall system configuration.

### Access the API Documentation

- our e-commerce offers an API that developers can explore and integrate. The API documentation is available
  at [http://localhost:8000/docs/api](http://localhost:8000/docs/api).


## API Endpoints

e-commerce provides a comprehensive API for interacting with various features. The API documentation is available
for easy reference. To explore the API endpoints and understand how to interact with them, follow these steps:

1. Ensure your e-commerce Laravel backend is running. If not, start the development server:

    ```bash
    php artisan serve
    ```

2. Open your browser and navigate to [APP_URL/docs/api](APP_URL/docs/api).

   This will open the Swagger-based API documentation, allowing you to explore and test the available endpoints.

Feel free to test different API requests, view response structures, and understand how to interact with e-commerce
programmatically. For any specific details about the API or if you encounter any issues, refer to the API documentation
for more in-depth information.


## App Directory Structure:

``` 
📦app
 ┣ 📂Console
 ┃ ┣ 📂Commands
 ┃ ┃ ┣ 📜SaleAlert.php
 ┃ ┃ ┗ 📜UpdateCurrency.php
 ┃ ┗ 📜Kernel.php
 ┣ 📂Exceptions
 ┃ ┗ 📜Handler.php
 ┣ 📂Http
 ┃ ┣ 📂Controllers
 ┃ ┃ ┣ 📂Admin
 ┃ ┃ ┃ ┣ 📂Admin
 ┃ ┃ ┃ ┃ ┗ 📜AdminController.php
 ┃ ┃ ┃ ┣ 📂Auth
 ┃ ┃ ┃ ┃ ┣ 📜LoginController.php
 ┃ ┃ ┃ ┃ ┗ 📜LogoutController.php
 ┃ ┃ ┃ ┣ 📂Category
 ┃ ┃ ┃ ┃ ┗ 📜CategoryController.php
 ┃ ┃ ┃ ┣ 📂City
 ┃ ┃ ┃ ┃ ┗ 📜CityController.php
 ┃ ┃ ┃ ┣ 📂Color
 ┃ ┃ ┃ ┃ ┗ 📜ColorController.php
 ┃ ┃ ┃ ┣ 📂Country
 ┃ ┃ ┃ ┃ ┗ 📜CountryController.php
 ┃ ┃ ┃ ┣ 📂Currency
 ┃ ┃ ┃ ┃ ┗ 📜CurrencyController.php
 ┃ ┃ ┃ ┣ 📂HeroImage
 ┃ ┃ ┃ ┃ ┗ 📜HeroImageController.php
 ┃ ┃ ┃ ┣ 📂Order
 ┃ ┃ ┃ ┃ ┣ 📜InvoiceController.php
 ┃ ┃ ┃ ┃ ┗ 📜OrderController.php
 ┃ ┃ ┃ ┣ 📂Policy
 ┃ ┃ ┃ ┃ ┗ 📜PolicyController.php
 ┃ ┃ ┃ ┣ 📂Product
 ┃ ┃ ┃ ┃ ┗ 📜ProductController.php
 ┃ ┃ ┃ ┣ 📂Profile
 ┃ ┃ ┃ ┃ ┗ 📜ProfileController.php
 ┃ ┃ ┃ ┣ 📂ReviewRate
 ┃ ┃ ┃ ┃ ┗ 📜ReviewRateController.php
 ┃ ┃ ┃ ┣ 📂Sale
 ┃ ┃ ┃ ┃ ┗ 📜SaleController.php
 ┃ ┃ ┃ ┣ 📂Term
 ┃ ┃ ┃ ┃ ┗ 📜TermController.php
 ┃ ┃ ┃ ┗ 📂User
 ┃ ┃ ┃ ┃ ┗ 📜UserController.php
 ┃ ┃ ┣ 📂User
 ┃ ┃ ┃ ┣ 📂Auth
 ┃ ┃ ┃ ┃ ┣ 📜LoginController.php
 ┃ ┃ ┃ ┃ ┣ 📜RegisterController.php
 ┃ ┃ ┃ ┃ ┗ 📜ResetPasswordController.php
 ┃ ┃ ┃ ┣ 📂Cart
 ┃ ┃ ┃ ┃ ┗ 📜CartController.php
 ┃ ┃ ┃ ┣ 📂Order
 ┃ ┃ ┃ ┃ ┗ 📜OrderController.php
 ┃ ┃ ┃ ┣ 📜CategoryController.php
 ┃ ┃ ┃ ┣ 📜CountryController.php
 ┃ ┃ ┃ ┣ 📜HeroImageController.php
 ┃ ┃ ┃ ┣ 📜ProductController.php
 ┃ ┃ ┃ ┣ 📜ReviewController.php
 ┃ ┃ ┃ ┗ 📜SubscriberController.php
 ┃ ┃ ┗ 📜Controller.php
 ┃ ┣ 📂Middleware
 ┃ ┃ ┣ 📜Authenticate.php
 ┃ ┃ ┣ 📜CheckCountry.php
 ┃ ┃ ┣ 📜CheckLanguage.php
 ┃ ┃ ┣ 📜Cors.php
 ┃ ┃ ┣ 📜EncryptCookies.php
 ┃ ┃ ┣ 📜PreventRequestsDuringMaintenance.php
 ┃ ┃ ┣ 📜RedirectIfAuthenticated.php
 ┃ ┃ ┣ 📜TrimStrings.php
 ┃ ┃ ┣ 📜TrustHosts.php
 ┃ ┃ ┣ 📜TrustProxies.php
 ┃ ┃ ┣ 📜ValidateSignature.php
 ┃ ┃ ┗ 📜VerifyCsrfToken.php
 ┃ ┣ 📂Requests
 ┃ ┃ ┣ 📂Admin
 ┃ ┃ ┃ ┣ 📂Admin
 ┃ ┃ ┃ ┃ ┗ 📜AdminRequest.php
 ┃ ┃ ┃ ┣ 📂Category
 ┃ ┃ ┃ ┃ ┗ 📜CategoryRequest.php
 ┃ ┃ ┃ ┣ 📂City
 ┃ ┃ ┃ ┃ ┗ 📜CityRequest.php
 ┃ ┃ ┃ ┣ 📂Color
 ┃ ┃ ┃ ┃ ┗ 📜ColorRequest.php
 ┃ ┃ ┃ ┣ 📂Country
 ┃ ┃ ┃ ┃ ┗ 📜CountryRequest.php
 ┃ ┃ ┃ ┣ 📂Currency
 ┃ ┃ ┃ ┃ ┗ 📜CurrencyRequest.php
 ┃ ┃ ┃ ┣ 📂HeroImage
 ┃ ┃ ┃ ┃ ┗ 📜HeroImageRequest.php
 ┃ ┃ ┃ ┣ 📂Order
 ┃ ┃ ┃ ┃ ┗ 📜ChangeOrderStatusRequest.php
 ┃ ┃ ┃ ┣ 📂Policy
 ┃ ┃ ┃ ┃ ┣ 📜PolicyRequest.php
 ┃ ┃ ┃ ┃ ┗ 📜TermRequest.php
 ┃ ┃ ┃ ┣ 📂Product
 ┃ ┃ ┃ ┃ ┗ 📜ProductRequest.php
 ┃ ┃ ┃ ┣ 📂Profile
 ┃ ┃ ┃ ┃ ┗ 📜ChangePassswordRequest.php
 ┃ ┃ ┃ ┣ 📂Sale
 ┃ ┃ ┃ ┃ ┗ 📜SaleRequest.php
 ┃ ┃ ┃ ┗ 📂User
 ┃ ┃ ┃ ┃ ┗ 📜UserRequest.php
 ┃ ┃ ┣ 📂User
 ┃ ┃ ┃ ┣ 📂Auth
 ┃ ┃ ┃ ┃ ┣ 📜CheckResetPasswordRequest.php
 ┃ ┃ ┃ ┃ ┣ 📜EditPasswordRequest.php
 ┃ ┃ ┃ ┃ ┣ 📜LoginRequest.php
 ┃ ┃ ┃ ┃ ┣ 📜RegisterRequest.php
 ┃ ┃ ┃ ┃ ┗ 📜ResetPasswordRequest.php
 ┃ ┃ ┃ ┣ 📂Cart
 ┃ ┃ ┃ ┃ ┣ 📜addProductRequest.php
 ┃ ┃ ┃ ┃ ┣ 📜removeProductRequest.php
 ┃ ┃ ┃ ┃ ┗ 📜ShowCartRequest.php
 ┃ ┃ ┃ ┣ 📂Order
 ┃ ┃ ┃ ┃ ┗ 📜CheckOutRequest.php
 ┃ ┃ ┃ ┣ 📜ReviewRequest.php
 ┃ ┃ ┃ ┗ 📜SubscribeRequest.php
 ┃ ┃ ┣ 📜ContactUsRequest.php
 ┃ ┃ ┗ 📜SearchRequest.php
 ┃ ┣ 📂Resources
 ┃ ┃ ┣ 📂Admin
 ┃ ┃ ┃ ┣ 📂Admin
 ┃ ┃ ┃ ┃ ┗ 📜AdminResource.php
 ┃ ┃ ┃ ┣ 📂Categry
 ┃ ┃ ┃ ┃ ┗ 📜CategoryResource.php
 ┃ ┃ ┃ ┣ 📂City
 ┃ ┃ ┃ ┃ ┗ 📜CityResource.php
 ┃ ┃ ┃ ┣ 📂Color
 ┃ ┃ ┃ ┃ ┗ 📜ColorResource.php
 ┃ ┃ ┃ ┣ 📂Country
 ┃ ┃ ┃ ┃ ┣ 📜CountryIndexResource.php
 ┃ ┃ ┃ ┃ ┗ 📜CountryResource.php
 ┃ ┃ ┃ ┣ 📂Currency
 ┃ ┃ ┃ ┃ ┗ 📜CurrencyResource.php
 ┃ ┃ ┃ ┣ 📂HeroImage
 ┃ ┃ ┃ ┃ ┗ 📜HeroImageResource.php
 ┃ ┃ ┃ ┣ 📂Order
 ┃ ┃ ┃ ┃ ┣ 📜InvoiceIndexResource.php
 ┃ ┃ ┃ ┃ ┣ 📜InvoiceResource.php
 ┃ ┃ ┃ ┃ ┣ 📜OrderIndexResource.php
 ┃ ┃ ┃ ┃ ┣ 📜OrderProductResource.php
 ┃ ┃ ┃ ┃ ┗ 📜OrderResource.php
 ┃ ┃ ┃ ┣ 📂Product
 ┃ ┃ ┃ ┃ ┣ 📜ProductIndexResource.php
 ┃ ┃ ┃ ┃ ┗ 📜ProductResource.php
 ┃ ┃ ┃ ┣ 📂ReviewRate
 ┃ ┃ ┃ ┃ ┣ 📜ReviewRatesIndexResource.php
 ┃ ┃ ┃ ┃ ┗ 📜ReviewRatesResource.php
 ┃ ┃ ┃ ┣ 📂Sale
 ┃ ┃ ┃ ┃ ┗ 📜SaleResource.php
 ┃ ┃ ┃ ┗ 📂User
 ┃ ┃ ┃ ┃ ┣ 📜UserIndexResource.php
 ┃ ┃ ┃ ┃ ┗ 📜UserResource.php
 ┃ ┃ ┗ 📂User
 ┃ ┃ ┃ ┣ 📂Cart
 ┃ ┃ ┃ ┃ ┣ 📜CartProductResource.php
 ┃ ┃ ┃ ┃ ┗ 📜CartResource.php
 ┃ ┃ ┃ ┣ 📂Category
 ┃ ┃ ┃ ┃ ┣ 📜IndexHomeResource.php
 ┃ ┃ ┃ ┃ ┗ 📜SelectedResource.php
 ┃ ┃ ┃ ┣ 📂Color
 ┃ ┃ ┃ ┃ ┗ 📜IndexResource.php
 ┃ ┃ ┃ ┣ 📂Country
 ┃ ┃ ┃ ┃ ┣ 📜CityResource.php
 ┃ ┃ ┃ ┃ ┗ 📜CountryResource.php
 ┃ ┃ ┃ ┣ 📂Order
 ┃ ┃ ┃ ┃ ┣ 📜CheckOutOrderResource.php
 ┃ ┃ ┃ ┃ ┣ 📜OrderResource.php
 ┃ ┃ ┃ ┃ ┗ 📜ShowResource.php
 ┃ ┃ ┃ ┣ 📂Product
 ┃ ┃ ┃ ┃ ┣ 📜IndexResource.php
 ┃ ┃ ┃ ┃ ┗ 📜ProductResource.php
 ┃ ┃ ┃ ┣ 📂Size
 ┃ ┃ ┃ ┃ ┗ 📜IndexResource.php
 ┃ ┃ ┃ ┗ 📜ReviewResource.php
 ┃ ┣ 📂Traits
 ┃ ┃ ┣ 📜HttpResponse.php
 ┃ ┃ ┗ 📜translateStatus.php
 ┃ ┗ 📜Kernel.php
 ┣ 📂Jobs
 ┃ ┣ 📜ContactUs.php
 ┃ ┣ 📜SendCodeJob.php
 ┃ ┣ 📜SendInvoiceMailJob.php
 ┃ ┗ 📜VerificationCodeJob.php
 ┣ 📂Mail
 ┃ ┣ 📜ContactUsMail.php
 ┃ ┣ 📜SaleAlertMail.php
 ┃ ┣ 📜SendCodeMail.php
 ┃ ┗ 📜SendVerificationMail.php
 ┣ 📂Models
 ┃ ┣ 📜Cart.php
 ┃ ┣ 📜CartProduct.php
 ┃ ┣ 📜Category.php
 ┃ ┣ 📜CategoryTranslation.php
 ┃ ┣ 📜City.php
 ┃ ┣ 📜CityTranslation.php
 ┃ ┣ 📜Color.php
 ┃ ┣ 📜Country.php
 ┃ ┣ 📜CountryTranslation.php
 ┃ ┣ 📜Currency.php
 ┃ ┣ 📜HeroImage.php
 ┃ ┣ 📜Invoice.php
 ┃ ┣ 📜Order.php
 ┃ ┣ 📜OrderProduct.php
 ┃ ┣ 📜Policy.php
 ┃ ┣ 📜PolicyTranslation.php
 ┃ ┣ 📜Product.php
 ┃ ┣ 📜ProductSize.php
 ┃ ┣ 📜ProductTranslation.php
 ┃ ┣ 📜ReviewRate.php
 ┃ ┣ 📜Sale.php
 ┃ ┣ 📜Subscriber.php
 ┃ ┣ 📜Term.php
 ┃ ┣ 📜TermTranslation.php
 ┃ ┗ 📜User.php
 ┣ 📂Providers
 ┃ ┣ 📜AppServiceProvider.php
 ┃ ┣ 📜AuthServiceProvider.php
 ┃ ┣ 📜BroadcastServiceProvider.php
 ┃ ┣ 📜EventServiceProvider.php
 ┃ ┣ 📜RouteServiceProvider.php
 ┃ ┗ 📜TelescopeServiceProvider.php
 ┣ 📂Services
 ┃ ┣ 📜FilterService.php
 ┃ ┗ 📜PriceService.php
 ┗ 📂Traits
 ┃ ┗ 📜OtpTrait.php
```
