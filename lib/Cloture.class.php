<?php
include_once('vendor/symfony/lib/helper/TextHelper.php');

class CloturePdf extends TCPDF {
	private $invoiceData;
	
	function __construct( $orientation, $unit, $format, $serveur = null, $cash = 0, $ecb = 0, $cb = 0, $nb_cash = 0, $nb_ecb = 0, $nb_cb = 0, $record = 0 ) {
		parent::__construct( $orientation, $unit, $format, true, 'UTF-8', false );
		$this->serveur = $serveur;
		$this->cash = $cash;
		$this->ecb = $ecb;
		$this->cb = $cb;
		$this->nb_cash = $nb_cash;
		$this->nb_ecb = $nb_ecb;
		$this->nb_cb = $nb_cb;
		$this->record = $record;
		# Set the page margins: 72pt on each side, 36pt on top/bottom.
		$this->SetMargins( 0, 0, 0, false );
		$this->SetAutoPageBreak( true, PDF_MARGIN_BOTTOM);
		//set image scale factor
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO); 
		
		//set some language-dependent strings
		global $l;
		$this->setLanguageArray($l);
		$this->SetPrintFooter(false);
		# Generate the invoice.
		$this -> CreateInvoice();
		$time = time();
		// repertoire de ou sont stockés les factures de manières temporaires.
		$location = sfConfig::get('sf_web_dir').'/uploads/cloture/'.$time.'.pdf';
		$this -> Output($location, 'F');
		// commmande pour imprimer de ticket, ici on utilise cups
		$commande = '/usr/bin/lp -d EPSON_TM_T20 '.$location;
		exec($commande, $output);
		unlink($location);
	}
	
	# Page header and footer code.
	public function Header() {
		global $webcolor;
		
		# The image is this much larger than the company name text.
		$bigFont = 14;
		$imageScale = ( 128.0 / 26.0 ) * $bigFont;
		$smallFont = 10;
		$this->ImagePngAlpha(sfConfig::get('sf_web_dir').'/uploads/facture/basse_cour.png', 0, 0, 220, 98, '', '', 'PNG', null, 'T', false, 72, 'L' );
		$this->SetY( 70, true );
		$this->SetFont('times', 'i', $smallFont );
		$this->setCellPaddings('10', 0 , 0, 0);
		$this->Cell( 0, 0, '', 0, 1 );
		$this->Cell( 0, 0, 'Place du marché aux légumes 12,', 0, 1 );
		$this->Cell( 0, 0, 'Namur, Belgique', 0, 1 );
		$this->Cell( 0, 0, '0496/79.78.10', 0, 1 );
		$this->Cell( 0, 0, 'TVA: BE0501.656.383', 0, 1 );
		$this->SetY( 0, true );
		$this->SetLineStyle( array( 'width' => 2, 'color' => array( $webcolor['black'] ) ) );
		$this->Line( 10, 135, $this->getPageWidth() - 72, 135 );
		
	}


	
	public function CreateInvoice() {
		$this->AddPage(array(100,100));
		$this->SetFont( 'helvetica', '', 10 );
		$this->SetY( 140, true );

		# Table parameters
		#
		# Column size, wide (description) column, table indent, row height.
		$col = 30;
		$wideCol = 3 * $col + 3;
		$indent = 5;

		$line = 18;

		# Table header
		$this->SetFont( '', 'b' );
		$this->Cell( 2 * $wideCol, $line, 'Total cash : ' . $this->cash, 10, 0, 'L' );
		$this->Ln();
		$this->Cell( 2 * $wideCol, $line, 'Total ecb : ' . $this->ecb, 0, 0, 'L' );
		$this->Ln();
		$this->Cell( 2 * $wideCol, $line, 'Total cb : ' . $this->cb, 0, 0, 'L' );
		$this->Ln();
		$this->Cell( 2 * $wideCol, $line, 'Transaction cash: ' . $this->nb_cash, 0, 0, 'L' );
		$this->Ln();
		$this->Cell( 2 * $wideCol, $line, 'Transaction ecb : ' . $this->nb_ecb, 0, 0, 'L' );
		$this->Ln();	
		$this->Cell( 2 * $wideCol, $line, 'Transaction cb : ' . $this->nb_cb, 0, 0, 'L' );
		$this->Ln();
		$this->Cell( 2 * $wideCol, $line, '----------------------------------------', 0, 0, 'L' );
		$this->Ln();
		$this->Cell( 2 * $wideCol, $line, 'Détenteur du record : ' . $this->serveur, 0, 0, 'L' );
		$this->Ln();
		$this->Cell( 2 * $wideCol, $line, 'Record : ' . $this->record, 0, 0, 'L' );
		$this->Ln();
	}
}