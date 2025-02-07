<?php

namespace App\Helpers;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGenerator
{
    public static function generate($html, $filename = 'document.pdf', $options = [])
    {
        // Configure Dompdf options
        $dompdfOptions = new Options();
        $dompdfOptions->set('isHtml5ParserEnabled', true);
        $dompdfOptions->set('isRemoteEnabled', true);
        $dompdfOptions->set('isPhpEnabled', true);
        $dompdfOptions->setChroot(__DIR__);

        // Create an instance of Dompdf
        $dompdf = new Dompdf($dompdfOptions);

        // Wrap the HTML content with header and footer

        // Load HTML content
        $dompdf->loadHtml($html);

        // (Optional) Set the paper size and orientation
        $dompdf->setPaper('A4', $options['orientation'] ?? 'portrait');

        // Render the PDF
        $dompdf->render();


        // Output the generated PDF in the browser (inline view)
        $dompdf->stream($filename, ["Attachment" => 0]); // 0 for inline view
    }

    
}
