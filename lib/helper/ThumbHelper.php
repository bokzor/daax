<?php
/*
 * les r�pertoires a cr�er
 * uploads/user/source/ -> l� ou on doit uploader le images
 * uploads/user/thumb/
 *
 * avoirl 'image par d�faut disponible:
 * /images/default.jpg
 *
 * pour g�n�rer le thumb:
 * doThumb($user->getAvatar(), 'user', array('width'=>100,'height'=>'150'), 'center', 'default.jpg')
 * OU
 * pour afficher le thumb
 * showThumb($user->getAvatar(), 'user', array('width'=>100,'height'=>'150'), 'center', 'default.jpg')
 */


 /**
   * g?n?rer le thumb correspondant ? une image.
   * cete fonction v?rifie si le thumb existe d?j? ou si la source est plus r?cente
   * si besoin, il est reg?n?r?.
   * il faut faire passer en parametres options[width] et options[height]
   * et l'image est automatiquement redimensionner en thumb.
   * si width = height alors l'image sera tronqu�e et carr�
   *
   * @param <string> $image_name : le nom de l'image donc g?n?ralement le $object->getImage(), pas de r?pertoire
   * @param <string> $folder : le nom du r?pertoire dans uploads o? est stock? l'image : uploads/object/source => $folder = object
   * @param <array> $options : les parametres ? passer ? l'image: width et height
   * @param <string> $resize : l'op?ration sur le thumb: "scale" pour garder les proportions, "center" pour tronquer l'image
   * @param <string> $default : l'image par d?faut si image_name n'existe pas
   * @return <image_path>
  */
  function doThumb($image_name, $folder, $options = array(), $resize = 'scale', $default = 'default.jpg')
  {

    //valeur par d�faut si elles ne sont pas d�finies
    if(!isset($options['width']))
      $options['width'] = 50;
    if(!isset($options['height']))
      $options['height'] = 50;

    $source_dir = 'uploads/'.$folder.'/';
    $thumb_dir  = 'uploads/'.$folder.'/thumb/';


    //le fichier source
    $source = $source_dir.$image_name;
    $exist = sfConfig::get('sf_web_dir').'/'.$source;
    if(!is_file($exist))
    {
      $image_name = $default;
      $source = 'uploads/'.$image_name;// la valeur par d�faut
    }

    $new_name = $options['width'].'x'.$options['height'].'_'.$image_name;
    $new_img = $thumb_dir.$new_name;
    // si le thumb n'existe pas ou s'il est plus ancien que le fichier source
    // alors on reg�n�re le thumb
    if(!is_file(sfConfig::get('sf_web_dir').'/'.$new_img) OR filemtime($source)>filemtime($new_img))
    {
      $img = new sfImage($source);

      $img->thumbnail($options['width'],$options['height'],$resize)
          ->saveAs($new_img);
    }

    return image_path('/'.$new_img);
  }


  /**
   * Cette funciton utilise la pr?c?dente afin d'afficher directement l'image avec les balises et les options.
   * @param <string> $image_name : le nom de l'image donc g?n?ralement le $object->getImage(), pas de r?pertoire
   * @param <string> $folder : le nom du r?pertoire dans uploads o? est stock? l'image : uploads/object/source => $folder = object
   * @param <array> $options : les parametres ? passer ? l'image: width, height, alt, title, class, id...
   * @param <string> $resize : l'op?ration sur le thumb: "scale" pour garder les proportions, "center" pour tronquer l'image
   * @param <string> $default : l'image par d?faut si image_name n'existe pas
   * @return <image_path>
  */
  function showThumb($image_name, $folder, $options = array(), $resize = 'scale', $default = 'default.jpg', $absolute='false')
  {
    if(empty($options['alt']))
     $options['alt'] = 'image '.$image_name;
    if(empty($options['title']))
     $options['title'] = 'image '.$image_name;

    $image_path = doThumb($image_name, $folder, $options, $resize, $default);
    $img = new sfImage(sfConfig::get('sf_web_dir').$image_path);

    //r�cupere les vraies dimensions de l'image du thumb et on �crase dans les options.
    $options['width'] = $img->getWidth();
    $options['height'] = $img->getHeight();
	$options['absolute'] = $absolute;

    return image_tag($image_path,$options);
  }