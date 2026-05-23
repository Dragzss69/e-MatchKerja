<?php

namespace App\Notifications;

use App\Models\PengajuanBantuan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StatusPengajuanBerubah extends Notification
{
    use Queueable;

    public function __construct(
        protected PengajuanBantuan $pengajuan,
        protected string $pesan
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'pengajuan_id'  => $this->pengajuan->id,
            'jenis_bantuan' => $this->pengajuan->jenis_bantuan,
            'status'        => $this->pengajuan->status,
            'pesan'         => $this->pesan,
            'url'           => route('pengajuan-bantuan.show', $this->pengajuan),
        ];
    }
}