<!DOCTYPE html>
<html>
<head>
    <title>後台管理</title>
</head>
<body>
<?php
use App\Models\answer;use App\Models\question;use Intervention\Image\Image;$Sid=1;
$answers=answer::where('studentID',$Sid)->get();
$S1=0;$S2=0;$S3=0;$S4=0;
foreach ($answers as $answer){
    $weight=question::find($answer->questionID);
    if($answer->answer=='A'){
        $S1=$S1+$weight->S1;
    }
    if ($answer->answer=='B'){
        $S2=$S2+$weight->S2;
    }
    if ($answer->answer=='C'){
        $S3=$S3+$weight->S3;
    }
    if ($answer->answer=='D'){
        $S4=$S4+$weight->S4;
    }
}
$sum=$S1+$S2+$S3+$S4;

$img = Image::make(public_path('Chart1.png'));
$img->text($S1, 420, 1260, function($font) {
    $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
    $font->size(36);
    $font->align('center');
    $font->valign('top');
});
$img->text($S2, 560, 1260, function($font) {
    $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
    $font->size(36);
    $font->align('center');
    $font->valign('top');
});
$img->text($S3, 690, 1260, function($font) {
    $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
    $font->size(36);
    $font->align('center');
    $font->valign('top');
});
$img->text($S4, 830, 1260, function($font) {
    $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
    $font->size(36);
    $font->align('center');
    $font->valign('top');
});
$img->text($sum, 830, 1400, function($font) {
    $font->file(public_path('OpenSans-SemiboldItalic.ttf'));
    $font->size(36);
    $font->align('center');
    $font->valign('top');
});
return ($img->response('png'));
?>
</body>
</html>
