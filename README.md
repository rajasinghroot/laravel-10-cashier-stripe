## About Application
   - This application has been implemented for the demo purpose. It contains simple checkout functionality with stripe payment (Laravel Cashier Stripe).


## Application setup in localhost/server
   - Clone the project files.
       - git clone git@github.com:rajasinghroot/laravel-10-cashier-stripe.git <project_folder_name>


   - Move on to the project main folder.
       - cd <project_folder_name>


   - Install required dependencies using composer
       - composer install


   - Create stripe account and update stripe required keys in environment file.
       - STRIPE_KEY=publishable-key
       - STRIPE_SECRET=secret-key
       - CASHIER_CURRENCY=usd


   - Run the database migrations
       - php artisan migrate


   - Run the database seeder
       - php artisan db:seed


   - For testing and easy starting application, just run below,
       - php artisan serve


## Application contains following features
   - Bootstrap UI with in-built auth functionality.  
   - Product seeder.
   - Factory for Product model.
   - Migrations for Product and Orders tables.
   - Having custom behavior. That is Model 'Accessor' for displaying product price with dollar symbol in the product page.
   - Encryption/Decryption for product-id to handle the checkout page.
   - Client side validation using jQuery at checkout page form.
   - Loaded Stripe secure Input fields.
   - Data-table integrated for 'My orders' screen.


Happy coding!!!


