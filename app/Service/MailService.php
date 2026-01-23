<?php

namespace App\Service;

use App\Jobs\SendMailJob;
use App\Mail\SendMail;
use App\Repository\Contract\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function sendMail()
    {
        $list_email = $this->userRepo->getAllEmail();
        foreach ($list_email as $email) {
            dispatch(new SendMailJob($email));
        }
        return response()->json([
            'success' => true,
            'message' => __('Mail successfully sent'),
        ]);
    }
}
