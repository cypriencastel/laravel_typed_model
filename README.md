# Laravel Typed Models    

## Why?

Current Laravel models don't describe really what they really contain once the query is fetched.    
We don't know what the properties will be.    
Most of them will relate to the database column related to the model, which is not reflected in the model class.    

## Proposed solution

What I propose is to declare properties directly is the model, and use a PHP attribute to declare the column we want to map.    

```php

use App\Models\Model;
use App\Models\Typed\Attributes\IsMapped;

// A classic Eloquent Model
class User extends Model
{
    use IsMapped;
    // Here we declare a property createdAt that will map the created_at column
    #[Map('created_at')]
    public string $createdAt;
}
```

In this way, we explicitly describe what are the available model properties,   
we can map table columns, use a different case, and our text editor knows what properties   
it can propose us which is good for our developer quality of life :)
