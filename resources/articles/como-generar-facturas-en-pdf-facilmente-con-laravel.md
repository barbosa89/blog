---
title: 'Cómo generar facturas en PDF fácilmente con Laravel'
excerpt: 'Aprende a exportar las facturas en PDF de manera fácil usando Laravel PHP, DOMPDF y la implementación Laravel Invoices.'
publishedAt: '2021-01-15'
updatedAt: null
locale: 'es'
image: 'images/articles/create-invoices.png'
tags:
- laravel
- php
---

Para generar PDF con Laravel existen soluciones muy poderosas, entre las cuales se pueden citar las siguientes:

* [Browsershot de Spatie](https://github.com/spatie/browsershot): Usa Chrome para hacer el renderizado, por lo cual, soporta HTML5, CSS3 y Javascript sin mayores limitaciones.
* [Laravel Snappy](https://github.com/barryvdh/laravel-snappy): Este paquete trabaja con los binarios **wkhtmltopdf** y **wkhtmltoimage** (Web kit HTML to PDF/Image), pero tiene limitaciones con EcmaScript 6.

Estas opciones son muy potentes cuando administras tu servidor, por ejemplo, VPS o EC2 de AWS, pero para hosting compartido es un problema, ya que normalmente se bloquea la ejecución de binarios por temas de seguridad.

Ante el anterior panorama nos queda una opción viable, esta es [Laravel DOMPDF](https://github.com/barryvdh/laravel-dompdf), y una implementación que nos facilita mucho trabajo, llamada [Laravel Invoices](https://github.com/LaravelDaily/laravel-invoices), paquete en el cual basaré este artículo.


## Características

Laravel Invoices nos ofrece las características que más necesitamos, sobresalen las siguientes:

* Descuentos
* Impuestos
* Valor de envío
* Fecha de vencimiento de facturas
* Formateo de monedas
* Consecutivos personalizados
* Multi-lenguaje
* Plantillas personalizadas

Si te parece interesante, probemos este valioso paquete. Para instalarlo, podemos revisar la documentación del README del [repositorio](https://github.com/LaravelDaily/laravel-invoices) de GitHub:

```bash
composer require laraveldaily/laravel-invoices

php artisan invoices:install
```

No voy a profundizar en la instalación, ya que las instrucciones son muy sencillas. Como **recomendación**, copia la plantilla por defecto para que puedas hacer personalizaciones.

```
# Plantilla por defecto
resources/views/vendor/invoices/templates/default.blade.php

# Plantilla personalizada
resources/views/vendor/invoices/templates/invoice.blade.php
```

Otra cosa importante, es que revises en la documentación los [métodos disponibles](https://github.com/LaravelDaily/laravel-invoices#available-methods), te dará una completa información sobre la API de la clase **Invoice** del paquete.

<article-ad></article-ad>

## Escenario

Normalmente se tienen dos modelos básicos, facturas (Invoice) y productos (Product), con una tabla intermedia o pivot con los nombres de los modelos en orden alfabético **invoice_product**, por lo tanto, es una relación de muchos a muchos. Otros modelos como el cliente (Customer), se agregan para complementar el ejemplo.

En el controlador de facturas (InvoiceController), podemos tener método de exportación:

```php
<?php

use App\Models\Invoice;
use LaravelDaily\Invoices\Invoice as InvoiceDocument;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

...


/** 
* Usamos model binding 
* 
* @param Invoice $invoice
* @return \Illuminate\Http\Response
*/
public function export(Invoice $invoice){
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
        'name' => 'Mi Empresa',
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
            ->discount($product->pivot->quantity) // Opcional: ->discountByPercent(9)
            ->units($product->unit);

        $items->push($item);
    });

    $notes = [
        'Nota No. 1 de la factura',
        'Nota No. 2 de la factura',
    ];

    $notes = implode("&lt;br&gt;", $notes);

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
        ->template('invoice'); // Plantilla personalizada

    return $invoiceDocument->stream();
}
```

Así tenemos la posibilidad de personalizar nuestras facturas y la facilidad de exportar a PDF.

No olvides que compartir nos hace crecer, y si te gustó esta solución, puedes ir a [GitHub](https://github.com/LaravelDaily/laravel-invoices) y agradecer con una estrella.

Muchas gracias.

La imagen de este artículo fue tomada de [Freepik.com](https://www.freepik.com/vectors/business).