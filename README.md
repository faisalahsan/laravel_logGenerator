# laravel_logGenerator
1 - Create new middleware name 'LogGeneratorMiddleware'.

2 - Copy code from 'https://github.com/faisalahsan/laravel_logGenerator/blob/master/LogGeneratorMiddleware.php' and      past into newly created 'LogGeneratorMiddleware' in your project.

3 - Open 'Kernal.php' from your project.

4 - Register the middleware

    a - In $middleware array, If you want apply this middleware on every request.
      i.e.
      protected $middleware = [
          ...rest of your project's middlewares
          \App\Http\Middleware\LogGeneratorMiddleware::class,
          ];
    b - In $routeMiddleware, If you want to apply on specific route.
      i.e.
      protected $routeMiddleware = [
        ...rest of your prject's middlewares
        'logger' => \App\Http\Middleware\LogGeneratorMiddleware::class,
      ];  
      Then open your route.php and implement on which route, you want to implement.
      Route::get('myLoggerUrl', ['middleware' => 'logger', 'uses' => 'ConfigController@configureCron']);
    
For detail informaiton about status codes : 
http://kb.globalscape.com/KnowledgebaseArticle10141.aspx
