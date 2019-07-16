<?php

namespace App\Exports;
use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PaacExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.paac', ['users' => User::get()]);
    }
}
