<?php
 
    class JavascriptParser extends sfFilter
    {
      public function execute($filterChain)
      {
        $filterChain->execute();
 
 
        $fp = fopen( "js/compiled.js", "w" );
 
        JavascriptParser::getJSFiles( "js", $fp );
 
        fclose ( $fp );
 
        $response = $this->getContext()->getResponse();
        $content = $response->getContent();
        if (false !== ($pos = strpos($content, '</head>')))
        {
          $html = "<script type='text/javascript' src='/js/compiled.js'></script>";
 
          if ($html and $this->getContext()->getModuleName()!='homepage')
          {
            $response->setContent(substr($content, 0, $pos).$html.substr($content, $pos));
          }
        }
 
      }
 
      public function getJSFiles( $dir, &$fp )
      {
        $hDir = opendir( $dir );
        while( ( $filename = readdir( $hDir ) ) !== false )
        {
            if ( is_dir( $filename ) )
            {
            }
            else if ( is_dir( $dir."/".$filename ) )
                JavascriptParser::getJSFiles( $dir."/".$filename, $fp );                
            else if ( strpos( $filename, ".js" ) !== false && $filename != "compiled.js" )
            {
                $tmpFile = fopen( $dir."/".$filename, "r" );
                $data = fread( $tmpFile, filesize( $dir."/".$filename ) );

 
                fwrite( $fp, " \n".$data );
                fclose( $tmpFile );
            }
        }
        closedir( $hDir );  
      }
    }
 