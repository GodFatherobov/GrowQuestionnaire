<?php

namespace Database\Seeders;

use App\Models\answer;
use App\Models\course;
use App\Models\other;
use App\Models\student;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run()
    {
        // ── 範例課程：已存在則保留（不覆蓋 People，避免蓋掉後台手動修改的值）
        $course = course::firstOrCreate(
            ['ClassLink' => 'demo'],
            ['ClassName' => '🎯 範例課程 - 情境領導力評估', 'People' => 6, 'user_id' => null]
        );

        // ── 工具函式 ──────────────────────────────────────────────────
        // 自評：以 (studentID, questionID, otherID=null) 為唯一鍵
        $self = function (int $sid, array $map) {
            foreach ($map as $qid => $ans) {
                answer::updateOrCreate(
                    ['studentID' => $sid, 'questionID' => $qid, 'otherID' => null],
                    ['answer' => $ans]
                );
            }
        };

        // 他評：以 (otherID, questionID) 為唯一鍵
        $forOther = function (int $oid, array $map) {
            foreach ($map as $qid => $ans) {
                answer::updateOrCreate(
                    ['otherID' => $oid, 'questionID' => $qid],
                    ['answer' => $ans, 'studentID' => null]
                );
            }
        };

        // ── 1. 王小明 ─ S1 偏向（指導型），2 筆他評完成 ─────────────
        $xm = student::firstOrCreate(
            ['classID' => $course->id, 'name' => '王小明'],
            ['OthersCount' => 2]
        );
        $self($xm->id, [
            1=>'A', 2=>'D', 3=>'C', 4=>'B', 5=>'C', 6=>'B',
            7=>'A', 8=>'C', 9=>'C', 10=>'B', 11=>'A', 12=>'C',
        ]);
        // others：以 (studentID, type) 為唯一鍵；demo 每名學員的每種關係只有一筆
        $o1 = other::updateOrCreate(
            ['studentID' => $xm->id, 'type' => '部屬'],
            ['doneQuiz' => 1]
        );
        $forOther($o1->id, [
            13=>'A', 14=>'D', 15=>'C', 16=>'B', 17=>'C', 18=>'B',
            19=>'A', 20=>'C', 21=>'C', 22=>'B', 23=>'A', 24=>'C',
        ]);
        $o2 = other::updateOrCreate(
            ['studentID' => $xm->id, 'type' => '同事'],
            ['doneQuiz' => 1]
        );
        $forOther($o2->id, [
            13=>'A', 14=>'A', 15=>'C', 16=>'B', 17=>'C', 18=>'D',
            19=>'A', 20=>'C', 21=>'C', 22=>'A', 23=>'A', 24=>'D',
        ]);

        // ── 2. 李美華 ─ S3 偏向（支持型），1 完成 + 1 進行中 ─────────
        $mh = student::firstOrCreate(
            ['classID' => $course->id, 'name' => '李美華'],
            ['OthersCount' => 1]
        );
        $self($mh->id, [
            1=>'B', 2=>'C', 3=>'D', 4=>'C', 5=>'A', 6=>'C',
            7=>'B', 8=>'D', 9=>'D', 10=>'C', 11=>'C', 12=>'A',
        ]);
        $o3 = other::updateOrCreate(
            ['studentID' => $mh->id, 'type' => '上級主管'],
            ['doneQuiz' => 1]
        );
        $forOther($o3->id, [
            13=>'B', 14=>'C', 15=>'D', 16=>'C', 17=>'A', 18=>'C',
            19=>'B', 20=>'D', 21=>'D', 22=>'C', 23=>'C', 24=>'A',
        ]);
        $o4 = other::updateOrCreate(
            ['studentID' => $mh->id, 'type' => '同事'],
            ['doneQuiz' => 0]
        );
        $forOther($o4->id, [
            13=>'B', 14=>'C', 15=>'D', 16=>'C', 17=>'A', 18=>'C',
        ]);

        // ── 3. 陳建志 ─ S2 偏向（教練型），無他評 ────────────────────
        $jz = student::firstOrCreate(
            ['classID' => $course->id, 'name' => '陳建志'],
            ['OthersCount' => 0]
        );
        $self($jz->id, [
            1=>'B', 2=>'A', 3=>'B', 4=>'D', 5=>'B', 6=>'D',
            7=>'C', 8=>'B', 9=>'B', 10=>'D', 11=>'B', 12=>'A',
        ]);

        // ── 4. 林雅婷 ─ 作答中（完成第 1～6 題）─────────────────────
        $yt = student::firstOrCreate(
            ['classID' => $course->id, 'name' => '林雅婷'],
            ['OthersCount' => 0]
        );
        $self($yt->id, [
            1=>'A', 2=>'B', 3=>'C', 4=>'A', 5=>'B', 6=>'C',
        ]);

        // ── 5. 張偉倫 ─ 未開始 ────────────────────────────────────────
        student::firstOrCreate(
            ['classID' => $course->id, 'name' => '張偉倫'],
            ['OthersCount' => 0]
        );

        // ── 6. 劉佳琪 ─ S4 偏向（授權型），3 筆他評全完成 ───────────
        $jq = student::firstOrCreate(
            ['classID' => $course->id, 'name' => '劉佳琪'],
            ['OthersCount' => 3]
        );
        $self($jq->id, [
            1=>'D', 2=>'B', 3=>'B', 4=>'C', 5=>'A', 6=>'C',
            7=>'D', 8=>'A', 9=>'A', 10=>'C', 11=>'D', 12=>'B',
        ]);
        $o5 = other::updateOrCreate(
            ['studentID' => $jq->id, 'type' => '部屬'],
            ['doneQuiz' => 1]
        );
        $forOther($o5->id, [
            13=>'D', 14=>'B', 15=>'B', 16=>'C', 17=>'A', 18=>'C',
            19=>'D', 20=>'A', 21=>'A', 22=>'C', 23=>'D', 24=>'B',
        ]);
        $o6 = other::updateOrCreate(
            ['studentID' => $jq->id, 'type' => '同事'],
            ['doneQuiz' => 1]
        );
        $forOther($o6->id, [
            13=>'D', 14=>'B', 15=>'A', 16=>'C', 17=>'B', 18=>'C',
            19=>'D', 20=>'A', 21=>'B', 22=>'C', 23=>'D', 24=>'B',
        ]);
        $o7 = other::updateOrCreate(
            ['studentID' => $jq->id, 'type' => '上級主管'],
            ['doneQuiz' => 1]
        );
        $forOther($o7->id, [
            13=>'C', 14=>'B', 15=>'B', 16=>'D', 17=>'A', 18=>'C',
            19=>'D', 20=>'A', 21=>'A', 22=>'C', 23=>'D', 24=>'B',
        ]);
    }
}
