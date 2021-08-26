<?php
#Я сделал 2 варианта: 

#В 1 мы получаем в итоге изображение 200 на 100 пикселей, но оно будет обтянутым
#В 2 мы получаем изображение, где высота регулирется за счет деления

#В этом задании невозможно получить полное изображение не перетянутым,
#можно приблизить картинку, но тогда некоторые детали фотографии будут упущены

#Я считаю, что подобные моменты лучше регулировать при помощи html/css





// $size = GetImageSize ("image.jpg"); #получаем размеры картинки
// $source = ImageCreateFromJPEG ("image.jpg"); #источник картинки

// $width = $size[0]; 
// $height = $size[1]; 
 
// $new_height = 100; 
// $new_width = 200;

// $new_data = ImageCreateTrueColor ($new_width, $new_height); #создаем новое изображения со своими размерами

// ImageCopyResampled ($new_data, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

// ImageJPEG ($new_data, "new_photo.jpg", 100);
// imagedestroy($source); #удаление источника, чтобы не перегружать память


//     echo "<img src='new_photo.jpg'>";



// $size = GetImageSize ("image.jpg");

// $source = ImageCreateFromJPEG ("image.jpg");

// $width = $size[0];
// $height = $size[1];

// $koef = $width/200; #коэфф., который равен изначальной ширине, деленной на желаеммую ширину

// $new_height = $height/$koef; #новая высота

// $new_data = ImageCreateTrueColor (200, $new_height);

// ImageCopyResampled ($new_data, $source, 0, 0, 0, 0, 200, $new_height, $width, $height);

// ImageJPEG ($new_data, "new_photo2.jpg", 100);
// imagedestroy($source);

//     echo "<img src='new_photo2.jpg'>";
