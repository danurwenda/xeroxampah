<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of SparseReaderFilter
 *
 * @author Dimas Y. Danurwenda
 */
class SparseReaderFilter implements PHPExcel_Reader_IReadFilter {

    //all to-read cell co-ordinate, including date row and id col
    private $_readRows = [];    // e.g [2,3,5,6,7,8,9]
    private $_readColumns = []; // e.g [A,B,C,E,F,G,Z,AA,AB]

    /** Get the list of rows and columns to read 
     * 
     * @param array $config isinya 4 elemen : 
     * $idColumn, misalnya A
     * $idRows, misalnya 2,3,5-7
     * $dateRow, misalnya 1
     * $dateColumns, misalnya E-G, J
     */

    public function __construct(array $config) {
        $idColumn = $config[0];
        $idRows = $config[1];
        $dateRow = $config[2];
        $dateColumns = $config[3];

        $this->_readColumns[] = $idColumn;
        $this->_readRows[] = $dateRow;

        //parse idRows
        $rowsRange = explode(',', $idRows);
        //setiap elemen $rowsRange berbentuk angka atau angka(dash)angka
        foreach ($rowsRange as $rs) {
            $rrs = explode('-', $rs);
            $c = count($rrs);
            if ($c > 1) {
                //range
                //ambil pertama dan terakhir
                $begin = $rrs[0];
                $end = $rrs[$c - 1];
                if ($begin > $end) {
                    //swap
                    $temp = $begin;
                    $begin = $end;
                    $end = $temp;
                }
                for ($i = $begin; $i <= $end; $i++) {
                    //add all
                    $this->_readRows[] = $i;
                }
            } else if ($c == 1) {
                $this->_readRows[] = $rrs[0];
            }
        }
        
        //parse idCols
        $colsRange = explode(',', $dateColumns);
        //setiap elemen $rowsRange berbentuk angka atau angka(dash)angka
        foreach ($colsRange as $rs) {
            $rrs = explode('-', $rs);
            $c = count($rrs);
            if ($c > 1) {
                //range
                //ambil pertama dan terakhir
                $begin = $rrs[0];
                $end = $rrs[$c - 1];
                if ($begin > $end) {
                    //swap
                    $temp = $begin;
                    $begin = $end;
                    $end = $temp;
                }
                for ($i = $begin; $i <= $end; $i++) {
                    //add all
                    $this->_readColumns[] = $i;
                }
            } else if ($c == 1) {
                $this->_readColumns[] = $rrs[0];
            }
        }
    }

    public function readCell($column, $row, $worksheetName = '') {
        return in_array($column, $this->_readColumns) && in_array($row, $this->_readRows);
    }

//put your code here
}
