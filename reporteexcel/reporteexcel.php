<?php
    if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');

    /** Se agrega la libreria PHPExcel */
    require_once 'lib/PHPExcel/PHPExcel.php';

    // Se crea el objeto PHPExcel
    $objPHPExcel = new PHPExcel();
    
    $recibido = stripcslashes($_POST['datos']);
    $rec = urldecode($recibido);
    $datosRecibidos = unserialize($rec);

    //$datosRecibidos= array(array('Amegino','Pedro','DNI','13457623','adsa23'));//$_POST;
    //apellido, nombre, tipo , nro documento, clave
    // Se asignan las propiedades del libro
    $objPHPExcel->getProperties()->setCreator("SICSE") // Nombre del autor
        ->setLastModifiedBy("Consultor") //Ultimo usuario que lo modificó
        ->setTitle("Reporte Excel Candidatos con clave") // Titulo
        ->setSubject("Reporte Excel Candidatos con clave") //Asunto
        ->setDescription("Reporte de candidatos") //Descripción
        ->setKeywords("reporte candidatos claves") //Etiquetas
        ->setCategory("Reporte excel"); //Categorias


    $tituloReporte = "Candidatos con sus claves";
    $titulosColumnas = array('APELLIDO', 'NOMBRE', 'TIPO_DOCUMENTO', 'NRO_DOCUMENTO', 'CLAVE');
		
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
						
    // Se agregan los titulos del reporte
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1',$tituloReporte) // Titulo del reporte
        ->setCellValue('A3',  $titulosColumnas[0])  //Titulo de las columnas
        ->setCellValue('B3',  $titulosColumnas[1])
        ->setCellValue('C3',  $titulosColumnas[2])
        ->setCellValue('D3',  $titulosColumnas[3])
        ->setCellValue('E3',  $titulosColumnas[4]);

    //Se agregan los datos de los CANDIDATOS
     $i = 4; //Numero de fila donde se va a comenzar a rellenar
    foreach($datosRecibidos as $datos) { //'nrocandidato';
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $datos['apellido'])
            ->setCellValue('B'.$i, $datos['nombre'])
            ->setCellValue('C'.$i, $datos['tipodocumento'])
            ->setCellValue('D'.$i, $datos['nrodocumento'])             
            ->setCellValue('E'.$i, $datos['clave']);
            $i++;
    }
		
    $estiloTituloReporte = array('font' => array('name' => 'Verdana',
                                'bold' => true,
                                'italic' => false,
                                'strike' => false,
                                'size' =>16,
                                'color' => array( 'rgb' => 'FFFFFF' )),
                                'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('argb' => 'FF220835')),
                                'borders' => array(
                                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_NONE )), 
                                'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap' => TRUE));
                                $estiloTituloColumnas = array('font' => array(
                                'name'      => 'Arial',
                                'bold'      => true,                          
                                'color'     => array(
                                'rgb' => 'FFFFFF')),
                                'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
                                'startcolor' => array(
                                'rgb' => 'c47cf2'),
                                'endcolor'   => array(
                                'argb' => 'FF431a5d')),
                                'borders' => array(
                                'top'     => array(
                                'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                                'color' => array(
                                'rgb' => '143860')),
                                'bottom'     => array(
                                'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                                'color' => array(
                                'rgb' => '143860'))),
                                'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'wrap'          => TRUE
    		));
			
    $estiloInformacion = new PHPExcel_Style();
    $estiloInformacion->applyFromArray(
			array( 'font' => array(
                                'name'      => 'Arial',               
                                'color'     => array(
                                'rgb' => '000000')),
                                'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'		=> array('argb' => 'FFd9b7f4')),
                                'borders' => array(
                                'left'     => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN ,
                                'color' => array(
                                'rgb' => '3a2a47'
                                )))));
		 
    /***********************end of the ccs // APLICANDO EL FORMATO*************************/

    $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:E".($i-1));
    //procedemos a asignar el ancho de las columnas
    for($i = 'A'; $i <= 'E'; $i++){
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
    }
    // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Candidatos');
 
    // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);
    // Inmovilizar paneles 
    //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
    //$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

    // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reportedealumnos.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
    
?>