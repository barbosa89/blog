---
title: 'How to easily generate PDF invoices with Laravel'
excerpt: 'Learn how to export invoices to PDF easily using Laravel PHP, DOMPDF and the Laravel Invoices implementation. '
publishedAt: '2021-06-21'
updatedAt: null
locale: 'en'
image: 'images/articles/create-invoices.png'
tags:
- laravel
- php
---

To generate PDF with Laravel there are very powerful solutions, among which the following can be mentioned:

* [Browsershot de Spatie](https://github.com/spatie/browsershot): It uses Chrome to render content, therefore, it supports HTML5, CSS3 and Javascript without major limitations.
* [Laravel Snappy](https://github.com/barryvdh/laravel-snappy): This package works with the wkhtmltopdf and wkhtmltoimage (Web kit HTML to PDF/Image) binaries, but has limitations with EcmaScript 6.

These options are very powerful when you manage your server, for example, VPS or AWS EC2, but for shared hosting it is a problem, since the execution of binaries is usually blocked for security reasons.

Given the above scenario, we have a viable option, this is [Laravel DOMPDF](https://github.com/barryvdh/laravel-dompdf), and an implementation that facilitates a lot of work, called [Laravel Invoices](https://github.com/LaravelDaily/laravel-invoices), a package on which I will base this article.

<article-ad></article-ad>

## Features

Laravel Invoices offers us the features we need the most, the following stand out:

* Discounts
* Taxes
* Shipping value
* Invoice due date
* Currencies formats
* Custom consecutive or identifier
* Multi-language
* Custom templates

If you find it interesting, please continue reading this article, because I am going to make use of this valuable package. To install, we can review the README documentation from the [GitHub repository](https://github.com/LaravelDaily/laravel-invoices):

```php
composer require laraveldaily/laravel-invoices

php artisan invoices:install
```

I am not going to delve into the installation process, as the instructions are very simple. As a **recommendation**, copy the default template so you can make customizations.

```
# Default template
resources/views/vendor/invoices/templates/default.blade.php

# Custom template
resources/views/vendor/invoices/templates/invoice.blade.php
```

Another important thing is that you review the [available methods](https://github.com/LaravelDaily/laravel-invoices#available-methods) in the documentation, it will give you complete information about the API of the Invoice class of the package.

## Example scenario

Normally, you have two basic models, invoices (Invoice) and products (Product), with an intermediate or pivot table with the names of the models in alphabetical order **invoice_product**, therefore, it is a many-to-many relationship. Other models such as the customer (Customer), are added to complement the example.

In invoice controller (InvoiceController), we can have export method:

```php
<?php

use App\Models\Invoice;
use LaravelDaily\Invoices\Invoice as InvoiceDocument;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Illuminate\Http\Response;

...

public function export(Invoice $invoice): Response
{
    $invoice->load([
        'customer' => function ($query) {
            $query->select(['id', 'business_name', 'code', 'address', 'phone']); 
        },
        'products' => function ($query) {
             $query->select(['id', 'description', 'price', 'unit'])
                 ->withPivot(['quantity', 'discount']);
        },
    ]);

    $seller = new Party([
        'name' => 'My company',
        'code' => '123 318 9486',
        'custom_fields' => [
            'address' => 'Colombia',
            'phone' => '123 123 2233',
        ],
    ]);

    $customer = new Party([
        'name' => $invoice->customer->business_name,
        'code' => $invoice->customer->code,
        'address' => $invoice->customer->address,
        'phone' => $invoice->customer->phone,
    ]);

    $items = collect();

    $invoice->products->each(function ($product) use (&$items) {
        $item = new InvoiceItem();
        $item->title($product->description)
            ->pricePerUnit($product->price)
            ->quantity($product->pivot->quantity)
            ->discount($product->pivot->quantity) // Optional: ->discountByPercent(9)
            ->units($product->unit);

        $items->push($item);
    });

    $notes = [
        'Invoice note # 1',
        'Invoice note # 2',
    ];

    $notes = implode("<br>", $notes);

    $invoiceDocument = InvoiceDocument::make('receipt')
        ->series($invoice->prefix)
        ->sequence($invoice->number)
        ->serialNumberFormat('{SERIES}-{SEQUENCE}')
        ->seller($seller)
        ->buyer($customer)
        ->date($invoice->created_at)
        ->dateFormat('m/d/Y')
        ->payUntilDays($invoice->due_days)
        ->currencySymbol('$') ->currencyCode('USD')
        ->currencyFormat('{SYMBOL} {VALUE}')
        ->currencyThousandsSeparator('.')
        ->currencyDecimalPoint(',')
        ->filename($invoice->number)
        ->addItems($items->toArray())
        ->notes($notes)
        ->logo(public_path('vendor/invoices/sample-logo.png'))
        ->template('invoice'); // Custom template

    return $invoiceDocument->stream();
}
```

So, we have the possibility of customizing our invoices and export to PDF easily.

Don't forget that sharing makes us grow, and if you liked this solution, you can go to [GitHub](https://github.com/LaravelDaily/laravel-invoices) and thank with a star.

Thank you.

The image for this article was taken from [Freepik.com](https://www.freepik.com/vectors/business).