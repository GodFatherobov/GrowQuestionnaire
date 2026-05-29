<?php

namespace App\Console\Commands;

use App\Models\answer;
use App\Models\course;
use App\Models\other;
use App\Models\student;
use Illuminate\Console\Command;

class DemoClean extends Command
{
    protected $signature = 'demo:clean';
    protected $description = '清除 demo 課程的污染資料（學員名稱 111 和 222）';

    public function handle()
    {
        $demoClass = course::where('ClassLink', 'demo')->first();

        if (!$demoClass) {
            $this->error('找不到 demo 課程（ClassLink = demo），請確認資料庫中有此課程。');
            return 1;
        }

        $this->info("Demo 課程：{$demoClass->ClassName}（ID: {$demoClass->id}）");

        $students = student::where('classID', $demoClass->id)
            ->whereIn('name', ['111', '222'])
            ->get();

        if ($students->isEmpty()) {
            $this->info('找不到學員名稱為 111 或 222 的資料，無需清除。');
            return 0;
        }

        $studentIds = $students->pluck('id');
        $otherIds   = other::whereIn('studentID', $studentIds)->pluck('id');

        $otherAnswerCount   = answer::whereIn('otherID', $otherIds)->count();
        $selfAnswerCount    = answer::whereIn('studentID', $studentIds)->whereNull('otherID')->count();
        $otherCount         = $otherIds->count();
        $studentCount       = $students->count();

        $this->line('');
        $this->line('即將刪除以下資料：');
        $this->table(
            ['資料表', '條件', '筆數'],
            [
                ['answers（他評）', 'otherID in (' . $otherIds->implode(', ') . ')', $otherAnswerCount],
                ['others',         'studentID in (' . $studentIds->implode(', ') . ')', $otherCount],
                ['answers（自評）', 'studentID in (' . $studentIds->implode(', ') . ')', $selfAnswerCount],
                ['students',       'name in [111, 222] & classID=' . $demoClass->id, $studentCount],
            ]
        );
        $this->line('');

        foreach ($students as $s) {
            $this->line("  學員：{$s->name}（ID: {$s->id}）");
        }

        $this->line('');

        if (!$this->confirm('確認刪除以上資料？')) {
            $this->info('已取消，未刪除任何資料。');
            return 0;
        }

        answer::whereIn('otherID', $otherIds)->delete();
        other::whereIn('studentID', $studentIds)->delete();
        answer::whereIn('studentID', $studentIds)->whereNull('otherID')->delete();
        student::whereIn('id', $studentIds)->delete();

        $this->info('清除完成。');
        return 0;
    }
}
