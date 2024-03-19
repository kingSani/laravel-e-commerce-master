
<p align="center">
<img src="readme images/app-logo.png" width="400">
</p>

<p align="center">
Your #1 shopping website!
</p>

## About

K-Clothing is an online shopping mall where customers can order products at an affordable price. The customer must be registered before they can buy a product. An admin user can add or delete products from the admin section. The admin can also view all registered users and their orders. 

## Description
- The application is built with Laravel framework. 
- It uses user authentication with different user roles, admin and customer. 
- Some parts of the website can be viewed without logging in but others require authentication. 
- Users that register will automatically be given the customer role. 
- A default admin is created the first time application is installed. 
- An admin can upgrade a customer to an admin if it satisfies some requirements. 
- An admin can add, edit and delete products.
- An admin can also view all orders and customers registered.
- Customers can view added products and add them to their cart.
- Customers can add or reduce quantity of products in cart.
- They can then checkout and place an order of the products in their cart.
- They can view their profile to see past orders.

## New Features
- Customer can search for products.
- Customers can log in using facebook or github.
- The Admin now uploads product image instead of providing url.
- Authenticated Customers can view number of items in cart at a glance in the navbar.
- Customers can use the forgot password feature to change password.
- Products are listed out in pages when they reach a certain number.
- Admin can set products to be out of stock. This means the product cannot be added to cart or placed in an order.
- Navbar text replaced with icons.
- Customers can chat with the Admin(s) inside the app in case of an issue.
- Customers and Admin(s) receive emails for certain events.

## Technical Features
- Website uses multiple authentication middlewares for both customer and admin.
- The application is mobile responsive for every page.
- Application uses MySQL as database.
- Database uses multiple tables to store user and admin information.
- There are multiple foreign key constraints on users, products, orders and order_products tables.
- Website uses sessions to display information and errors.
- Website uses tailwind css for majority of the CSS styling.
- Website makes use of Components for faster development of common elements.
- Website uses laravel breeze template for initial basic authentication.
- Website uses table linking between users table and other tables.
- Website uses table relations for faster quering of related tables.
- Website makes use of all CRUD Operations.

## New Technical Features
- The application uses React to allow searching of products without page reload.
- The application uses laravel socialite to configure facebook and github login
- The website stores product images on server using the Storage driver.
- The website uses REACT to display number of items in cart for Customer pages when authenticated.
- The website uses caching to cache products and improve performance under heavy traffic.
- The website increased the api throttle to accomodate api requests.
- The website uses UUID for most tables to improve security.
- The website uses pusher js on the backend, pusher js and laravel echo on the front end for chatting.
- The website can send emails when necessary.

## Project Installation
Please check the official laravel installation guide for server requirements before you start.

Clone the repository and cd to the folder.

Install dependencies using [Composer](https://getcomposer.org/)

```
composer install
```
Install javascript dependencies using [npm](https://www.npmjs.com/)

```
npm install
```
Generate the necessary javascript files 

```
npm run dev
```
Copy the example env file and make the required configuration changes in the .env file

```
cp .env.example .env
```

Generate a new application key

```
php artisan key:generate
```

Link storage to public

```
php artisan storage:link
```

Run the databse migration (Set the database and admin configurations before migration)

```
php artisan migrate
```

Run tests to confirm successful configuration

```
php artisan test
```

In case of some tests failing, please run the following command and try running tests again.

```
php artisan config:clear
```

Seed the database with mock data

```
php artisan db:seed
```

Start the local development server.

```
php artisan serve
```
You can now access the website at [http://localhost:8000](http://localhost:8000)

## New/Advanced Usage of Product

- The user/customer is greeted at the landing page. At the top, there is a navigation bar to quickly access and navigate the website. 
<img src="readme advanced images/landing.png" width="99%" >

- The user can also choose to log in or register with facebook or github.
<img src="readme advanced images/login screen.png" width="99%" >
<img src="readme advanced images/register.png" width="99%" >

- The nav bar shows a user icon when they are logged in. It also shows the current number of item in cart. The customer care icon is displayed in the bottom right at every page for the authenticated customer.
<img src="readme advanced images/landing logged in.png" width="99%" >

- The customer can search for products in the navbar. There is no loading time because the searching is done in the client side. The user is taken to the product page for the product that is clicked.
<img src="readme advanced images/search no text.png" width="99%" >
<img src="readme advanced images/search with text.png" width="99%" >
<img src="readme advanced images/search not found.png" width="99%" >

<img src="readme advanced images/mobile navbar.png" width="99%" >
<img src="readme advanced images/mobile navbar search.png" width="99%" >

- The authenticad customer can use the customer care function and chat with the admin by sending messages.
<img src="readme advanced images/customer chat no message.png" width="99%" >
<img src="readme advanced images/customer chat with message.png" width="99%" >

- In the products page, the customer can view all products that are in stock or out of stock. The products are also displayed in pages when then reach a certain number.

<img src="readme advanced images/products page.png" width="99%" >
<img src="readme advanced images/app footer.png" width="99%" >

- In the Admin section, the customer care is also displayed in the bottom right corner. The admin can chat will all customers in the application. 

<img src="readme advanced images/admin chat.png" width="99%" >
<img src="readme advanced images/admin chat reply.png" width="99%" >
<img src="readme advanced images/admin chat other user.png" width="99%" >

- In the Admin products section, admin can view products that are in or out of stock. They can also upload the product image when adding or editing.

<img src="readme advanced images/admin products.png" width="99%" >
<img src="readme advanced images/admin product add.png" width="99%" >
<img src="readme advanced images/admin product edit.png" width="99%" >

## Project Testing
Run the test command to confirm the project is setup properly.

## Reflective Analysis
A couple of new features where used in this project, some of them will be discussed below.

- File upload was implemented to upload product images.
- Laravel socialite was used for facebook and github authentication.
- Email was configured for certain tasks.
- Pusher, echo and React was used to implement chatting.
- Searching. The website allows the customer to search for products in the search bar. The customer can search for a products name, type, colour, size and even price. Partial searches are also returned and the user can select the product if it is found. The searching feature was done using laravel and REACT. React is a client side javascript technology like Angular and Vue that allows for DOM manipulation without refreshing of page. As laravel mostly renders static pages a javascript technology was required to show products dynamically as they are being searched. Therefore the search bar and display of products were handled by React. In the initial version, the products table was indexed (the FULLTEXT index) so that searching was done in the server side. So the React front end will get the current text/value in the search bar and makes an api request to a controller that retrieves the list of products that match the value provided. The React component then renders the product list returned. But this approach had some shortcomings. The first being that the customer has to wait for the api call to be made, and for laravel to query the database before the list of products is displayed. Another one is that every time the user types or deletes a letter, the api request is being made. This led to an overflow of api requests that required the api throttle to be increased. This is still not a perfect solution as can be explained. If 5 users try to search for a product nameed "long sleeve t-shirt", which has 18 characters, 90 requests will be made in the space of 5 to 10 seconds only for searching. This seemed inconvenient. The solution found was to use client side searching. In this version, the React front end queries the database for all of products and it is stored. When the user wants to make a search, and starts typing, the React component implements the search (which is done using a package) and the result is returned almost immediately. This method is so much better as it eliminates the delay and the need to make lots of api calls. 