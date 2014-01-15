<?php
header("Content-type: application/pdf");
echo $this->Pdf->Output(VANITY_OUTPUT_DIR."ibwt-Print.pdf");
?>