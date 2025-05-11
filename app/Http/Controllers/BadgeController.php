<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use setasign\Fpdi\Fpdi;

class BadgeController extends Controller
{
    public function badge(Employee $employee)
    {
        $employee = Employee::find($employee);
        $templatePath = public_path('badge.pdf');
        $originalPhoto = storage_path("app/{$employee->profile_picture}");

        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'Template not found.'], 404);
        }

        if (!file_exists($originalPhoto)) {
            return response()->json(['error' => 'Profile picture not found.'], 404);
        }

        // Step 1: Create a circular PNG photo
        $circlePhoto = storage_path("app/temp/circle_{$employee->id}.png");
        $this->makeCircularPhoto($originalPhoto, $circlePhoto, 430);

        // Step 2: Create badge PDF
        $outputPath = storage_path("app/badge_employee_{$employee->id}.pdf");

        $pdf = new Fpdi();
        $pdf->AddPage();

        $pdf->setSourceFile($templatePath);
        $tpl = $pdf->importPage(1);
        $pdf->useTemplate($tpl);

        // Step 3: Overlay circular photo
        $pdf->Image($circlePhoto, 480, 1125, 430, 430);

        $pdf->Output($outputPath, 'F');

        return response()->file($outputPath)->deleteFileAfterSend(true);
    }

    private function makeCircularPhoto(string $inputPath, string $outputPath, int $size)
    {
        $src = imagecreatefromstring(file_get_contents($inputPath));
        $dst = imagecreatetruecolor($size, $size);

        // Enable transparency
        imagesavealpha($dst, true);
        $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
        imagefill($dst, 0, 0, $transparent);

        // Resize to square
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $size, $size, imagesx($src), imagesy($src));

        // Apply circular mask
        for ($x = 0; $x < $size; $x++) {
            for ($y = 0; $y < $size; $y++) {
                $dx = $x - $size / 2;
                $dy = $y - $size / 2;
                $distance = sqrt($dx * $dx + $dy * $dy);
                if ($distance > $size / 2) {
                    imagesetpixel($dst, $x, $y, $transparent);
                }
            }
        }

        imagepng($dst, $outputPath);
        imagedestroy($src);
        imagedestroy($dst);
    }
}
