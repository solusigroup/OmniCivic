<?php

namespace App\Http\Controllers;

use OwenIt\Auditing\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index()
    {
        $audits = Audit::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('audit.index', compact('audits'));
    }
}
