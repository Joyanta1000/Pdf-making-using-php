<?php

function fetch_data(){

$output = '';
$conn = mysqli_connect("localhost", "root", "", "pdfphp");
$sql = "SELECT * FROM user ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
	
	$output .= '<tr align="center">

	<td scope="row" >'.$row["id"].'</td>
	<td>'.$row["name"].'</td>
	<td>'.$row["age"].'</td>
	<td>'.$row["email"].'</td>

	</tr>';
}

return $output;

}

if (isset($_POST["generate_pdf"])) {
	
	require_once('tcpdf_min/tcpdf.php');
	$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$obj_pdf->SetCreator(PDF_CREATOR);
	$obj_pdf->SetTitle("Data PDF");
	$obj_pdf->SetHeaderData( '', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
	$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	$obj_pdf->SetDefaultMonospacedFont('helvetica');
	$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
	$obj_pdf->setPrintHeader(false);
	$obj_pdf->setPrintFooter(false);
	$obj_pdf->SetAutoPageBreak(TRUE, 10);
	$obj_pdf->SetFont('helvetica', '', 11);
	$obj_pdf->AddPage();
	$content = '';
	$content .= '
	<h4 align="center"> Data </h4> </br>
	<table align="center" width="100%" class="table table-dark" border="1" cellspacing = "0"	cellpadding = "3">
	<tr>
	<th scope="col">ID</th>
	<th scope="col">Name</th>
	<th scope="col">Age</th>
	<th scope="col">Email</th>
	</tr>
	';
	$content .= fetch_data();
	$content .= '</table>';
	$obj_pdf->writeHTML($content);
	$obj_pdf->Output('file.pdf','I');

}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>

<div>
  <form method="post">
  	<input type="submit" name="generate_pdf" class="btn btn-success" value="Generate PDF"/>
  </form>

<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Age</th>
      <th scope="col">Email</th>
    </tr>
  </thead>
  <tbody>
    <?php
    echo fetch_data();
    ?>
  </tbody>
</table>
</div>

</body>
</html>