<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Define a Read Filter class implementing PHPExcel_Reader_IReadFilter
 * This filter will read file in a chunk, maximal 2 column at once.
 * The first column will be the column that contains list of ID's
 * The second column will be the one that contains data          
 *   */
class StandardExcelReadFilter implements PHPExcel_Reader_IReadFilter {

    private $_idsColumn = 0;
    private $_idStartRow = 0;
    private $_idEndRow = 0;
    private $_timeRow = 0;
    private $_dataStartColumn = 0;
    private $_dataEndColumn = 0;

    /**  Set the list of rows that we want to read  */
    public function setIDRowsRange($startRow, $endRow) {
        if ($startRow < $endRow) {
            $this->_idStartRow = $startRow;
            $this->_idEndRow = $endRow;
        } else {
            $this->_idStartRow = $endRow;
            $this->_idEndRow = $startRow;
        }
    }

    public function setDataColumnsRange($startCol, $endCol) {
        if ($startCol < $endCol) {
            $this->_dataStartColumn = $startCol;
            $this->_dataEndColumn = $endCol;
        } else {
            $this->_dataStartColumn = $endCol;
            $this->_dataEndColumn = $startCol;
        }
    }

    public function setTimesRow($timerow) {
        $this->_timeRow = $timerow;
    }

    public function setIDsColumn($idscolumn) {
        $this->_idsColumn = $idscolumn;
    }

    public function readCell($column, $row, $worksheetName = '') {
        //  Only read the IDs column, and the data column, where row in range
        if (
                ($row == $this->_timeRow)             //row is row of time
                || //or
                (
                ($row >= $this->_idStartRow)              //row in range
                &&
                ($row <= $this->_idEndRow)                //row in range
                )
        ) {
            $colIdx = PHPExcel_Cell::columnIndexFromString($column) - 1;
            if ($colIdx == $this->_idsColumn || ($this->_dataStartColumn <= $colIdx && $colIdx <= $this->_dataEndColumn)) {
                return true;
            }
        }
        return false;
    }

}

?>
