<?php

namespace App\Http\Controllers;

use App\Models\NotificationMail;
use Illuminate\Http\Request;

class NotificationMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Mail Notification';
        $data['notification_mails'] = NotificationMail::orderBy('id', 'desc')->get();
        return view('notification-mails.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Email';
        return view('notification-mails.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            NotificationMail::create([
                'email' => $request->email
            ]);
            return redirect()->route('notification-mails.index')->with('success', 'Email berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->route('notification-mails.index')->with('error', 'Email gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotificationMail  $notificationMail
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationMail $notificationMail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotificationMail  $notificationMail
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationMail $notificationMail)
    {
        $data['page_title'] = 'Edit Email';
        $data['notification_mail'] = $notificationMail;
        return view('notification-mails.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NotificationMail  $notificationMail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificationMail $notificationMail)
    {
        try {
            $notificationMail->update([
                'email' => $request->email
            ]);
            return redirect()->route('notification-mails.index')->with('success', 'Email berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->route('notification-mails.index')->with('error', 'Email gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotificationMail  $notificationMail
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationMail $notificationMail)
    {
        try {
            $notificationMail->delete();
            return redirect()->route('notification-mails.index')->with('success', 'Email berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('notification-mails.index')->with('error', 'Email gagal dihapus');
        }
    }
}
