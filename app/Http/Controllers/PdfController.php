<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Enterprise;
use App\Models\Leave;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class PdfController extends Controller
{

    private function overlayPdfWithTemplate($view,$data,$filename = 'document.pdf')
    {
        $templatePath = Enterprise::first()->document_template?'storage/'.Enterprise::first()->document_template:'' ;

        // Generate PDF with DomPDF
        $dompdf = Pdf::loadView($view, $data)->setPaper('A4');
        $generatedPdfPath = storage_path('app/temp_generated.pdf');
        file_put_contents($generatedPdfPath, $dompdf->output());

        // If template doesn't exist, just return the generated PDF
        if (!file_exists($templatePath)) {
            return response()->file($generatedPdfPath)->deleteFileAfterSend(true);
        }

        // Continue with overlay if template exists
        $finalPdfPath = storage_path("app/final_$filename");

        $fpdi = new Fpdi();
        $fpdi->AddPage();

        // Import background
        $templateId = $fpdi->setSourceFile($templatePath);
        $tpl1 = $fpdi->importPage(1);
        $fpdi->useTemplate($tpl1);

        // Import overlay (generated) PDF
        $overlayId = $fpdi->setSourceFile($generatedPdfPath);
        $tpl2 = $fpdi->importPage(1);
        $fpdi->useTemplate($tpl2, 0, 0);

        // Save final PDF
        $fpdi->Output($finalPdfPath, 'F');

        // Cleanup
        @unlink($generatedPdfPath);

        return response()->file($finalPdfPath)->deleteFileAfterSend(true);
    }

    public function attestation_de_travail(Request $request, Employee $employee)
    {
        $enterprise = Enterprise::first();

        return $this->overlayPdfWithTemplate('documents.attestation_travail',compact('employee', 'enterprise'),'attestation_de_travail.pdf');
    }

    public function attestation_de_stage(Request $request, Employee $employee)
    {
        $super = User::first();
        $enterprise = Enterprise::first();
        // $pdf = Pdf::loadView('documents.attestation_stage', compact('employee', 'enterprise', 'super'))->setPaper('A4');
        // return $pdf->stream('attestation_de_stage.pdf');
        return $this->overlayPdfWithTemplate('documents.attestation_stage',compact('employee', 'enterprise', 'super'),'attestation_de_stage.pdf');
    }

    public function attestation_de_conges(Request $request, Leave $leave)
    {
        $employee = $leave->employee;
        $enterprise = Enterprise::first();
        // $pdf = Pdf::loadView('documents.attestation_conges', compact('employee', 'enterprise', 'leave'))->setPaper('A4');
        // return $pdf->stream('attestation_de_conges.pdf');

        return $this->overlayPdfWithTemplate('documents.attestation_conges',compact('employee', 'enterprise', 'leave'),'attestation_de_conges.pdf');

    }

    public function attestation_de_salaire(Request $request, Employee $employee)
    {
        $enterprise = Enterprise::first();
        // $pdf = Pdf::loadView('documents.attestation_salaire', compact('employee', 'enterprise'))->setPaper('A4');

        // return $pdf->stream('attestation_de_salaire.pdf');

        return $this->overlayPdfWithTemplate('documents.attestation_salaire',compact('employee', 'enterprise'),'attestation_de_salaire.pdf');

    }

    public function attestation_de_mission(Request $request, Employee $employee)
    {
        $enterprise = Enterprise::first();
        // $pdf = Pdf::loadView('documents.attestation_mission', compact('employee', 'enterprise'))->setPaper('A4');

        // return $pdf->stream('attestation_de_mission.pdf');

        return $this->overlayPdfWithTemplate('documents.attestation_mission',compact('employee', 'enterprise'),'attestation_de_mission.pdf');

    }

    public function bulltin_paie(Request $request, Employee $employee)
    {
        $enterprise = Enterprise::first();
        $payments = $employee->payments;
        // $pdf = Pdf::loadView('documents.bulletin_paie', compact('employee', 'enterprise', 'payments'))->setPaper('A4');

        // return $pdf->stream('bulletin_paie.pdf');

        return $this->overlayPdfWithTemplate('documents.bulletin_paie',compact('employee', 'enterprise', 'payments'),'bulletin_paie.pdf');

    }
}
