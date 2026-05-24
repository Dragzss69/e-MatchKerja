<?php

namespace App\Notifications;

use App\Models\JobSeekerProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VerifikasiDataDiriBerubah extends Notification
{
    use Queueable;

    protected $profile;
    protected $pesan;

    public function __construct(JobSeekerProfile $profile, string $pesan)
    {
        $this->profile = $profile;
        $this->pesan = $pesan;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'profile_id' => $this->profile->id,
            'status' => $this->profile->status_verifikasi,
            'pesan' => $this->pesan,
            'url' => route('jobseeker.profile.show'),
        ];
    }
}