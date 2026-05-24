<?php

namespace App\Notifications;

use App\Models\LamaranKerja;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LamaranStatusBerubah extends Notification
{
    use Queueable;

    protected $lamaran;
    protected $pesan;

    public function __construct(LamaranKerja $lamaran, string $pesan)
    {
        $this->lamaran = $lamaran;
        $this->pesan = $pesan;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'lamaran_id' => $this->lamaran->id,
            'lowongan_id' => $this->lamaran->lowongan_id,
            'posisi' => $this->lamaran->lowongan->posisi ?? '-',
            'status' => $this->lamaran->status,
            'pesan' => $this->pesan,
            'url' => route('perusahaan.pelamar.show', $this->lamaran->id),
        ];
    }
}