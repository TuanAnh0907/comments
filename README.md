# Comments and likes in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/doloan09/rake_algorithms.svg?style=flat-square)](https://packagist.org/packages/doloan09/rake_algorithms)
[![Total Downloads](https://img.shields.io/packagist/dt/doloan09/rake_algorithms.svg?style=flat-square)](https://packagist.org/packages/doloan09/rake_algorithms)
![GitHub Actions](https://github.com/doloan09/rake_algorithms/actions/workflows/main.yml/badge.svg)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.
## Overview

Package này có thể giúp bạn thêm một chức năng nhận xét nhanh chóng cho bất kì model nào của bạn.
Tất cả các nhận xét được lưu tại một bảng duy nhất và có liên kết với khách hàng. Chức năng thích và hủy thích cũng được gắn lên từng bình luận. Bạn có thể xem những người đã thích bình luận bằng hành 

## Installation

You can install the package via composer:

```bash
composer require tuananh0907/packages_comments
```

## Features

* View comments
* Create comments
* Delete comments
* Edit comments
* Reply to comments
* Authorization rules
* Support localization
* Dispatch events
* Route, Controller, Comment, Migration & View customizations
* Pagination (opt-in)
* Like comments
* Dislike comments
* View liker

## Run migrations

We need to create the table for comments and likes.

```php
    php artisan migrate
```

## Add Commenter trait to your User model

Add the **_Commenter_** trait to your User model so that you can retrieve the comments for a user:

```php
    use Laravelista\Comments\Commentable;

    class Product extends Model
    {
        use Commentable;
    }
```

## Add Commentable trait to models

Add the **_Commentable_** trait to the model for which you want to enable comments for:

```php
    use Laravelista\Comments\Commentable;

    class Product extends Model
    {
        use Commentable;
    }
```

## Publish Config & configure (optional)

**Publish the config file (optional):**
```php
php artisan vendor:publish --provider="Laravelista\Comments\ServiceProvider" --tag=config
```

**Publish views (customization)**

The default UI is made for Bootstrap 4, but you can change it however you want.
```php
php artisan vendor:publish --provider="Laravelista\Comments\ServiceProvider" --tag=views
```
**Publish Migrations (customization)**

You can publish migration to allow you to have more control over your table
```php
php artisan vendor:publish --provider="Laravelista\Comments\ServiceProvider" --tag=migrations
```
**Publish translations (customization)**

The package currently only supports English, but I am open to PRs for other languages.
```php
php artisan vendor:publish --provider="Laravelista\Comments\ServiceProvider" --tag=translations
```
## Usage

Giao diện sử dụng tailwindcss nên dự án cần cài đặt tailwindcss:

Xem hướng dẫn cài đặt [tại đây](https://tailwindcss.com/docs/installation)

Trong giao diện hiển thị bạn muốn gắn thêm phần bình luận, gắn đoạn code sau vào chỗ đó: 

Ở đây ví dụ là một bài viết

```php
@comments(['model' => $post])
```

Để xem bình luận được phê duyệt 

```php
@comments([
    'model' => $book,
    'approved' => true
])
```

Phân trang: xác định số lượng nhận xét trên mỗi trang 

```php
@comments([
    'model' => $user,
    'perPage' => 2
])
```

Xác định cấp độ hiển thị của bình luận

```php
@comments([
    'model' => $user,
    'maxIndentationLevel' => 1
])
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email tuananhtybg.99@gmail.com instead of using the issue tracker.

## Credits

-   [TuanAnh0907](https://github.com/tuananh0907/comments)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com) by [Beyond Code](http://beyondco.de/).
