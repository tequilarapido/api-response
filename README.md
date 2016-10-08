
# tequilarapido/api-response 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tequilarapido/api-response.svg?style=flat-square)](https://packagist.org/packages/tequilarapido/api-response)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/tequilarapido/api-response/master.svg?style=flat-square)](https://travis-ci.org/tequilarapido/api-response)
[![StyleCI](https://styleci.io/repos/70261592/shield)](https://styleci.io/repos/70261592)
[![Quality Score](https://img.shields.io/scrutinizer/g/tequilarapido/api-response.svg?style=flat-square)](https://scrutinizer-ci.com/g/tequilarapido/api-response)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/tequilarapido/api-response/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/tequilarapido/api-response/?branch=master)

## Installation

You can install the package using composer

``` bash
$ composer require tequilarapido/api-response
```

Add the service provider

``` php
Tequilarapido\ApiResponse\ApiResponseServiceProvider::class 
```


## Usage

This package comes with a helper function `api_response()`, as sugar syntax to using `app(Tequilarapido\ApiResponse\ApiResponse::class)`

 
### Return a response from an item (Array / Associative array / Object/)
 
``` php
return api_response()->item(['result`' => 'success'])
```

Result :   
```
    {
        "data":
        {   
            "result":
            "success"
        }
    }
```

### Return a response from a collection
 
``` php
return api_response()->item(collect(['Apple', 'Orange', 'Kiwi']))
```

Result :   
```   
    {
        "data":
            {   
                "Apple",
                "Orange",
                "Kiwi",
            }
    }
```

### Return a response from a paginated collection

``` php
return api_response()->item(collect(['Apple', 'Orange', 'Kiwi']))
```

Result :   
```
    {
        "data": [1, 2, 3],
        "meta": {
            "pagination": {
                "count": 3,
                "current_page": 1,
                "links": {
                    "next": "/?page=2"
                },
                "per_page": 3,
                "total": 15,
                "total_pages": 5
            }
         }
    }
```

### Transformers 

You can use transformers along with `item()`, `collection()`, and `paginatedCollection` methods to transform results
before returning the responses.

To learn more about the concept behind transformers, please read the [League\Fractal documentation](http://fractal.thephpleague.com/transformers/). 

Put in a simple way, a Transformer class 
    - must extends `League\Fractal\TransformerAbstract` 
    - and contains a method `transform()` that take the raw value/object as an argument and transform it the way we want.
    
Let's assume that we need to return an api response containing a collection of books retreived from database, and we want to format/enhance/restrict results.
  
``` php
class BookTransformer extends TransformerAbstract
{
    public function transform($book)
    {
        return [
            'id' => (int)$book->id,
            'title' => strtoupper($book->title),
            'price' => '$' . $book->price,
            'published_at' => $book->published_at->format('d/m/Y'),
            'url' => 'https://store.books.com/books/' . $book->id
        ];
    }
}
``` 
  
``` php
Route::get('/books', function () {

    // ie. Book::all()
   $books = collect([
       (object)['title' => 'An awesome book', 'id' => '1', 'price' => 10, 'published_at' => Carbon::createFromFormat('Y-m-d', '2016-10-01')],
       (object)['title' => 'A second awesome book', 'id' => '2', 'price' => 100, 'published_at' => Carbon::createFromFormat('Y-m-d', '2016-10-02')],
   ]);

   return api_response()->collection($books, new BookTransformer);
});
```

Result: 
``` 
{
    "data": [
        {
            "id": 1,
            "price": "$10",
            "published_at": "01/10/2016",
            "title": "AN AWESOME BOOK",
            "url": "https://store.books.com/books/1"
        },
        {
            "id": 2,
            "price": "$100",
            "published_at": "02/10/2016",
            "title": "A SECOND AWESOME BOOK",
            "url": "https://store.books.com/books/2"
        }
    ]
}
``` 

### Attaching cookies

For `item()`, `collection()`, and `paginatedCollection` methods the returned result is a built `Illuminate\Http\Response` object.

To be able to attach cookies you need to instruct `api_response()` methods to not build the response by setting the $built argument to false, attach the cookie
and then build the response.

``` php
return api_response()
    ->item(['result`' => 'success'], null, null, false)
    ->withCookie(new \Symfony\Component\HttpFoundation\Cookie('name', 'value'))
    ->build();
```

### Attaching headers

For `item()`, `collection()`, and `paginatedCollection` methods the returned result is a built `Illuminate\Http\Response` object.

To be able to attach headers you need to instruct `api_response()` methods to not build the response by setting the $built argument to false, attach the header
and then build the response.

``` php
return api_response()
    ->item(['result`' => 'success'], null, null, false)
    ->withHeader('X-CUSTOM', 'customvalue')
    ->build();
```

###  Other useful methods 

| Method      | Usage        | 
|-------------|--------------|
| `api_response()->noContent()` | Return an empty response with 204 No Content header.|
| `api_response()->errorNotFound()` | Return a 404 Not found.|
| `api_response()->errorBadRequest()` | Return a 404 Bad Request.|
| `api_response()->errorForbidden()` | Return a 403 Forbidden.|
| `api_response()->errorUnAUthorized()` | Return a 401 Unauthorized.|
| `api_response()->errorInternal()` | Return a 500 Internal Error.|
| `api_response()->error()` | Return a more customizable error (Accept MessageBag instance, staus code ...)|


## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Nassif Bourguig](https://github.com/nbourguig)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
