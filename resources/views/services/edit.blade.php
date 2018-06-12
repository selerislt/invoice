@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Pridėti naują įrašą</div>

                <div class="panel-body">
                    <form id="destroyAttachment" action="{{ route('destroyAttachment', $service->id) }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('updateService', $service->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('client_id') ? ' has-error' : '' }}">
                            <label for="client_id" class="col-md-3 control-label">Klientas</label>

                            <div class="col-md-9">
                                <b>{{ App\Client::find($service->client_id)->name }}</b>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('invoice_nr') ? ' has-error' : '' }}">
                            <label for="invoice_nr" class="col-md-3 control-label">Sąskaitos nr.</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" name="invoice_nr" id="invoice_nr" value="{{ $service->invoice_nr }}">

                                @if ($errors->has('invoice_nr'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('invoice_nr') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-3 control-label">Aprašymas</label>

                            <div class="col-md-9">
                                <textarea class="form-control" name="description" id="description" style="height: 250px"> {{ $service->description }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-3 control-label">Savikaina</label>

                            <div class="col-md-9">
                                <input type="number" class="form-control" name="cost" id="cost" value="{{ $service->cost }}" step="0.01">

                                @if ($errors->has('cost'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cost') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="col-md-3 control-label">Pardavimo kaina</label>

                            <div class="col-md-9">
                                <input type="number" class="form-control" name="price" id="price" value="{{ $service->price }}" step="0.01">

                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('attachment') ? ' has-error' : '' }}">
                            <label for="attachment" class="col-md-3 control-label">Failas</label>

                            <div class="col-md-9">
                                <input type="file" name="attachment" id="attachment">

                                @php
                                    if($service->attachment)
                                    {
                                        echo '<div id="attachmentArea">';
                                        echo '<br>';
                                        echo "<a href=\"http://doc.oranzinereklama.lt/oranzine/storage/app/public/" . $service->attachment  . "\" target=\"blank\">Peržiūrėti</a> | <a href=\"#\" style=\"color: red; font-weight: 600\"
                                        onclick=\"deleteAttachment(event)\">Ištrinti</a>";
                                        echo '</div>';
                                    }
                                @endphp

                                @if ($errors->has('attachment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('attachment') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('delivery_date') ? ' has-error' : '' }}">
                            <label for="delivery_date" class="col-md-3 control-label">Paslaugos data</label>

                            <div class="col-md-9">
                                <input type="date" class="form-control" name="delivery_date" id="delivery_date" min="2016-01-01" max="201-12-01" value="{{ $service->delivery_date }}">

                                @if ($errors->has('delivery_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('delivery_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('sweat') ? ' has-error' : '' }}">
                            <label for="delivery_date" class="col-md-3 control-label">Saldus</label>

                            <div class="col-md-9">
                                <input type="checkbox" name="sweat" id="sweat" {{ ($service->sweat) ? 'checked="checked"' : '' }}>

                                @if ($errors->has('sweat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sweat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-3">
                                <button type="submit" class="btn btn-primary">
                                    Atnaujinti
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="text/javascript">
        function deleteAttachment(event){
            if(!confirm('Ar tikrai norite ištrinti?'))
            {
                return false;
            }
            event.preventDefault();
            document.getElementById('destroyAttachment').submit();
            $('#attachmentArea').fadeOut();
        }
    </script>
@endpush
