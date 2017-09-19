<?php
$id_aspirante = $_POST['id_aspirante'];

$ImagesDir = 'images/';
$max_image_size = 4000000;

//$ImageName = $id_aspirante.'_'.str_replace(' ','-',strtolower($_FILES['mFile']['name']));
$ImageSize = $_FILES['mFile']['size'];
$ImageTmp = $_FILES['mFile']['tmp_name'];
$ImageType = $_FILES['mFile']['type'];

switch(strtolower($ImageType)) {
    case 'image/png':
        $images_orig =  imagecreatefrompng($ImageTmp);
	   $ext = '.png';
        break;
    case 'image/gif':
        $images_orig =  imagecreatefromgif($ImageTmp);
	   $ext = '.gif';
        break;
    case 'image/jpeg':
    case 'image/pjpeg':
        $images_orig = imagecreatefromjpeg($ImageTmp);
	   $ext = '.jpg';
        break;
    default:
        die('Unsupported File!'); //output error and exit
}
$ImageName = 'image_'.$id_aspirante.'_'.rand(0,99).$ext;
//list($CurWidth,$CurHeight)=getimagesize($ImageTmp);

if(trim($ImageTmp) != "") {  
    $images = $ImageTmp;  
//    $new_images = "Thumbnails_".$id_aspirante."_".$ImageName;  
//    $new_images = "image_".$ImageName;
    
    $path = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/includes'));
    $upload_path = $_SERVER['DOCUMENT_ROOT'].$path.'/archivos_adjuntos/fotos/';
    
    $new_images = 'tmb_'.$id_aspirante.'_'.rand(0,99).$ext;  
    if (file_exists($upload_path.$ImageName)){
        unlink($upload_path.$ImageName);
    }
    if (file_exists($upload_path.$new_images)){
        unlink($upload_path.$new_images);
    }
    copy($ImageTmp, $upload_path.$ImageName);  
    //$width=100; //*** Fix Width & Heigh (Autu caculate) ***//  
    $width = 150;
    $height = 150;
    //$size=GetimageSize($images);
    list($ancho_orig, $alto_orig) = getimagesize($images);

    $ratio_orig = $ancho_orig/$alto_orig;

    $height=round($width*$ancho_orig/$alto_orig);
    $dx = 0;
    $dy = 0;
    if($ancho_orig > $alto_orig){
    //if($width/$height > $ratio_orig){
            $width = $height*$ratio_orig;
            $dx = (150 - $width)/2;
        } else {
            $height = $width/$ratio_orig;
            $dy = (150 - $height)/2;
    }

    //$images_orig = ImageCreateFromJPEG($images);  
    $photoX = ImagesX($images_orig);  
    $photoY = ImagesY($images_orig);  
    $images_fin = ImageCreateTrueColor(150, 150);  
    ImageCopyResampled($images_fin, $images_orig, $dx, $dy, 0, 0, $width, $height, $photoX, $photoY);  
    
    ImageJPEG($images_fin, $upload_path.$new_images);  
    ImageDestroy($images_orig);  
    ImageDestroy($images_fin);  
//    unlink('includes/images/'.$ImageName);
//    echo $ImageName;
    echo "<img src='archivos_adjuntos/fotos/".$new_images."' width=150 height=150 />";
    echo "<input id='id_foto' type='hidden' value='".$new_images."' />";
} 
?>