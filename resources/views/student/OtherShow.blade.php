@extends('layouts.quiz')

@section('title', '他評作答結果')

@section('content')

<div class="text-center mb-4">
    <h2 class="font-weight-bold mb-1" style="color: var(--color-primary); font-size: 1.4rem;">
        他評作答結果
    </h2>
    <p class="text-muted mb-0" style="font-size: 0.875rem;">Others' Response Details</p>
</div>

<div class="card">
    <div class="card-header">各題作答記錄</div>
    <div class="table-responsive">
        @if($answers->isEmpty())
            <div class="text-center py-4 text-muted" style="font-size: 0.875rem;">尚無作答記錄</div>
        @else
            <table class="table table-hover mb-0">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th style="font-size: 0.8rem; color: var(--color-muted); font-weight: 600; border-top: none; padding: 0.75rem 1.25rem; width: 60%;">題目</th>
                        <th style="font-size: 0.8rem; color: var(--color-muted); font-weight: 600; border-top: none;">作答</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($answers as $answer)
                        <tr>
                            <td style="padding: 0.85rem 1.25rem; vertical-align: middle; color: var(--color-muted); font-size: 0.875rem;">
                                第 {{ $answer->questionID - 12 }} 題
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="badge badge-pill"
                                      style="background: var(--color-primary); color: #fff; font-size: 0.9rem; padding: 0.4em 0.9em; font-weight: 700;">
                                    {{ $answer->answer }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<div class="mt-4">
    <button type="button" onclick="history.back()" class="btn btn-outline-secondary">
        &larr; 返回
    </button>
</div>

@include('sweetalert::alert')

@endsection
