<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Client;
use App\Service;

class ClientController extends Controller
{
    function index(){
        $data['clients'] = Client::orderBy('name', 'asc')->get();

        return view('clients.home', $data);
    }

    function add(){
        return view('clients.new');
    }

    function view(Request $r, $id){
        $data['client'] = Client::find($id);

        return view('clients.view', $data);
    }

    function edit($id)
    {
        $data['client'] = Client::find($id);

        return view('clients.edit', $data);
    }

    function update(Request $r, $id)
    {
      $this->validate($r, [
          'new_name' => 'required'
      ]);

      $data = Client::find($id);

      $data->name = $r->input('new_name');
      $data->save();


        return redirect(route('viewClient', $id))->with('status', 'Sėkmingai atnaujinote užsakovą');
    }

    function post(Request $r){
        $data = $r->all();

        Client::create([
            'user_id' => Auth::user()->id,
            'name' => $data['name']
            ]);

        return redirect(route('clients'));
    }

    function destroy($id){
        $client = Client::find($id);

        foreach($client->services()->get() as $service)
        {
            ($service->attachment) ? Storage::delete($service->attachment) : '';
            $service->delete();
        }

        $client->delete();

        return redirect(route('clients'))->with('status', 'Klientas buvo sėkmingai ištrintas su visais įrašais');
    }
}
