<?php

namespace App\Services;

use ZipArchive;

/**
 * Minimal, dependency-free XLSX writer.
 *
 * Generates a real Excel 2007+ (.xlsx) file (a ZIP of XML parts) with a
 * styled bold header row, so no external package (maatwebsite/excel etc.)
 * is required.
 */
class XlsxExport
{
    /**
     * @param  array<int, string>  $headings  Column headings.
     * @param  array<int, array<int, mixed>>  $rows  Data rows (strings / numbers / nulls).
     * @param  string  $sheetName  Worksheet name (max 31 chars, no []:*?/\).
     */
    public static function download(array $headings, array $rows, string $filename, string $sheetName = 'Sheet1'): void
    {
        $sheetName = substr(preg_replace('/[\[\]\:\*\?\/\\\\]/', '', $sheetName) ?: 'Sheet1', 0, 31) ?: 'Sheet1';

        $tmp = tempnam(sys_get_temp_dir(), 'xlsx_');

        $zip = new ZipArchive;
        if ($zip->open($tmp, ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Unable to build the Excel file.');
        }

        $zip->addFromString('[Content_Types].xml', self::contentTypesXml());
        $zip->addFromString('_rels/.rels', self::rootRelsXml());
        $zip->addFromString('xl/workbook.xml', self::workbookXml($sheetName));
        $zip->addFromString('xl/_rels/workbook.xml.rels', self::workbookRelsXml());
        $zip->addFromString('xl/styles.xml', self::stylesXml());
        $zip->addFromString('xl/worksheets/sheet1.xml', self::sheetXml($headings, $rows));
        $zip->close();

        if (app()->runningUnitTests()) {
            unlink($tmp);
            return;
        }

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        readfile($tmp);
        unlink($tmp);
        exit;
    }

    /**
     * Build the worksheet XML (header row + data rows, inline strings).
     */
    private static function sheetXml(array $headings, array $rows): string
    {
        $cols = count($headings);

        // Pre-compute auto column widths.
        $widths = [];
        for ($i = 0; $i < $cols; $i++) {
            $max = mb_strlen((string) $headings[$i]) + 4;
            foreach ($rows as $row) {
                $max = max($max, mb_strlen((string) ($row[$i] ?? '')) + 2);
            }
            $widths[] = min(max($max, 10), 60);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
            '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'.
            '<cols>';

        foreach ($widths as $i => $width) {
            $xml .= '<col min="'.($i + 1).'" max="'.($i + 1).'" width="'.$width.'" customWidth="1"/>';
        }
        $xml .= '</cols><sheetData>';

        // Header row (style 1 = bold white on indigo).
        $xml .= '<row r="1">';
        foreach ($headings as $i => $heading) {
            $xml .= '<c r="'.self::cell($i, 1).'" s="1" t="inlineStr"><is><t xml:space="preserve">'.
                self::escape((string) $heading).'</t></is></c>';
        }
        $xml .= '</row>';

        // Data rows.
        foreach ($rows as $rIndex => $row) {
            $r = $rIndex + 2;
            $xml .= '<row r="'.$r.'">';

            foreach ($headings as $i => $heading) {
                $value = $row[$i] ?? '';
                $ref = self::cell($i, $r);

                if (is_int($value) || is_float($value)) {
                    $xml .= '<c r="'.$ref.'" s="2"><v>'.$value.'</v></c>';
                } else {
                    $xml .= '<c r="'.$ref.'" s="2" t="inlineStr"><is><t xml:space="preserve">'.
                        self::escape((string) $value).'</t></is></c>';
                }
            }

            $xml .= '</row>';
        }

        $xml .= '</sheetData></worksheet>';

        return $xml;
    }

    /** 0-based column index + 1-based row -> "A1" style reference. */
    private static function cell(int $index, int $row): string
    {
        $letter = '';
        $i = $index;

        while ($i >= 0) {
            $letter = chr(($i % 26) + 65).$letter;
            $i = intdiv($i, 26) - 1;
        }

        return $letter.$row;
    }

    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    private static function contentTypesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
            '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'.
            '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'.
            '<Default Extension="xml" ContentType="application/xml"/>'.
            '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'.
            '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'.
            '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'.
            '</Types>';
    }

    private static function rootRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'.
            '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'.
            '</Relationships>';
    }

    private static function workbookXml(string $sheetName): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
            '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '.
            'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'.
            '<sheets><sheet name="'.self::escape($sheetName).'" sheetId="1" r:id="rId1"/></sheets>'.
            '</workbook>';
    }

    private static function workbookRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'.
            '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'.
            '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'.
            '</Relationships>';
    }

    /**
     * Style 0 = default, 1 = header (bold white on indigo), 2 = body (bordered).
     */
    private static function stylesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.
            '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'.
            '<fonts count="3">'.
            '<font><sz val="11"/><name val="Calibri"/></font>'.
            '<font><b/><color rgb="FFFFFFFF"/><sz val="11"/><name val="Calibri"/></font>'.
            '<font><sz val="11"/><name val="Calibri"/></font>'.
            '</fonts>'.
            '<fills count="3">'.
            '<fill><patternFill patternType="none"/></fill>'.
            '<fill><patternFill patternType="gray125"/></fill>'.
            '<fill><patternFill patternType="solid"><fgColor rgb="FF4F46E5"/><bgColor indexed="64"/></patternFill></fill>'.
            '</fills>'.
            '<borders count="2">'.
            '<border><left/><right/><top/><bottom/><diagonal/></border>'.
            '<border><left style="thin"><color rgb="FFE3E4EC"/></left><right style="thin"><color rgb="FFE3E4EC"/></right><top style="thin"><color rgb="FFE3E4EC"/></top><bottom style="thin"><color rgb="FFE3E4EC"/></bottom><diagonal/></border>'.
            '</borders>'.
            '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'.
            '<cellXfs count="3">'.
            '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'.
            '<xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="center"/></xf>'.
            '<xf numFmtId="0" fontId="2" fillId="0" borderId="1" xfId="0" applyFont="1" applyBorder="1"/>'.
            '</cellXfs>'.
            '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'.
            '</styleSheet>';
    }
}
