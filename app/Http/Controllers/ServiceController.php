<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Client;
use App\Service;
use Validator;
use PDF;

class ServiceController extends Controller
{
    function add()
    {
        $data['clients'] = Client::orderBy('name', 'asc')->get();

        if(count($data['clients']) == 0)
        {
            return redirect(route('addClient'));
        }

        return view('services.new', $data);
    }

    function post(Request $r)
    {
        $data =  $r->all();

        $validator = Validator::make($data,[
                'client_id' => 'required|numeric',
                'description' => 'required',
                'cost' => 'numeric',
                'price' => 'numeric',
                'delivery_date' => 'date'
            ]);
        if($validator->fails()){
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        (isset($data['attachment'])) ? $attachment = $r->file('attachment')->store('attachments') : $attachment = null;

        Service::create([
            'sweat' => (isset($data['sweat'])) ? true : false,
            'client_id' => $data['client_id'],
            'invoice_nr' => $data['invoice_nr'],
            'description' => $data['description'],
            'cost' => $data['cost'],
            'price' => $data['price'],
            'attachment' => $attachment,
            'delivery_date' => $data['delivery_date']
            ]);

        return redirect(route('viewClient', $data['client_id']))->with('status', 'Sėkmingai pridėjote naują įrašą');
    }

    function edit($id)
    {
        $data['service'] = Service::find($id);

        return view('services.edit', $data);
    }

    function update(Request $r, $id)
    {
        $data =  $r->all();

        $validator = Validator::make($data,[
                'description' => 'required',
                'cost' => 'numeric',
                'price' => 'numeric',
                'delivery_date' => 'date'
            ]);
        if($validator->fails()){
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        (isset($data['attachment'])) ? $attachment = $r->file('attachment')->store('attachments') : $attachment = null;

        Service::find($id)->update([
            'sweat' => (isset($data['sweat'])) ? true : false,
            'invoice_nr' => $data['invoice_nr'],
            'description' => $data['description'],
            'cost' => $data['cost'],
            'price' => $data['price'],
            'attachment' => $attachment,
            'delivery_date' => $data['delivery_date']
            ]);

        return redirect(route('viewService', $id))->with('status', 'Sėkmingai atnaujinote įrašą');
    }

    function view($id)
    {
        $data['service'] = Service::find($id);

        return view('services.view', $data);
    }

    function all(Request $r)
    {
        $data['services'] = Service::orderBy('sweat', 'asc')->paginate(50);

        if($r->input('from') && $r->input('until'))
        {
            $data['services'] = Service::whereBetween('delivery_date', [$r->input('from'), $r->input('until')])->orderBy('sweat')->get();
        }

        if($r->input('invoice_nr'))
        {
          $search = $r->input('invoice_nr');
            $data['services'] = Service::where('invoice_nr','LIKE', '%'.$search.'%')->orderBy('sweat')->get();
        }

        return view('services.all', $data);
    }

    function destroy($id)
    {
        $service = Service::find($id);
        Storage::delete($service->attachment);
        $service->delete();

        return redirect(route('viewClient', $service->client_id))->with('status', 'Įrašas buvo sėkmingai ištrintas');
    }

    function destroyAttachment($id)
    {
        $service = Service::find($id);
        Storage::delete($service->attachment);
        $service->attachment = NULL;
        $service->save();

        return redirect()->back();
    }

    function generatePDFall(Request $r)
    {
        $data['services'] = Service::whereIn('id', $r->input('service'))->orderBy('delivery_date', 'asc')->get();
        $data['from'] = $r->input('from');
        $data['until'] = $r->input('until');

        $PDF = PDF::loadView('pdf.all', $data);

        return $PDF->download('Išrašas-' . date('Y-m-d-') . '.pdf');
    }
}
