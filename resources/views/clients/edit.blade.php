@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Užsakovo atnaujinimas</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('updateClient', $client->id) }}" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="form-group">
                          <label for="new_name" class="col-md-3 control-label">Užsakovas</label>

                          <div class="col-md-9">
                              <input type="text" class="form-control" name="new_name" id="new_name" value="{{ $client->name }}">
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
