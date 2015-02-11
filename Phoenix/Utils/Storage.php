<?php
/**
 * Storage class.
 *
 * @version 1.2
 * @author MPI
 *
 */
class Storage {

    public static function exportFile($realName, $realPath, $exportName) {
        $fullFilePath = $realPath . $realName;
        $mimeType = self::getMimeType($fullFilePath);
        header("Content-Type: " . $mimeType);
        header("Content-Disposition: attachment; filename=\"" . $exportName . "\"");
        header("Content-Transfer-Encoding: binary");
        header("Accept-Ranges: bytes");
        header("Cache-Control: private");
        header("Pragma: private");
        header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
        readfile($fullFilePath);
    }

    public static function getMimeType($file) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $r = false;
        if (is_resource($finfo) === true) {
            $r = finfo_file($finfo, $file);
        }
        finfo_close($finfo);
        return $r;
    }
}
?>