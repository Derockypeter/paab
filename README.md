<h1 align="center">White Coat Domain</h1>

## IMPORTANT NOTE
Please note that to get a migration of cities, countries, and states.
Please run the following 
<p>
    <code>php artisan db:seed</code> <br/> 
    <code>php artisan migrate --seed --seeder=GeneralSeeder</code> <br/> 
    <code>php artisan passport:install</code> <br/> 
    <code>php artisan serve</code> <br/> 
</p>
<p>
    When claiming site, handle from backend is changed to  eg. <strong>{tenantDomain}.localhost:8000/?token={tokenObtained}</strong> instead of <strong>https://whitecoatdomain.com/getstarted?token={token}&physician={tenant_id}</strong> crucial when passing url to claim button on email.
</p>
Note to self: As a result of <code>FK</code> - foreign key the <code>cities table</code> is the parent key with a reference at <code>users table</code><br/>
<b>IMPORTANT</b><p>For <strong>Stripe</strong> get 'api' keys for webhook and secret and rerun <code> php artisan cashier:webhook</code> to reconfigure for the inputted 'api</p>
<p>These events should be enabled for webhook events - <code>customer.deleted
customer.subscription.created
customer.subscription.deleted
customer.subscription.updated
customer.updated
invoice.payment_action_required
invoice.payment_succeeded</code></p>

<p>Replace "vendor/stancl/tenancy/src/Resolvers/DomainTenantResolver.php" with content of "DomainTenantResolver.php" in root folder</p>

<strong>For Services making calls to our api</strong>
<p>Please prefix <b>services</b> to denote incoming requests.
<p>Create a client using <code>php artisan passport:client --client</code> to generate a client ID for each service.</p>
<p>Save the client_id and client_secret to your app</p>
<p>Make a request to https://whitecoatdomain.com/oauth/token and add the access token generated to your subsequent requests via Authorization Bearer</p>

<strong>NOTE</strong><p>Remember to change <code> APP_ENV </code> to <code> 'production' </code> and <code> APP_DEBUG </code> to <code> false </code></p>

## Tasks 

- [ ] Integrate company stripe account
- [x] Develop Domain module (API endpoints)
- [x] Setup and test TSL (both for central and for tenants)
- [x] Increase AWS EC2 from tmicro to tLarge or tXLarge
- [x] Setup 2 instances of app
- [ ] Change session from file to db
- [ ] Setup NGINX Load Balancer for 2 app instances
- [x] Adjust About Me generation for User Creation by Self, Ask for institution and Names for this generation
- [ ] Integrate WCD stripe account

