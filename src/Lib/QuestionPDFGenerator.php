<?php

namespace App\VoteIt\Lib;

class QuestionPDFGenerator extends FPDF{
// En-tête
    function Header()
    {
        // Logo
        $this->Image('assets/logo/logoSansOmbre.png',10,6,30);
        // Police Arial gras 15
        $this->SetFont('Arial','B',15);
        // Décalage à droite
        $this->Cell(80);
        // Titre
        $this->Cell(30,10,'VoteIt',1,0,'C');
        // Saut de ligne
        $this->Ln(30);
    }

// Pied de page
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial','I',8);
        // Numéro de page
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}