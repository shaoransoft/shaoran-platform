<?php
/* Shaoran file manager framework 1.0 */
class FileManager {
  private static $extAllow = ['JPG', 'JPEG', 'PNG'];

	public function Upload($data) {
    $result['Uploaded'] = false;
    if ($data['Source']['name'] !== '') {
      $result['FileOriginal'] = $data['Source']['name'];
      $result['Size'] = $data['Source']['size'];
      $result['Ext'] = strtoupper(pathinfo($data['Source']['name'], PATHINFO_EXTENSION));
      if (in_array($result['Ext'], self::$extAllow)) {
        $result['File'] = isset($data['Name']) ? $data['Name'] : $this->GenerateName().'.'.$result['Ext'];
        if (ini_get('upload_max_filesize') <= $result['Size']) {
          @chmod($data['TargetPath'].$result['File'], 0755);
          switch ($result['Ext']) {
            case 'JPG':
            case 'JPEG':
            case 'PNG':
              $fileInfo = getimagesize($data['Source']['tmp_name']);
              if ($fileInfo === false)
                $result['Error'] = 'ไฟล์ดังกล่าวไม่ใช่รูปภาพ โปรดลองใหม่อีกครั้ง';
              else if ($fileInfo[2] !== IMAGETYPE_JPEG && $fileInfo[2] !== IMAGETYPE_PNG)
                $result['Error'] = 'เฉพาะไฟล์รูปภาพ JPG / JPEG / PNG ที่ได้รับอนุญาติเท่านั้น';
              else
                $result['Uploaded'] = @move_uploaded_file($data['Source']['tmp_name'], $data['TargetPath'].$result['File']);
              break;
            default:
                $result['Uploaded'] = @move_uploaded_file($data['Source']['tmp_name'], $data['TargetPath'].$result['File']);
              break;
          }
          if (!$result['Uploaded']) $result['Error'] = 'การอัพโหลดล้มเหลว โปรดลองใหม่อีกครั้ง';
        }
        else $result['Error'] = 'ไฟล์ดังกล่าวมีขนาดใหญ่เกินกว่าจะอัพโหลดได้';
      }
      else $result['Error'] = 'ประเภทไฟล์ดังกล่าวไม่ได้รับอนุญาติ เฉพาะ '.join($this->extAllow, ', ').' เท่านั้น';
    }
    else $result['Error'] = 'โปรดเลือกไฟล์ที่ต้องการอัพโหลด';
		return $result;
	}

  public function Remove($filePath) {
    return unlink($filePath);
  }

	public function GenerateName() {
		return date('YmdHis').rand(1000,9999);
	}
}
?>
