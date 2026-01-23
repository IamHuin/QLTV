<?php

namespace App\Console\Commands;

use App\Service\MailService;
use Illuminate\Console\Command;

class SendMailDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-mail-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi mail vào lúc 8h sáng hằng ngày';

    /**
     * Execute the console command.
     */
    public function handle(MailService $mailService)
    {
        $mailService->sendMail();
        $this->info('Gọi Service để gửi Mail');
    }
}
