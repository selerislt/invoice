@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Visi įrašai
                </div>

                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="panel-body">
                    <form id="filter" method="GET" class="text-center">
                        Nuo: <input type="date" name="from" id="from" value="{{ (Request::input('from')) ? Request::input('from') : date('Y/m/d', strtotime('-30 days')) }}">
                        Iki: <input type="date" name="until" id="until" value="{{ (Request::input('until')) ? Request::input('until') : date('Y/m/d') }}">
                        <button type="submit" class="btn btn-primary">Filtruoti</button>
                    </form>
                    <br>
                    <form id="search" method="GET" class="text-center">
                        Sąskaitos nr.: <input type="text" name="invoice_nr">
                        <button type="submit" class="btn btn-primary">Ieškoti</button>
                    </form>
                    <hr>
                    @php
                        $profit_sweat = 0;
                        $profit = 0;

                        foreach($services as $service)
                        {
                            ($service->sweat) ? $profit_sweat = $profit_sweat + ($service->price - $service->cost) : $profit = $profit + ($service->price - $service->cost);
                        }
                    @endphp
                    <div class="text-center">
                        <b>Saldus</b>: {{ $profit_sweat}} Eur | <b>Paprastas</b>: {{ $profit }} Eur
                    </div>
                    <form method="POST" action="{{ route('generatePDFall') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="from" value="{{ (Request::input('from')) ? Request::input('from') : date('Y/m/d', strtotime('-30 days')) }}">
                        <input type="hidden" name="until" value="{{ (Request::input('until')) ? Request::input('until') : date('Y/m/d') }}">
                        <button type="submit" class="btn btn-primary">Generuoti PDF</button>
                        <table class="table table-stripped text-center" style="margin-top: 15px">
                            <tr style="font-weight: 800">
                                <td>#</td>
                                <td>Užsakovas</td>
                                <td>Uždarbis</td>
                                <td>Sąskaitos nr.</td>
                                <td>Data</td>
                                <td>Veiksmas</td>
                            </tr>
                            @foreach($services as $number => $service)
                                <input type="hidden" name="service[]" value="{{ $service->id }}">
                                <tr>
                                    <td>{{ $number+1 }}</td>
                                    <td>{{ App\Client::find($service->client_id)->name }}</td>
                                    <td>{{ $service->price - $service->cost }} Eur</td>
                                    <td>{{ ($service->invoice_nr) ? $service->invoice_nr : '-' }}</td>
                                    <td>{{ $service->delivery_date }}</td>
                                    <td>
                                        <a href="{{ route('viewService', $service->id) }}">Peržiūrėti</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
