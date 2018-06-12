<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Paslaugu israsas {{ date('Y-m-d') }}</title>
    </head>
    <body>
        <h1 style="text-align: center">Visos paslaugos</h1>
        <h3 style="text-align: center">{{ $from . ' - ' . $until }}</h3>
        <table style="width: 100%">
            <tr style="font-weight: 800">
                <td>#</td>
                <td>Pavadinimas</td>
                <td>Uzsakovas</td>
                <td>Saskaitos nr.</td>
                {{-- <td>Savikaina</td> --}}
                <td>Kaina</td>
                <td>Skirt.</td>
                <td>Data</td>
            </tr>
            @foreach($services as $index => $service)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $service->name }}</td>
                    <td>{{ App\Client::find($service->client_id)->name }}</td>
                    <td>{{ ($service->invoice_nr) ? $service->invoice_nr : '-' }}</td>
                    {{-- <td>{{ $service->cost }} Eur</td> --}}
                    <td>{{ $service->price }} Eur</td>
                    <td>{{ $service->price - $service->cost }} Eur</td>
                    <td>{{ $service->delivery_date }}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>
