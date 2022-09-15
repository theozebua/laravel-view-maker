
# Laravel View Maker


A simple command to generate laravel views.


## Installation


Install this package with composer.

```bash
$ composer require theozebua/laravel-view-maker --dev
```


## Usage


If you run `php artisan list`, you will find two new commands in the list:
- `view:make`
- `view:delete`


### Create a new view


By default, all views will be placed in the `resources/views` directory. However, 
you can make subfolder to the view using slash "`/`" or dot "`.`" notation.


#### Examples


- Create a view inside the `resources/views` directory.

```bash
# resources/views/index.blade.php
$ php artisan view:make index
```

And the result is a view with standard HTML5 boilerplate:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <div>
        
    </div>

</body>
</html>
```

- Create a view inside subdirectory.

```bash
# resources/views/user/index.blade.php
$ php artisan view:make user.index
$ php artisan view:make user/index
```

- Create a view even when the view is already exists with `--force` or `-f` flag.

```bash
$ php artisan view:make user.index -f
```

- Create a view that uses a layout

If you are using blade components to make a layout, you can use `--layout` or `-l` flag.  
Let's assume we have `app.blade.php` inside `resources/views/components/layouts` and we want to 
make a view that uses that layout.

```bash
$ php artisan view:make user.index --layout=layouts.app
$ php artisan view:make user.index -l layouts.app
```

And the result is something like this in `resources/views/user/index.blade.php`:

```blade
<x-layouts.app>
    <div>

    </div>
</x-layouts.app>
```


### Delete a view


If you want to delete a view, you can use `view:delete` command.


#### Examples


- Delete a view inside the `resources/views` directory.

```bash
$ php artisan view:delete user.index
```

And it will ask you for confirmation.

```bash
Delete this view? (/home/theozebua/Projects/Programming/Laravel/my-own-laravel-packages/resources/views/user/index.blade.php): (yes/no) [no]
❯
```
This is very useful in case you mistyped the path to the view.

- Delete a view without confirmation.

If you want to skip the confirmation, you can use `--force` or `-f` flag.

```bash
$ php artisan view:delete user.index -f
```
## Author

- [@theozebua](https://github.com/theozebua)


## License

[MIT](LICENSE)

