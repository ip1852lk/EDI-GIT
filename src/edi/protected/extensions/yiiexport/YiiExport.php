<?php

/**
 * YiiExport utilizes a PHPExcel library to export data as CSV, Excel or PDF.
 *
 * @author JB
 */
class YiiExport extends CApplicationComponent
{

    const EXPORT_TYPE_CSV = 'csv';
    const EXPORT_TYPE_EXCEL = 'excel';
    const EXPORT_TYPE_PDF = 'pdf';
    const EXPORT_TYPE_TEXT = 'text';

    /**
     * Model to be used for populating data
     * @var CActiveRecord 
     */
    private $model;

    /**
     * Data to be exported.
     * @var array 
     */
    private $dataProvider;

    /**
     * Target file type
     * @var string 
     */
    private $exportType = 'excel';

    /**
     * Stream or save
     * @var boolean 
     */
    private $stream;

    /**
     * Base directory path to store an exported file
     * @var string 
     */
    public $basePath = '';

    /**
     * Base directory path to store an exported file
     * @var string 
     */
    private $mainPath = 'files';

    /**
     * Sub-directory path to store an exported file
     * @var type 
     */
    private $subPath = '';

    /**
     * File path to store an exported file
     * @var type 
     */
    private $filePath = '';

    /**
     * File name
     * @var type 
     */
    private $fileName = '';

    /**
     * Excel version
     * 
     * Excel2007
     *      xlsx: Excel (OfficeOpenXML) Spreadsheet
     *      xlsm: Excel (OfficeOpenXML) Macro Spreadsheet (macros will be discarded)
     *      xltx: Excel (OfficeOpenXML) Template
     *      xltm: Excel (OfficeOpenXML) Macro Template (macros will be discarded)
     * Excel5
     *      xls: Excel (BIFF) Spreadsheet
     *      xlt: Excel (BIFF) Template
     * OOCalc
     *      ods: Open/Libre Offic Calc
     *      ots: Open/Libre Offic Calc Template
     * SYLK
     *      slk
     * Excel2003XML
     *      xml
     * Gnumeric
     *      gnumeric
     * HTML
     *      htm
     *      html
     * Default
     *      csv
     * 
     * @var string 
     */
    private $extensionType = 'csv';

    /**
     * csv, xls, xlsx, or pdf
     * @var string 
     */
    private $extension;
    private $headerStyle;
    private $cellStyle;
    private $columns;

    /**
     * Initializes the application component.
     * This method is required by {@link IApplicationComponent} and is invoked by application.
     * If you override this method, make sure to call the parent implementation
     * so that the application component can be marked as initialized.
     */
    public function init()
    {
        require dirname(__FILE__) . '/vendors/phpexcel/PHPExcel.php';
        parent::init();
    }

    /**
     * Exports data as CSV, Excel, or PDF
     * @param CActiveRecord $model
     * @param boolean $stream
     * @param array $options
     * @return boolean true or file-path if exported. Otherwise, false.
     */
    public function exportData($model, $options = null)
    {
        $this->model = $model;
        if (isset($options)) {
            foreach ($options as $key => $value) {
                $this->{$key} = $value;
            }
        }
        if (!isset($this->dataProvider)) {
            if (isset($this->model)) {
                $search = $this->model->search();
                $search->setPagination(false);
                $this->dataProvider = $search->getData(true);
            }
            if (!isset($this->dataProvider) || is_null($this->dataProvider))
                $this->dataProvider = array();
        }
        if (!$this->stream) {
            if (file_exists($this->mainPath) === false) {
                try {
                    if (!mkdir($this->mainPath, 0755, true)) {
                        $this->log(CLogger::LEVEL_ERROR, 'The main path cannot be created.');
                        return false;
                    }
                } catch (Exception $e) {
                    $this->log(CLogger::LEVEL_ERROR, 'The main path cannot be created. [ERROR] ' . $e->getMessage());
                    return false;
                }
            }
            if (!is_dir($this->mainPath)) {
                $this->log(CLogger::LEVEL_ERROR, 'The main path is not a directory. [ERROR] ' . $this->mainPath);
                return false;
            }
            if (!isset($this->subPath) || strlen($this->subPath) == 0) {
                if ($this->exportType == self::EXPORT_TYPE_EXCEL) {
                    $this->subPath = 'excel' . DIRECTORY_SEPARATOR . date('Y_m_d_H_i');
                } elseif ($this->exportType == self::EXPORT_TYPE_CSV) {
                    $this->subPath = 'cvs' . DIRECTORY_SEPARATOR . date('Y_m_d_H_i');
                } elseif ($this->exportType == self::EXPORT_TYPE_PDF) {
                    $this->subPath = 'pdf' . DIRECTORY_SEPARATOR . date('Y_m_d_H_i');
                } else {
                    $this->subPath = 'temp' . DIRECTORY_SEPARATOR . date('Y_m_d_H_i');
                }
            }
            $this->filePath = $this->mainPath . DIRECTORY_SEPARATOR . $this->subPath;
            if (file_exists($this->filePath) === false) {
                try {
                    if (!mkdir($this->filePath, 0755, true)) {
                        $this->log(CLogger::LEVEL_ERROR, 'A file path cannot be created.');
                        return false;
                    }
                } catch (Exception $e) {
                    $this->log(CLogger::LEVEL_ERROR, 'A file path cannot be created. [ERROR] ' . $e->getMessage());
                    return false;
                }
            }
        }
        if (!isset($this->fileName) || strlen($this->fileName) == 0)
            $this->fileName = 'export';
        if ($this->exportType == self::EXPORT_TYPE_CSV || $this->exportType == self::EXPORT_TYPE_EXCEL) {
            return $this->excelExport();
        } elseif ($this->exportType == self::EXPORT_TYPE_PDF) {
            return $this->pdfExport();
        } elseif ($this->exportType == self::EXPORT_TYPE_TEXT) {
            return $this->textExport();
        } else {
            $this->log(CLogger::LEVEL_ERROR, 'The output file type is not specified.');
            return false;
        }
    }

    /**
     * Exports data as Excel.
     */
    private function excelExport()
    {
        $result = true;
        // Extension
        if ($this->extensionType == 'Excel2007') {
            $this->fileName .= isset($this->extension) ? '.' . $this->extension : '.xlsx';
        } elseif ($this->extensionType == 'Excel5') {
            $this->fileName .= isset($this->extension) ? '.' . $this->extension : '.xls';
        } elseif ($this->extensionType == 'csv') {
            $this->fileName .= isset($this->extension) ? '.' . $this->extension : '.csv';
        } else {
            $this->log(CLogger::LEVEL_ERROR, 'Extension type is not supported.');
            $result = false;
        }
        // File
        if (!$this->stream)
            $this->filePath .= DIRECTORY_SEPARATOR . $this->fileName;
        // Header & Cell Styles
        if (!isset($this->headerStyle))
            $this->headerStyle = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '000000')
                    )
                ),
                'font' => array(
                    'bold' => true
                )
            );
        if (!isset($this->cellStyle))
            $this->cellStyle = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '000000')
                    )
                )
            );
        // Columns
        if (!isset($this->columns)) {
            $this->columns = array();
            $allColumns = $this->model->getAttributes();
            foreach ($allColumns as $key => $value) {
                $this->columns[] = array(
                    'field' => $key,
                    'label' => $this->model->getAttributeLabel($key),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 25,
                    'value' => null,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                    'visible' => true,
                );
            }
            if (is_null($allColumns) || count($allColumns) == 0) {
                $this->log(CLogger::LEVEL_ERROR, 'No column is available.');
                $result = false;
            }
        } else {
            $valid = true;
            foreach ($this->columns as $column) {
                if (!isset($column['field']) || !isset($column['label'])) {
                    $valid = false;
                }
            }
            if (!$valid) {
                $this->log(CLogger::LEVEL_ERROR, 'An invalid column is provided. field and label attributes must be provided.');
                $result = false;
            }
        }
        if (isset($this->dataProvider)) {
            try {
                // PHPExcel instance
                $excel = new PHPExcel();
                PHPExcel_Cell::setValueBinder(new PHPExcel_Cell_AdvancedValueBinder());
                $excel->setActiveSheetIndex(0);
                $sheet = $excel->getActiveSheet();
                // Header
                $offset = 0;
                for ($column = 0; $column < count($this->columns); $column++) {
                    if (isset($this->columns[$column]['visible']) && !$this->columns[$column]['visible']) {
                        $offset++;
                    } else {
                        $sheet->getStyleByColumnAndRow($column-$offset, 1)->applyFromArray(isset($this->columns[$column]['headerStyle']) ? $this->columns[$column]['headerStyle'] : $this->headerStyle);
                        $sheet->getCellByColumnAndRow($column-$offset, 1)->setValueExplicit($this->columns[$column]['label'], PHPExcel_Cell_DataType::TYPE_STRING);
                        $sheet->getColumnDimensionByColumn($column-$offset)->setWidth(isset($this->columns[$column]['width']) ? $this->columns[$column]['width'] : 25);
                    }
                }
                // Rows
                for ($row = 0; $row < count($this->dataProvider); $row++) {
                    $offset = 0;
                    for ($column = 0; $column < count($this->columns); $column++) {
                        if (isset($this->columns[$column]['visible']) && !$this->columns[$column]['visible']) {
                            $offset++;
                        } else {
                            $value = $this->getValue($row, $column);
                            $sheet->getStyleByColumnAndRow($column-$offset, $row + 2)->applyFromArray(isset($this->columns[$column]['cellStyle']) ? $this->columns[$column]['cellStyle'] : $this->cellStyle);
                            $sheet->getCellByColumnAndRow($column-$offset, $row + 2)->setValueExplicit($value, isset($this->columns[$column]['type']) ? $this->columns[$column]['type'] : PHPExcel_Cell_DataType::TYPE_STRING);
                        }
                    }
                    $sheet->getRowDimension($row + 2)->setRowHeight(-1);
                }
                ob_end_clean();
                ob_start();
                $objWriter = PHPExcel_IOFactory::createWriter($excel, $this->extensionType);
                if ($this->stream) {
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . $this->fileName . '"');
                    header('Cache-Control: max-age=0');
                    $objWriter->save('php://output');
                    $excel->disconnectWorksheets();
                    $result = true;
                } else {
                    $objWriter->save($this->filePath);
                    $excel->disconnectWorksheets();
                    $result = Yii::app()->getBaseUrl(true).DIRECTORY_SEPARATOR.$this->mainPath.DIRECTORY_SEPARATOR.$this->subPath.DIRECTORY_SEPARATOR.$this->fileName;
                    $result = str_replace(DIRECTORY_SEPARATOR, '/', $result);
                    
                }
            } catch (Exception $e) {
                $this->log(CLogger::LEVEL_ERROR, 'PHPExcel Exception : ' . $e->getMessage());
                $result = false;
            }
        } else {
            $this->log(CLogger::LEVEL_ERROR, 'No data is provided.');
            $result = false;
        }
        return $result;
    }

    /**
     * TODO
     */
    private function pdfExport()
    {
        // TODO
        return false;
    }

    /**
     * TODO
     */
    private function textExport()
    {
        //TODO
        return false;
    }

    /**
     * Logs a message.
     * @param string $level
     * @param string $meesge
     * @return string Returns a log message.
     */
    private function log($level, $meesge)
    {
        Yii::log($meesge, $level, 'YiiExport');
        return $meesge;
    }

    private function getValue($r, $c)
    {
        $value = '';
        if (isset($this->columns) && isset($this->columns[$c]) && isset($this->dataProvider)) {
            $column = $this->columns[$c];
            $row = $this->dataProvider[$r];
            if (isset($column['value'])) {
                if (is_string($column['value'])) {
                    if (strlen($column['value']) > 0) {
                        if (is_array($row))
                            $eval = '$value = $row["'.$column['value'].'"];';
                        else
                            $eval = '$value = $row->'.$column['value'].';';
                    } else {
                        $eval = '$value = "";';
                    }
                } elseif (is_array($column['value'])) {
                    if (key_exists('attributes', $column['value'])) {
                        $separator = 
                            key_exists('separator', $column['value']) ? 
                            $column['value']['separator'] : 
                            ' ';
                        $eval = '';
                        $validator = '';
                        foreach ($column['value']['attributes'] as $attribute) {
                            if (is_string($attribute) && strlen($attribute) > 0) {
                                if (is_array($row)) {
                                    if (strlen($eval) > 0) $eval .= ".$validator.";
                                    $validator = '(strlen($row["'.$attribute.'"])>0?$separator:"")';
                                    $eval .= '$row["'.$attribute.'"]';
                                } else {
                                    if (strlen($eval) > 0) $eval .= ".$validator.";
                                    $validator = '(strlen($row->'.$attribute.')>0?$separator:"")';
                                    $eval .= '$row->'.$attribute;
                                }
                            }
                        }
                        if (strlen($eval) > 0) 
                            $eval = '$value = '.$eval.';';
                        else 
                            $eval = '$value = "";';
                        
                    } else {
                        $eval = '$value = "";';
                    }
                }
                @eval($eval);
                if ($value === null) $value = '';
            } else {
                if (is_array($row))
                    $value = $row[$column['field']];
                else
                    $value = $row->{$column['field']};
            }
            if (isset($column['itemAlias']) &&
                is_array($column['itemAlias']) &&
                isset($column['itemAlias']['class']) &&
                isset($column['itemAlias']['type'])) 
            {
                $class = $column['itemAlias']['class'];
                $type = $column['itemAlias']['type'];
                $value = $class::itemAlias($type, $value);
                if ($value === null) $value = '';
            }
            if (isset($column['formatter']) && 
                is_string($column['formatter']) && 
                strlen($column['formatter']) > 0) 
            {
                $eval = '$value = '.$column['formatter'].';';
                @eval($eval);
                if ($value === null) $value = '';
            }
        }
        return $value;
    }
}

?>
