@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Užsakovai</div>

                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="panel-body">
                    <table class="table table-stripped text-center">
                        <tr style="font-weight: 800">
                            <td>#</td>
                            <td>Pavadinimas</td>
                            <td>Paslaugų</td>
                            <td>Pardavimo suma</td>
                            <td>Uždarbis</td>
                            <td>Veiksmas</td>
                        </tr>
                        @foreach($clients as $number => $client)
                            @php
                                $profit = 0;
                                $sales = 0;
                                foreach($client->services()->get() as $service)
                                {
                                    $profit = $profit + ($service->price - $service->cost);
                                    $sales = $sales + $service->price;
                                }
                            @endphp
                            <tr>
                                <td>{{ $number+1 }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ count($client->services()->get()) }}</td>
                                <td>{{ $sales }} Eur</td>
                                <td>{{ $profit }} Eur</td>
                                <td>
                                    <a href="{{ route('viewClient', $client->id) }}">Peržiūrėti</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
