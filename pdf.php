<?php
	include_once('header.php');
	include_once('database.php');
?>

<script>
	$(document).ready(function()
	{
		$('#menu li a').removeClass('active');
		$('#menu #performbillrun a').addClass('active');
		
		$('body').animate({scrollTop :450}, 2000);
	});	
	
  $(function() {
    $( "#datepicker" ).datepicker();
  });
	
</script>

<?php
require('C:\xampp\php\pear\fpdf\fpdf.php'); 

class PDF extends FPDF {
 
function Header() {
	//$this->Image("D:\logo.jpg", (4.5/2)-1.5, 0.5, 3, 1, "JPG","www.verizon.com");
	//$this->Image("D:\logo.jpg",170,8,30);
    $this->SetFont('Times','',14);
    $this->SetY(0.25);
	$this->Cell(0, .25, " Vz-BAAS ", 'T', 2, "C");
	$this->SetY(0.25);
    //reset Y
    $this->SetY(1);
}
 
function Footer() {
//This is the footer; it's repeated on each page.
//enter filename: phpjabber logo, x position: (page width/2)-half the picture size,
//y position: rough estimate, width, height, filetype, link: click it!
    //$this->Image("D:\logo.jpg", (4.5/2)-1.5, 9.8, 3, 1, "JPG","www.verizon.com");
}
 
}

$pdf=new PDF("P","in","Letter");
$pdf->SetMargins(1.5,1.5,1.5);
$pdf->AddPage();

$pdf->SetFont('Times','',12);

$pdf->Ln();
$pdf->Ln();


define('DB_HOST1', 'localhost'); 
define('DB_NAME1', 'testdb'); 
define('DB_USER1','root'); 
define('DB_PASSWORD1',''); 
$con=mysql_connect(DB_HOST1,DB_USER1,DB_PASSWORD1) or die("Failed to connect to MySQL: " . mysql_error());

mysql_select_db('testdb',$con) or die("Failed to connect to MySQL: " . mysql_error());

        $sql = "SELECT * from Address a, charge c where a.cust_name ='Test' and a.cust_name = c.cust_name";
        $result = mysql_query($sql);
		if (!$result) {
			ECHO "i AM HERE";
    printf("Error:sads %s\n", mysql_error($con));
    exit();
}
       
        while($rows=mysql_fetch_array($result))
        {
			$AccName = 'Account Name';
			$accname = $rows[0];
			$payment_date = $rows[12];
			$charge = $rows[7];
			$tax = $rows[9];
			$total = $rows[10];
			$addline1 = $rows[1];
			$addline2 = $rows[2];
			$addline3 = $rows[3];
			$addline4 = $rows[4];
			$Address = 'Address';
			$EffDate = $rows[11];
			$Line1="Monthly Charges as on ".$EffDate;
			$Line2="Tax applied @ 10% ";
			$Line3="Total Charges  ";
			
            $pdf->SetFillColor(240, 100, 100);
			$pdf->SetFont('Times','B',12);
			$pdf->Cell(0,.25, "Airtel bill for the month ".$EffDate, 1, 2, "C", 1);
			
			$pdf->SetFillColor(240, 100, 100);
			$pdf->SetFont('Times','B',12);
			  

			$pdf->Cell(0,.25, "Customer Details", 1, 2, "C", 1);
			  
			$pdf->SetFont('Times','',12);
			$pdf->Cell(0, 0.20, $AccName, 1, 0, 'L');
            $pdf->Cell(0, 0.20, $accname, 1, 1, 'R');
			$pdf->Cell(0, 0.20, $Address, 1, 0, 'L');
            //$pdf->Cell(0, 0.20, $address, 1, 1, 'R');
			$pdf->Cell(0, 0.20, $addline1, 1, 1, 'R');
			$pdf->Cell(0, 0.20, $addline2, 1, 1, 'R');
			$pdf->Cell(0, 0.20, $addline3, 1, 1, 'R');
			$pdf->Cell(0, 0.20, $addline4, 1, 1, 'R');
			$pdf->Cell(0, 0.20, "Payment Date", 1, 0, 'L');
            $pdf->Cell(0, 0.20, $payment_date , 1, 1, 'R');
						
			 $pdf->Multicell(0,1,"\n");
			  
			$pdf->SetFillColor(240, 100, 100);
			$pdf->SetFont('Times','B',12);
			  
			
			$pdf->Cell(0, .25, "Charge Details", 1, 2, "C", 1);
			  
			$pdf->SetFont('Times','',12);
			$pdf->Cell(0, 0.20, $Line1, 1, 0, 'L');
            $pdf->Cell(0, 0.20, $charge, 1, 1, 'R');
			$pdf->Cell(0, 0.20, $Line2, 1, 0, 'L');
            $pdf->Cell(0, 0.20, $tax, 1, 1, 'R');
			$pdf->Cell(0, 0.20, $Line3, 1, 0, 'L');
            $pdf->Cell(0, 0.20, $total, 1, 1, 'R');

        }
$filename = $_SERVER['DOCUMENT_ROOT'].'/pdf/'.$accname.".pdf";
$pdf->Output($filename,'F');
mysql_close($con);

?>

<?php include_once('footer.php'); ?>