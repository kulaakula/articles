<?php

namespace App\Console\Commands;

use App\Models\Comment;
use App\Models\Schedul;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendStatistic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $articleCount = Schedul::whereRaw('`path` GLOB :name', ['name'=>'*[0-9]'])->count();
        $commentCount = Comment::whereDate('created_at', Carbon::today())->count();
        Mail::send(new StatisticMail($articleCount, $commentCount));
    }
}
