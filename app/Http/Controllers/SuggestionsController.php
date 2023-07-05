<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request as RequestRequest;
use Illuminate\Support\Facades\Auth;

class SuggestionsController extends Controller
{
    public function index(RequestRequest $form_request)
    {
        $currentUserId = Auth::id();
        $query = User::whereNotIn('id', function ($q) use ($currentUserId) {
            $q->select('request_id')
                ->from('requests')
                ->where('user_id', $currentUserId);
        })->whereNotIn('id', function ($q) use ($currentUserId) {
            $q->select('user_id')
                ->from('requests')
                ->where('request_id', $currentUserId);
        })->where('id', '!=', $currentUserId);

        $count = $query->count();
        $suggestions = $query->offset($form_request->skipCounter)->limit($form_request->takeAmount)->get();

        $html = '';
        foreach ($suggestions as $suggestion)
            $html .= view('components.suggestion', compact('suggestion'))->render();

        return response()->json(['content' => $html,'count'=>$count], 200);
    }

    public function destroy(RequestRequest $form_request)
    {

        $q = \App\Models\Request::where('user_id', $form_request->userId)
            ->where('request_id', $form_request->requestId)
            ->delete();

        return response()->json(['status' => $q], 200);
    }
}
