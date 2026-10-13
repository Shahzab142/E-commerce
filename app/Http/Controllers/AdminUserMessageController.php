<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserMessageController extends Controller
{
    public function index()
    {
        $userMessage = \App\Models\UserMessage::first();
        return view('admin.user-message.index', compact('userMessage'));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'message' => 'nullable|string',
        ]);

        $userMessage = \App\Models\UserMessage::first() ?? new \App\Models\UserMessage();
        $userMessage->message = $request->message;
        $userMessage->is_active = $request->has('is_active');
        $userMessage->save();

        return back()->with('success', 'User message updated successfully.');
    }
}
