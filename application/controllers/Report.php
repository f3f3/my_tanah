<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

defined('BASEPATH') OR exit('No direct script access allowed');
class Report extends CI_Controller {
    public function index()
    {
        $geojson = file_get_contents(FCPATH.'/upload/Indonesia_villages.json');
        $geojson = json_decode($geojson, true);

        $col_name = [
            "provinces"=>[],
            "districts"=>[],
            "sub_districts"=>[],
            "villages"=>[],
            "borders"=>[]
        ];

        $worksheet = [];
        $spreadsheet = new Spreadsheet();

        foreach($geojson["features"] as $id=>$val){
            $GID1 = substr($val["properties"]["GID_1"], 3, -2);
            $GID2 = substr($val["properties"]["GID_2"], 3, -2);
            $args = '/^'.preg_quote($GID1, '/').'/';
            $GID2 = preg_replace($args, "", $GID2, 1);
            $GID3 = substr($val["properties"]["GID_3"], 3, -2);
            $args = '/^'.preg_quote($GID1.$GID2, '/').'/';
            $GID3 = preg_replace($args, "", $GID3, 1);
            $GID4 = substr($val["properties"]["GID_4"], 3, -2);
            $args = '/^'.preg_quote($GID1.$GID2.$GID3, '/').'/';
            $GID4 = preg_replace($args, "", $GID4, 1);
            $GID1 = substr($GID1, 1);
            $GID2 = substr($GID2, 1);
            $GID3 = substr($GID3, 1);
            $GID4 = substr($GID4, 1);

            $col_name["provinces"][$val["properties"]["GID_1"]] = [
                "id"=>[$GID1],
                "value"=>$val["properties"]["NAME_1"]
            ];
            $col_name["districts"][$val["properties"]["GID_2"]] = [
                "id"=>[$GID1,$GID2],
                "value"=>$val["properties"]["NAME_2"]
            ];
            $col_name["sub_districts"][$val["properties"]["GID_3"]] = [
                "id"=>[$GID1,$GID2,$GID3],
                "value"=>$val["properties"]["NAME_3"]
            ];
            $col_name["villages"][$val["properties"]["GID_4"]] = [
                "id"=>[$GID1,$GID2,$GID3,$GID4],
                "value"=>$val["properties"]["NAME_4"]
            ];
            $col_name["borders"][$val["properties"]["GID_4"]] = [
                "id"=>[$GID1,$GID2,$GID3,$GID4],
                "value"=>json_encode($val["geometry"])
            ];
        }

        $worksheet['provinces'] = $spreadsheet->getSheet(0);
        $worksheet['provinces']->setTitle('provinces');

        foreach(array_keys($col_name) as $idx=>$col){
            if($col!='provinces'){
                $worksheet[$col] = $spreadsheet->createSheet();
                $worksheet[$col]->setTitle($col);
            }
            $num = 2;
            foreach($col_name[$col] as $id=>$row){
                $hg_s = 0;
                foreach($row["id"] as $a=>$b){
                    $worksheet[$col]->setCellValue(chr($hg_s+65)."1", "GID".(1+$hg_s));
                    $worksheet[$col]->getStyle(chr($hg_s+65)."1")->getNumberFormat()->setFormatCode('@');
                    $worksheet[$col]->setCellValue(chr($hg_s+65).$num, $b);
                    $worksheet[$col]->getStyle(chr($hg_s+65).$num)->getNumberFormat()->setFormatCode('@');
                    $hg_s++;
                }
                $worksheet[$col]->setCellValue(chr($hg_s+65)."1", $col);
                $worksheet[$col]->getStyle(chr($hg_s+65)."1")->getNumberFormat()->setFormatCode('@');
                $worksheet[$col]->setCellValue(chr($hg_s+65).$num, $row["value"]);
                $worksheet[$col]->getStyle(chr($hg_s+65).$num)->getNumberFormat()->setFormatCode('@');
                $num++;
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="product_template.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}