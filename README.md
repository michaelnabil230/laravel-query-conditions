
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# This is my package laravel-query-conditions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/michaelnabil230/laravel-query-conditions.svg?style=flat-square)](https://packagist.org/packages/michaelnabil230/laravel-query-conditions)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/michaelnabil230/laravel-query-conditions/run-tests?label=tests)](https://github.com/michaelnabil230/laravel-query-conditions/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/michaelnabil230/laravel-query-conditions/Check%20&%20fix%20styling?label=code%20style)](https://github.com/michaelnabil230/laravel-query-conditions/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/michaelnabil230/laravel-query-conditions.svg?style=flat-square)](https://packagist.org/packages/michaelnabil230/laravel-query-conditions)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-query-conditions.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-query-conditions)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require michaelnabil230/laravel-query-conditions
```

## Preparing your model

To associate query condonation with a model, the model must implement the following interface and trait:

```php
use Illuminate\Database\Eloquent\Model;
use MichaelNabil230\LaravelQueryConditions\Concerns\HasQueryCondonation;
use MichaelNabil230\LaravelQueryConditions\Interfaces\QueryCondonation as InterfacesQueryCondonation;

class YourModel extends Model implements InterfacesQueryCondonation
{
    use HasQueryCondonation;
}
```
## Preparing Vue

```js
import './bootstrap';

window.Vue = require('vue').default;

import QueryBuilder from './components/QueryBuilder.vue'

const app = new Vue({
    el: '#app',
    components: { QueryBuilder },
    methods: {
        getResults: function () {
            axios.post('/results', { query: this.query }).then(response => {
                this.results = response.data;
                console.log({ response });
            });
        }
    },
    data() {
        return {
            query: {},
            rules: [
                {
                    type: "numeric",
                    id: "age",
                    label: "Age"
                },
                {
                    type: "select",
                    id: "job_title",
                    label: "Job Title",
                    choices: [
                        { label: 'Regional Manager', value: 'Regional Manager' },
                        { label: 'Assistant to the Regional Manager', value: 'Assistant to the Regional Manager' },
                        { label: 'Sales Associate', value: 'Sales Associate' },
                    ]
                },
                {
                    type: "numeric",
                    id: "has_orders",
                    label: "has Orders",
                    operators: ['=', '>=']
                },
            ],
        };
    }
});
```

First call the directive in blade or vue (and pass condonations):

## Now 

```html
    <div id="app">
        <query-builder :rules="rules" v-model="query" :clickable="getResults"></query-builder>
    </div>
```

## The next version

```php
    $condonations = [
        Text::make('Name'),
        Number::make('Age')->min(1)->max(1000),
        Select::make('Job title', 'job_title')->options([
            'R' => 'Regional Manager',
            'A' => 'Assistant to the Regional Manager',
            'S' => 'Sales Associate',
        ])
    ];
```

```html
    <div id="app">
        <query-builder :condonations="condonations" v-model="query" :clickable="getResults"></query-builder>
    </div>

    <script>
        let condonations = @json($condonations)
    </script>
```

## Final go to controller

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConditionController extends Controller
{
    public function getFromQueryConditions(Request $request)
    {
        $result = $request->queryConditions();

        $query = \App\Models\User::query();
        $query->parseQBGroup($result, $result->method);

        return [
            $query->get(),
        ];
    }
}
```

## TODOS
- [x] Convert rules to `Field` class
- [x] Format the documents
- [x] Add Groupe to conditions

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Michael Nabil](https://github.com/michaelnabil230)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
