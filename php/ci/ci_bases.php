<?php
class ci_bases extends abm_ci
{
	protected $nombre_tabla = 'bases_convocatoria';
	
	function vista_pdf(toba_vista_pdf $salida)
	{
		//Cambio lo m�rgenes accediendo directamente a la librer�a PDF
		$pdf = $salida->get_pdf();
		$pdf->ezSetMargins(80, 50, 30, 30);    //top, bottom, left, right
				
		//Pie de p�gina
		$formato = 'P�gina {PAGENUM} de {TOTALPAGENUM}';
		$pdf->ezStartPageNumbers(300, 20, 8, 'left', $formato, 1);    //x, y, size, pos, texto, pagina inicio
		
		//Inserto los componentes usando la API de toba_vista_pdf
		//$salida->titulo($this->get_nombre());
		//$salida->mensaje('Nota: Este es el Principal');
		$this->dependencia('formulario')->vista_pdf($salida);
			
	}
}
?>