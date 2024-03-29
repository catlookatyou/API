## API server

### 概述
本專案使用laravel開發API，並實作API的認證方式(預設為jwt，若更改passport需調整config/auth.php，可用postman測試認證)。

### 功能介紹
1.	[API](#API)
2.	[Authentication](#Authentication)

### 學到的技術
1.	基本RESTful API的開發及測試
2.	利用laravel carbon套件開發API
3.	實作4種API的認證方式(密碼授權、認證碼授權、個人授權、JWT)
4.  部署至heroku

## 

<h3 id="API">API<h3>

#### 1. restful (需token)
    
    GET        /book
    GET        /book/{id}
    POST       /book
    PUT/PATCH  /book/{id}
    DELETE     /book/{id}
    
#### 2. checktime

   - /api/time?q=next wednesday
   
    input: q = non-number string or datetime(yyyy-mm-dd)
    output: q、dt(yyyy-mm-dd)、now(current datetime)、diffForHumans(ex. 3 days from now)
    
   - /api/time?q1=2012-5-30&q2=64&type=addDays
    
    input: q1 = datetime, q2 = number, type = addYears subYears addMonths subMonths addDays subDays addWeeks subWeeks 
                                              addHours subHours addMinutes subMinutes addSeconds subSeconds
    output: q1, q2, type, time(datetime after compute)
    
   - /api/time?q1=2012-5-30&q2=2011-2-10
    
    input: q1 = datetime, q2 = datetime
    output: q1, q2, dt1(q1 datetime string)、 dt2(q2 datetime string)、 years(years difference between two query)、
            months(months difference between two query)、 days(days difference between two query)、
            hours(hours difference between two query)、 mins(mins difference between two query)

##

<h3 id="Authentication">Authentication<h3>

#### 1. jwt (in auth.php , 'driver' => 'jwt') //1st party

   - register
    
    http://mighty-woodland-37550.herokuapp.com/api/register?name=cat&email=cat@mail.com&password=12345678&c_password=12345678
    [name, email, password, c_password]

   - login and get token
    
    http://mighty-woodland-37550.herokuapp.com/api/login?email=cat@mail.com&password=12345678 
    [email, password]

   - add bearer to access
    
    http://mighty-woodland-37550.herokuapp.com/api/details
    [Accept => application/json, Authorization => Bearer token]

   - refresh
    
    http://mighty-woodland-37550.herokuapp.com/api/refresh
    [Accept => application/json, Authorization => Bearer token]

   - logout
    
    http://mighty-woodland-37550.herokuapp.com/api/logout
    [Accept => application/json, Authorization => Bearer token]
    
#### 2. password (in auth.php , 'driver' => 'passport') //1st party

   - create client and get id and secret
   
    php artisan passport:client --password

   - use client information to get token
   
    http://mighty-woodland-37550.herokuapp.com/oauth/token
    [grant_type => password, client_id, client_secret, username, password, scope]

   - add bearer to access
    
    http://mighty-woodland-37550.herokuapp.com/api/details
    [Accept => application/json, Authorization => Bearer token]

   - refresh
    
    http://mighty-woodland-37550.herokuapp.com/oauth/token
    [grant_type => refresh_token, refresh_token, client_id, client_secret, scope]
    
#### 3. personal(in auth.php , 'driver' => 'passport') //1st party, 2nd party
   - create client
    
    php artisan passport:client --personal

   - create token for user(in api.php)
    
    Route::get('personal_token', function(){
        $user = App\User::find(1);
        $token = $user->createToken('catlookatyou')->accessToken;
        return $token;
    });

   - add bearer to access
    
    http://mighty-woodland-37550.herokuapp.com/api/details
    [Accept => application/json, Authorization => Bearer token]

#### 4. authorization_code (in auth.php , 'driver' => 'passport') //3rd party

   in api server(mighty-woodland-37550.herokuapp.com):
   
   - create client、client_redirect_uri...
    
    php artisan passport:client

   in client server:
    
   - get authorization_code
    
    http://mighty-woodland-37550.herokuapp.com/oauth/authorize?client_id=&redirect_uri=&response_type=code&scope=
   -in self redirect_uri accept request and get authorization_code

   - add code and get bearer token
   
    http://mighty-woodland-37550.herokuapp.com/oauth/token
    [grant_type => authorization_code, client_id, client_secret, redirect_uri, code]

   - add bearer to access
   
    http://mighty-woodland-37550.herokuapp.com/api/details
    [Accept => application/json, Authorization => Bearer token]

   - refresh
    
    http://mighty-woodland-37550.herokuapp.com/oauth/token
    [grant_type => refresh_token, refresh_token, client_id, client_secret, scope]
