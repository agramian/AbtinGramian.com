<?if(!defined('BASEPATH'))header('HTTP/1.1 403 Forbidden');?>[<?$currentRow=0;foreach($query->result()as$row){if($currentRow>0){echo',';}echo'{';echo'"category":"'.$row->category.'",';if($row->category=="art2D"){echo'"mediaPath":"'.$row->mediaPath.'",';echo'"layer":"<div id=\"art2DDiv\" style=\"height:100%;width:100%;position:relative;visibility:hidden;\"></div>",';echo'"mediaType":"'.$row->mediaType.'",';echo'"loop":"'.$row->loop.'",';echo'"backup":"'.$row->backup.'",';}else if($row->category=="art3D"){echo'"mediaPath":"'.$row->mediaPath.'",';echo'"layer":"<div id=\"art3DDiv\" style=\"height:100%;width:100%;position:relative;visibility:hidden;\"></div>",';echo'"mediaType":"'.$row->mediaType.'",';echo'"loop":"'.$row->loop.'",';}else if($row->category=="audio"){echo'"mediaPath":"'.$row->mediaPath.'",';if($row->mediaType=="FlashDVD"){echo'"iframeCode":"<iframe id=\"audioIFrame\" scrolling=\"no\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\" style=\"height:100%; width:100%;\" src=\"'.$row->mediaPath.'.html\"></iframe>",';echo'"backup":"'.$row->backup.'",';}echo'"layer":"<div id=\"audioDiv\" style=\"height:100%;width:100%;position:relative;visibility:hidden;\"></div>",';echo'"mediaType":"'.$row->mediaType.'",';echo'"loop":"'.$row->loop.'",';}else if($row->category=="games"){if($row->mediaType=="UDK"){echo'"layer":"<a id=\"gameLink\"><img id=\"gameDiv\" width=\"100%\" height=\"100%\" style=\"opacity:0;display:block;border:0px;\"></a>",';}else if($row->mediaType=="IFrame"||$row->mediaType=="Panda3D"){echo'"iframeCode":"<iframe id=\"gameIFrame\" scrolling=\"no\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\" style=\"height:100%; width:100%;\" src=\"'.$row->mediaPath.'.html\"></iframe>",';echo'"layer":"<div id=\"gameDiv\" style=\"height:100%;width:100%;visibility:hidden;position:relative;\"></div>",';}else{echo'"layer":"<div id=\"gameDiv\" style=\"height:100%;width:100%;visibility:hidden;position:relative;\"></div>",';}echo'"mediaPath":"'.$row->mediaPath.'",';echo'"aspectRatio":"'.$row->aspectRatio.'",';echo'"mediaType":"'.$row->mediaType.'",';echo'"backup":"'.$row->backup.'",';}else if($row->category=="web"){echo'"link":"'.$row->link.'",';}else if($row->category=="code"){echo'"layer":"<div id=\"codeDiv\" style=\"height:100%;width:100%;background-color:#FFF;font-size:12px;overflow:scroll;\"></div>",';echo'"mediaPath":"'.$row->mediaPath.'",';}echo'"image":"'.$row->imagePath.'-Normal.jpg",';echo'"thumb":"'.$row->imagePath.'-Thumbnail.jpg",';echo'"big":"'.$row->imagePath.'-Large.jpg",';echo'"title":"'.$row->title.'",';echo'"description":"'.$row->description.'"';echo'}';$currentRow++;}?>]