<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function download(Attachment $attachment)
    {
        $usr = $attachment->typeEmployee->employee->user;
        $name = $usr->first_name.' '.$usr->last_name;
        return Storage::disk('public')->download($attachment->attachment, $name.' '.$attachment->name.'.'.pathinfo($attachment->attachment,PATHINFO_EXTENSION));
    }
}
