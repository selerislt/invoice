@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $client->name }}
                    <div style="float: right">
                        <a href="{{ route('editClient', $client->id) }}"style="color: green">Redaguoti</a>
                               |
                        <a href="#" onclick="if (! confirm('Ar tikrai norite ištrinti?')) { return false; } event.preventDefault();
                                 document.getElementById('destroy').submit();" style="color: red">Ištrinti</a>
                        <form id="destroy" action="{{ route('destroyClient', $client->id) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="panel-body">
                    Rūšiavimas:
                    <select id="order" name="order" onchange="document.getElementById('orderby_input').value = this.value; document.getElementById('orderby').submit()">
                        <option value="name" {{ (Request::input('order') == 'name' ? 'selected="selected"' : '') }}>Pagal vardą</option>
                        <option value="delivery_date" {{ (Request::input('order') == 'delivery_date' ? 'selected="selected"' : '') }}>Pagal datą</option>
                    </select>

                    <form id="orderby" method="GET" style="display: none;">
                        <input type="text" id="orderby_input" value="ss" name="order">
                    </form>

                    <table class="table table-stripped text-center" style="margin-top: 15px">
                        <tr style="font-weight: 800">
                            <td>#</td>
                            <td>Pavadinimas</td>
                            <td>Uždarbis</td>
                            <td>Data</td>
                            <td>Veiksmas</td>
                        </tr>
                        @foreach((Request::input('order') ? $client->services()->orderBy(Request::input('order'), 'asc')->get() : $client->services()->get()) as $number => $service)
                            <tr>
                                <td>{{ $number+1 }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->price - $service->cost }} Eur</td>
                                <td>{{ $service->delivery_date }}</td>
                                <td>
                                    <a href="{{ route('viewService', $service->id) }}">Peržiūrėti</a>
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
