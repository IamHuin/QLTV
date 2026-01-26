<?php

namespace App\Http\Controllers;

use App\Service\MailService;
use Illuminate\Http\Request;

class MailController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function sendMail()
    {
        $flag = $this->mailService->sendMail();
        if ($flag) {
            return response()->json([
                'success' => true,
                'message' => __('Mail successfully sent'),
            ], 204);
        }
        return response()->json([
            'success' => false,
            'message' => __('Mail unsuccessfully sent'),
        ], 404);
    }
}
