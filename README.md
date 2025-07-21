# E-Commerce API
This is a Laravel 10 RESTful API for a simple e-commerce system that supports:-
    - customer/ seller profile reviewing
    - product browsing
    - cart management
    - order placement
    - order cancellation with customer and seller roles.


## Features
- Customer registration & authentication (via Sanctum)
- Customer/ seller profile reviewing and filtering 
- Product browsing and filtering
- Shopping cart: add, edit, remove, view
- Order 
    - Order Placement:
        - Order from cart (CartTrxn as one unit, support multiple cart trxn and single)
        - Instant order (Multiple / Single)
    - Order cancellation:
        - Auto-cancel within 10 minutes after purchase 
        - Seller approval required after 10 minutes
        - Seller-side approval of cancel requests
    - Order history
    - Balance Management (Will check with customer's balance before any order)



## Design Decisions
- **Authentication**: Laravel Sanctum used for API token-based auth to allow SPA/mobile-friendly secure access.
- **Order Workflow**: Orders are soft-cancelled and require seller approval if not within auto-cancel window.
- **Balance Management**: Customer balance is validated before orders; refunds are auto-credited upon cancellation.
- **Clean REST Principles**: Controllers are grouped under versioned API (`v1`) with RESTful structure + custom endpoints.
- **Code Organization**: `apiResource` used for CRUD, and custom endpoints handle transactional logic (e.g., orderNow).


## Tech Stack
- Laravel 10
- MySQL
- Sanctum (auth)
- Postman (for calling)

## Getting Started

### Prerequisites

- PHP 8.1+
- Composer
- MySQL
- Laravel CLI


### Installation
```bash
git clone https://github.com/yourname/ecommerce-api.git
cd ecommerce-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed 


### Run 
php artisan serve


## Demo Accounts

Use these credentials to test:
- Customer: 
    {
        "email": "ortiz.velda@gmail.com", //random email get from database - customer table
        "password": "default1234"
    }
- Seller: 
    {
        "email": "ortiz.velda@gmail.com", //random email get from database - seller table
        "password": "default1234"
    }


### End To End Process (Using provided Postman)
Customer Flow :-
1. Customer -> Customer Profile : POST customer/login 

2. Customer -> Customer Profile : GET v1/customer/viewProfile  
    -- to check if scantum works fine

3. Product : GET v1/product  
    -- please check the filter option =>  status[eq] = A 
    -- can note down product ids with same seller so that can test the payment cart (same seller / different seller)
    -- can view product profile by calling => Product : GET v1/product/1  
        -- replace '1' with other product id

4. Payment -> Cart : POST v1/cart/addToCart
    -- can add multiple products from same/ different seller (need to add it one by one)

5. Payment -> Cart : GET v1/cart/viewCart 
    -- cart will display and grouped by seller id (can refer to Shopee)
    -- can note down the "payctrxn_no" 
    -- can continue to update cart / delete cart (permenterary delete)

6. Payment -> Order :  POST v1/order/fromcart
    -- can enter the "payctrxn_no" to order the whole cart trxn (support multiple cart trxn)
    -- not support customer to order single product in a cart trxn, because can use "order now"

7. Payment -> Order :  POST v1/order/now
    -- Can enter multiple/single product id 

8. Payment -> Order : GET v1/order/history
    -- can take note the "order_no"
    -- Customer Place Order Flow ended here 

9. Payment -> Order -> cancel order :  POST  v1/order/cancel 
    -- can enter the "order_no" here 
    -- wait for 10min to trigger seller approval process or use "forceApproval" flag (set true to active it)
    -- Customer Cancel Order Flow ended here

Seller Flow:- 
1. Seller -> Seller Profile : POST seller/login 
    -- use the ordered products' seller acct 

2. Seller -> Seller Profile : GET v1/seller/viewProfile  
    -- to check if scantum works fine

3. Payment -> Order -> cancel order :  GET v1/seller/pendingApproveList
    -- check if the cancel order req is in listing
    -- take note of the "cancel_appr_no"

4. Payment -> Order -> cancel order : POST v1/seller/approveCancel 
    -- enter the "cancel_appr_no" and decision
    -- if approved, status will become "C" (Cancelled) ; else, "D" (Deliver Process)
    -- Seller Cancel Order Flow ended here