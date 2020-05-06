
# 1. jwt(in auth.php , 'driver' => 'jwt')

-register
    http://localhost:8000/api/register?name=cat&email=cat@mail.com&password=12345678&c_password=12345678
    [name, email, password, c_password]

-login and get token
    http://localhost:8000/api/login?email=cat@mail.com&password=12345678 
    [email, password]

-add bearer to access
    http://localhost:8000/api/details
    [Accept => application/json, Authorization => Bearer token]

-refresh
    http://localhost:8000/api/refresh
    [Accept => application/json, Authorization => Bearer token]

-logout
    http://localhost:8000/api/logout
    [Accept => application/json, Authorization => Bearer token]- register
    http://localhost:8000/api/register?name=cat&email=cat@mail.com&password=12345678&c_password=12345678
    [name, email, password, c_password]
    
# password(in auth.php , 'driver' => 'passport')
-create client and get id and secret
    php artisan passport:client --password

-use client information to get token
    http://localhost:8000/oauth/token
    [grant_type => password, client_id, client_secret, username, password, scope]

-add bearer to access
    http://localhost:8000/api/details
    [Accept => application/json, Authorization => Bearer token]

-refresh
    http://localhost:8000/oauth/token
    [grant_type => refresh_token, refresh_token, client_id, client_secret, scope]
  
# password(in auth.php , 'driver' => 'passport')
    in api server(localhost:8000):
-create client、client_redirect_uri...
    php artisan passport:client

    in client server:
-get authorization_code
    http://localhost:8000/oauth/authorize?client_id=&redirect_uri=&response_type=code&scope=
-in self redirect_uri accept request and get authorization_code

-add code and get bearer token
    http://localhost:8000/oauth/token
    [grant_type => authorization_code, client_id, client_secret, redirect_uri, code]

-add bearer to access
    http://localhost:8000/api/details
    [Accept => application/json, Authorization => Bearer token]

-refresh
    http://localhost:8000/oauth/token
    [grant_type => refresh_token, refresh_token, client_id, client_secret, scope]
