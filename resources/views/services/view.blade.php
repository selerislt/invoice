@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $service->name }} -
                    <a href="{{ route('viewClient', $service->client->id) }}" style="font-weight: 800">{{ $service->client->name }}</a>
                    <div style="float: right">
                        <a href="{{ route('editService', $service->id) }}"style="color: green">Redaguoti</a>
                                 |
                        <a href="#" onclick="if (! confirm('Ar tikrai norite ištrinti?')) { return false; } event.preventDefault();
                                 document.getElementById('destroy').submit();" style="color: red">Ištrinti</a>
                        <form id="destroy" action="{{ route('destroyService', $service->id) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Sąskaitos numeris</label>
                        <div class="col-md-6">
                            <p>{{ ($service->invoice_nr) ? $service->invoice_nr : 'Nenurodyta' }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Aprašymas</label>
                        <div class="col-md-6">
                            <p>{!! $service->description !!}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Savikaina</label>
                        <div class="col-md-6">
                            <p>{{ $service->cost }} Eur</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Pardavimo kaina</label>
                        <div class="col-md-6">
                            <p>{{ $service->price }} Eur</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Uždarbis</label>
                        <div class="col-md-6">
                            <p style="color: green; font-weight: 700">{{ $service->price - $service->cost }} Eur</p>
                        </div>
                    </div>

                    @if($service->attachment)
                        <div class="form-group">
                            <label class="col-md-4 control-label">Prisegtas failas</label>
                            <div class="col-md-6">
                                <p>
                                    <a href="{{ asset('oranzine/storage/app/public/' . $service->attachment) }}" target="blank">Nuoroda</a>
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="col-md-4 control-label">Data</label>
                        <div class="col-md-6">
                            <p>{{ $service->delivery_date }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Saldus</label>
                        <div class="col-md-6">
                            <p>{{ ($service->sweat) ? 'Taip' : 'Ne' }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
