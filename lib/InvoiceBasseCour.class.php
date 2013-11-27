<?php
include_once('vendor/symfony/lib/helper/TextHelper.php');

class InvoiceBasseCour extends TCPDF {
	private $invoiceData;
	
	function __construct( $data ) {
		parent::__construct( 'P', 'pt', 'LETTER', true, 'UTF-8', false );
		$this->total = $data['total'];
		$this->invoiceData = $data['articles'];
		$this->serveur = $data['serveur'];
		$this->tableId = $data['table_id'];
		if(isset($data['bancontact']))
			$this->bancontact = $data['bancontact'];
		else
			$this->bancontact = 0;

		if(isset($data['cash']))
			$this->cash = $data['cash'];
		else
			$this->cash = 0;

		if(isset($data['cashback']))
			$this->cashback = $data['cashback'];
		else
			$this->cashback = 0;

		$this->printer = $data['printer'];
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
		$location = sfConfig::get('sf_web_dir').'/uploads/facture/'.$time.'.pdf';
		$this -> Output($location, 'F');
		// commmande pour imprimer de ticket, ici on utilise cups
		$commande = '/usr/bin/lp -d '.$data['printer'].' '.$location;
		exec($commande, $output);
		unlink($location);
	}
	
	# Page header and footer code.
	public function Header() {
		global $webcolor;
		
		# The image is this much larger than the company name text.
		$bigFont = 12;
		$imageScale = ( 128.0 / 26.0 ) * $bigFont;
		$smallFont = 8;
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
		$this->Cell( $indent );
		$this->Cell( $wideCol, $line, 'Item', 0, 0, 'L' );
		$this->Cell( $col, $line, 'Prix', 0, 0, 'R' );
		$this->Cell( $col * 2.5, $line, 'TOTAL', 0, 0, 'R' );
		$this->Ln();

		# Table content rows
		$this->SetFont( '', '' );
		foreach( $this->invoiceData as $item ) {
			$this->Cell( $indent );
			$this->Cell( $wideCol, $line, $item['count'].' x '.truncate_text ($item['name'], $length = 13, $truncate_string = '.'), 0, 0, 'L' );
			$this->Cell( $col, $line, $item['prix'].' €', 0, 0, 'R' );
			$this->Cell( $col * 2.5, $line, $item['prix'] * $item['count']. ' €', 0, 0, 'R' );
			$this->Ln();
			foreach($item['supplements'] as $supplement){
				$prix = $supplement['fois_prix'] * $item['prix'] - $item['prix'] + $supplement['plus_prix'];
				$this->Cell( $indent );
				$this->Cell( $wideCol, $line, '---'.truncate_text ($supplement['name'], $length = 13, $truncate_string = '.'), 0, 0, 'L' );
				$this->Cell( $col * 2.5 + $col, $line, $prix. ' €', 0, 0, 'R' );
				$this->Ln();				
			}
		}

		# Table Total row
		$this->SetFont( '', 'b' );
		$this->Cell( $indent );
		$this->Cell( $col * 4, $line, 'Total:', 0, 0, 'R' );
		$this->SetFont( '', '' );
		$this->Cell( $col * 2.5, $line, $this->total. ' €', 1, 0, 'R' );
		$this->Cell( $indent );
		$this->Ln();
		$this->Ln();

		if($this->cash>0){
			$this->Cell( $indent );
			$this->Cell( $col * 4, $line, 'Espèce : ', 0, 0, 'L' );
			$this->Cell( $col * 2.5, $line, $this->cash.' €', 0, 0, 'R' );
			$this->Ln();
		}
		if($this->bancontact>0){
			$this->Cell( $indent );
			$this->Cell( $col * 4, $line, 'Carte bancaire : ', 0, 0, 'L' );
			$this->Cell( $col * 2.5, $line, $this->bancontact.' €', 0, 0, 'R' );
			$this->Ln();
		}
		$rendu = $this->bancontact + $this->cash - $this->total;
		if($rendu >= 0){
			$this->Cell( $indent );
			$this->Cell( $col * 4, $line, 'Rendu : ', 0, 0, 'L' );
			$this->Cell( $col * 2.5, $line, $rendu.' €', 0, 0, 'R' );
			$this->Ln();
		}
		if($this->cashback>0){
			$this->Cell( $indent );
			$this->Cell( $col * 4, $line, 'Cashback : ', 0, 0, 'L' );
			$this->Cell( $col * 2.5, $line, $this->cashback.' €', 0, 0, 'R' );
			$this->Ln();
			$this->SetLineStyle( array( 'width' => 2, 'color' => array( $webcolor['black'] ) ) );
			$this->Line( 10, 90, $this->getPageWidth() - 72, 90 );
		}
		$this->Cell( $indent );
		$this->Cell( $col * 4, $line, 'Table : '.$this->tableId, 0, 0, 'L' );
		$this->Cell( $col * 2.5, $line, date("d-m-Y H:i:s"), 0, 0, 'R' );
		$this->Ln();		
		$this->Cell( $indent );
		$this->Cell( $col * 7, $line, 'Serveur : '.$this->serveur, 0, 0, 'L' );
		
		



	}
}