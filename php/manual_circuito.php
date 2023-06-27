<?php
/*buscar el archivo pdf y descargarlo */
header("Content-type:application/pdf");
// It will be called downloaded.pdf
header("Content-Disposition:attachment;filename=Manual_Circuito_Proyectos_de_Extension.pdf");
// The PDF source is in original.pdf
readfile("./Manual_Circuito_Proyectos_de_Extension.pdf");
?>