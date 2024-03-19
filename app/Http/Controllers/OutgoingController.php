<?php

namespace App\Http\Controllers;

use App\Models\Outgoing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutgoingController extends Controller
{
    public function showTable()
    {
        $outgoings = Outgoing::all();
        return view('outgoing', ['outgoings' => $outgoings]);
    }

    public function addRecordToTable(Request $request)
    {
        $incomingFields = $request->validate([
            'to_office' => 'required',
            'for' => 'required',
            'subject' => 'required',
            'remarks'=> 'required',
            'action' => 'nullable',
            'action_date' => 'nullable'
        ]);

        $incomingFields['date'] = today();

        $incomingFields['received_by'] = Auth::user()->name;

        $incomingFields['to_office'] = strip_tags($incomingFields['to_office']);
        $incomingFields['for'] = strip_tags($incomingFields['for']);
        $incomingFields['subject'] = strip_tags($incomingFields['subject']);
        $incomingFields['remarks'] = strip_tags($incomingFields['remarks']);
        $incomingFields['action'] = strip_tags($incomingFields['action']);
        $incomingFields['action_date'] = strip_tags($incomingFields['action_date']);


        Outgoing::create($incomingFields);

        return redirect('/outgoing');
    }

    public function showEditIncomingPage(Outgoing $outgoing)
    {
        return view('editIncoming', ['outgoing' => $outgoing]);
    }

    public function editRecordFromTable(Outgoing $outgoing, Request $request)
    {
        $incomingFields = $request->validate([
            'from_office' => 'required',
            'subject' => 'required',
            'remarks'=> 'required',
            'action' => 'nullable',
            'action_date' => 'nullable'
        ]);

        $incomingFields['from_office'] = strip_tags($incomingFields['from_office']);
        $incomingFields['subject'] = strip_tags($incomingFields['subject']);
        $incomingFields['remarks'] = strip_tags($incomingFields['remarks']);
        $incomingFields['action'] = strip_tags($incomingFields['action']);
        $incomingFields['action_date'] = strip_tags($incomingFields['action_date']);

        $outgoing->update($incomingFields);

        return redirect('/outgoing');
    }

    public function deleteRecordFromTable(Outgoing $outgoing)
    {
        $outgoing->delete();
        return redirect('/outgoing');
    }
}