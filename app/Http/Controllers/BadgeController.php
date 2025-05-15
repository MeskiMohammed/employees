<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use setasign\Fpdi\Fpdi;


class BadgeController extends Controller
{
    public function badge(Employee $employee)
    {
        // $employee = Employee::find($employee);
        $templatePath = public_path('badge.pdf');
        $originalPhoto = storage_path("app/public/{$employee->profile_picture}");

        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'Template not found.'], 404);
        }

        if (!file_exists($originalPhoto)) {
            return response()->json(['error' => 'Profile picture not found.'], 404);
        }

        // Step 1: Create a circular PNG photo
        $circlePhoto = storage_path("app/temp/circle_{$employee->id}.png");
        $this->makeCircularPhoto($originalPhoto, $circlePhoto, 1080);

        // Step 2: Create badge PDF
        $outputPath = storage_path("app/badge_employee_{$employee->id}.pdf");

        $pdf = new Fpdi();
        $pdf->AddPage();

        $pdf->setSourceFile($templatePath);
        $tpl = $pdf->importPage(1);
        $pdf->useTemplate($tpl);

        // Step 3: Overlay circular photo
        $pdf->Image($circlePhoto,  41.2, 95.9, 35.3, 35.3);

        $pdf->SetFont('arial','',20);
        $pdf->SetTextColor(255,255,255);
        $Wtext = $pdf->GetStringWidth(ucfirst($employee->user->first_name));
        $pdf->Text(13.4+90.9/2-$Wtext/2,147,ucfirst($employee->user->first_name));

        $Wtext = $pdf->GetStringWidth(ucfirst($employee->user->last_name));
        $pdf->Text(13.4+90.9/2-$Wtext/2,155,ucfirst($employee->user->last_name));

        $pdf->SetFont('arial','',12);
        $pdf->SetTextColor(210,171,68);

        $Wtext = $pdf->GetStringWidth(strtoupper($employee->cin));
        $pdf->Text(13.4+90.9/2-$Wtext/2,163,strtoupper($employee->cin));

        $Wtext = $pdf->GetStringWidth($employee->cnss);
        $pdf->Text(13.4+90.9/2-$Wtext/2,171,$employee->cnss);
        $pdf->SetFont('arial','',8);
        $pdf->Text(13.4+90.9/2+$Wtext/2,171,'(cnss)');
        $pdf->SetFont('arial','',12);

        $Height = 171;
        foreach($employee->employeeDepartments as $empdep){
            $Height += 8;
            $Wtext = $pdf->GetStringWidth($empdep->department->name);
            $pdf->Text(13.4+90.9/2-$Wtext/2,$Height,$empdep->department->name);
        }

        $Wtext = $pdf->GetStringWidth(strtoupper($employee->typeEmployees->last()->type->type));
        $pdf->Text(13.4+90.9/2-$Wtext/2,139,strtoupper($employee->typeEmployees->last()->type->type));

        $Wtext = $pdf->GetStringWidth($employee->employee_code);
        $pdf->Text(210-13.1-90.9/2-$Wtext/2,162,$employee->employee_code);

        $pdf->Output($outputPath, 'F');

        return response()->file($outputPath)->deleteFileAfterSend(true);
    }

    private function makeCircularPhoto(string $inputPath, string $outputPath, int $size)
    {
        $filename = dirname($outputPath);
        if (!is_dir($filename)) {
            mkdir($filename, 0755, true);
        }

        $src = imagecreatefromstring(file_get_contents($inputPath));
        $srcWidth = imagesx($src);
        $srcHeight = imagesy($src);

        $resized = imagecreatetruecolor($size, $size);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
        imagefilledrectangle($resized, 0, 0, $size, $size, $transparent);

        // Resize source image into target
        imagecopyresampled($resized, $src, 0, 0, 0, 0, $size, $size, $srcWidth, $srcHeight);

        // Create circular mask
        $mask = imagecreatetruecolor($size, $size);
        $black = imagecolorallocate($mask, 0, 0, 0);
        $white = imagecolorallocate($mask, 255, 255, 255);
        imagefilledrectangle($mask, 0, 0, $size, $size, $black);
        imagefilledellipse($mask, $size / 2, $size / 2, $size, $size, $white);

        // Apply mask
        for ($x = 0; $x < $size; $x++) {
            for ($y = 0; $y < $size; $y++) {
                $alpha = (imagecolorat($mask, $x, $y) & 0xFF) == 255 ? 0 : 127;
                $rgb = imagecolorat($resized, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $color = imagecolorallocatealpha($resized, $r, $g, $b, $alpha);
                imagesetpixel($resized, $x, $y, $color);
            }
        }

        imagepng($resized, $outputPath);
        imagedestroy($src);
        imagedestroy($resized);
        imagedestroy($mask);
    }

}
