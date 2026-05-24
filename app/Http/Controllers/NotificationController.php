<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }

    public function markRead(string $id)
    {
        $notif = Auth::user()->notifications()->findOrFail($id);
        $notif->markAsRead();
        
        // ========== REDIRECT BERDASARKAN ROLE DAN JENIS NOTIFIKASI ==========
        $user = Auth::user();
        $notifType = class_basename($notif->type);
        
        // Jika notifikasi lamaran
        if ($notifType == 'LamaranStatusBerubah') {
            $lamaranId = $notif->data['lamaran_id'] ?? null;
            
            if ($user->isEmployer()) {
                // Perusahaan -> detail pelamar
                return redirect()->route('perusahaan.pelamar.show', $lamaranId);
            } elseif ($user->isJobSeeker()) {
                // Pencari kerja -> detail lamaran sendiri
                return redirect()->route('lamaran.jobseeker.show', $lamaranId);
            }
        }
        
        // Jika notifikasi verifikasi data diri
        if ($notifType == 'VerifikasiDataDiriBerubah') {
            return redirect()->route('jobseeker.profile.show');
        }
        
        // Jika notifikasi pengajuan bantuan
        if ($notifType == 'StatusPengajuanBerubah') {
            $pengajuanId = $notif->data['pengajuan_id'] ?? null;
            return redirect()->route('pengajuan-bantuan.show', $pengajuanId);
        }
        
        // Default redirect
        return redirect($notif->data['url'] ?? route('dashboard'));
    }

    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        return view('notifications.index', compact('notifications'));
    }
}