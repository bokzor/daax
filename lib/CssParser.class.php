<?php
 
    class CssParser extends sfFilter
    {
      public function execute($filterChain)
      {
        $filterChain->execute();
 
 
        $fp = fopen( "css/compiled.css", "w" );
 
        CssParser::getCSSFiles( "css", $fp );
 
        fclose ( $fp );
 
        $response = $this->getContext()->getResponse();
        $content = $response->getContent();
        if (false !== ($pos = strpos($content, '</head>')))
        {
          $html = "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"/css/compiled.css\" />";
 
          if ($html)
          {
            $response->setContent(substr($content, 0, $pos).$html.substr($content, $pos));
          }
        }
 
      }
 
      public function getCSSFiles( $dir, &$fp )
      {
        $hDir = opendir( $dir );
        while( ( $filename = readdir( $hDir ) ) !== false )
        {
            if ( is_dir( $filename ) )
            {
            }
            else if ( is_dir( $dir."/".$filename ) )
                CssParser::getCSSFiles( $dir."/".$filename, $fp );                
            else if ( strpos( $filename, ".css" ) !== false && $filename != "compiled.css" )
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
 