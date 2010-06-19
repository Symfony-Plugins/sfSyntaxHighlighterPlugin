<?php

include_once(sfConfig::get('sf_syntax_highlighter_plugin_dir') . '/lib/sfSyntaxHighlighterToolkit.class.php');

/**
 * Adds javascript code to the response.
 * The functions that convert BBCode to HTML are heavily inspired by the ones in the SyntaxHighlighter Plugin for wordpress, 
 * by <a href="http://photomatt.net/">Matt</a>, <a href="http://www.viper007bond.com/">Viper007Bond</a>, 
 * and <a href="http://blogwaffe.com/">mdawaffe</a>
 * 
 * @package     sfSyntaxHighlighterPlugin
 * @subpackage  filter
 * @author      Miguel Santirso (http://miguelSantirso.es) <tirso.00@gmail.com>
 * @version     SVN: $Id$
 */
class sfSyntaxHighlighterFilter extends sfFilter
{
  
  private $usedBrush = array();
  private $allBrush;
  
  
  /**
   * Insert highlighting code to the response only if needed
   * 
   * @param   sfFilterChain $filterChain
   */
  public function execute($filterChain)
  {
 
    // Initialization
    $this->allBrush = sfSyntaxHighlighterToolkit::getAvailableBrushes();
    $this->usedBrush = array();
    
    // get the response
    $response = $this->context->getResponse();
    
    // add the javascript core file
    $response->addJavascript('/sfSyntaxHighlighterPlugin/js/shCore');
    
    // add the css core file
    $response->addStylesheet('/sfSyntaxHighlighterPlugin/css/shCore');
    
    // add the css theme
    $this->loadTheme($response);
    
    // execute filter chain
    $filterChain->execute();

    // get the content of the response
    $old = $response->getContent();
  
    // read the used brush from the content and generate the js file to include in the footer
    $this->extractBrushInPreTag($response->getContent());
    
    // convert the BBCode to HTML ([code], [source], [sourcecode] => <pre>)
    $new = $this->BBCodeToHTML($old);
    
    // If nothing has changed and there are no <pre> tags with brush, it means that there is no code to highlight. Finished
    if($old == $new && count($this->usedBrush)==0) return;

    $old = $new;
    
    // Generate the javascript code to add at the bottom of the page.
    // It contains the javascript initialization code and the javascript inclusions of the used brushes
    $htmlToAdd = $this->generateHtmlToAddBrush().'\n'.$this->generateInitHtml(); 
    
    // Add the code right before the </body>
    $new = str_ireplace('</body>', "\n".$htmlToAdd."\n</body>", $old);

    // If nothing has changed it means that the response has not </body>
    if ($old == $new)
    {
      // We simply add it at the bottom of the response
      $new .= $htmlToAdd;
    }
  
    // We set the new content
    $response->setContent($new);
  }
  
  /**
   * Generates the javascript code to add at the bottom of the html. This code highlights the source
   *
   * @return unknown
   */
  protected function generateInitHtml()
  {
    $html = array();
    $html[] = '<script type="text/javascript" language="javascript">';
    $html[] = 'SyntaxHighlighter.config.clipboardSwf = "/sfSyntaxHighlighterPlugin/js/clipboard.swf"';
    $html[] = 'SyntaxHighlighter.all()';
    $html[] = '</script>';
    $html = join("\n", $html);
    
    return $html;
  }
  
  /**
   * Adds all the brushes
   *
   * @param sfResponse $response Response to which the javascripts will be added
   * @depreciated
   */
  protected function addAllBrushes(sfResponse $response)
  {
    $languages = sfSyntaxHighlighterToolkit::getAvailableBrushes();
    
    foreach($languages as $language)
    {
      $response->addJavascript('/sfSyntaxHighlighterPlugin/js/' . $language["js"]);
    }

  }
  
  
  /**
   * Searches for BBCode within a string
   *
   * @param string $content the content in which the function will search BBCode
   * @param boolean $addslashes
   * @return an array of the matches
   */
  protected function getBBCode( $content, $addslashes = FALSE )
  {
    $regex = '/\[(sourcecod|sourc|cod)(e language=|e lang=|e=)';
  
    if ( $addslashes ) $regex .= '\\\\';

    $regex .= '([\'"])' . sfSyntaxHighlighterToolkit::getAliasesRegex();

    if ( $addslashes ) $regex .= '\\\\';

    $regex .= '\3\](.*?)\[\/\1e\]/si';

    preg_match_all( $regex, $content, $matches, PREG_SET_ORDER );

    return $matches;
  }

  /**
   * Converts the BBCode ([code], [source], [sourcecode]) to the html tag <pre>
   *
   * @param string $content the content to convert
   * @return the converted content
   */
  protected function BBCodeToHTML( $content ) 
  {

    // If there is no BBCode in the content, we just return it
    if ( !$this->checkForBBCode( $content ) ) return $content;

    $matches = $this->getBBCode( $content );
    
    if ( empty($matches) ) return $content; // No BBCode found, we can stop here
  
    // Loop through each match and replace the BBCode with HTML
    foreach ( (array) $matches as $match ) 
    {
      $language = strtolower( $match[4] );
      $content = str_replace( $match[0], '<pre class="brush: ' . $language . "\">\n" . htmlspecialchars( $match[5] ) . "\n</pre>", $content );
      
      // And add this language to the used brushes
      $this->usedBrush[$this->allBrush[$language]['js']] = true;
      
    }

    return $content;
  }
  

  /**
   * Checks cheaply if there is BBCode in the content. This way we don't waste CPU cicles
   *
   * @param string $content the content in which the function will search BBCode
   * @return true if there is BBCode in $content
   */
  protected function checkForBBCode( $content )
  {
    if ( stristr( $content, '[sourcecode' ) && stristr( $content, '[/sourcecode]' ) ) return TRUE;
    if ( stristr( $content, '[source' ) && stristr( $content, '[/source]' ) ) return TRUE;
    if ( stristr( $content, '[code' ) && stristr( $content, '[/code]' ) ) return TRUE;

    return FALSE;
  }

  /**
   * Checks cheaply if there are <pre> tags. This way we don't waste CPU cicles
   *
   * @param string $content the content in which the function will search <pre> tags
   * @return true if there is BBCode in $content
   */
  protected function checkForPreTag( $content )
  {
    if ( stristr( $content, '<pre' ) && stristr( $content, '</pre>' ) ) return TRUE;

    return FALSE;
  }
  
  /**
   * Load the configured theme ( or the default theme if this last one is unavailable )
   * and add it to the response
   * 
   * @param sfResponse $response Response to which the css will be added
   * @return void
   */
  private function loadtheme (sfResponse $response)
  {
    $theme = sfConfig::get('app_sfSyntaxHighlighterPlugin_theme');
    $themeList = sfSyntaxHighlighterToolkit::getAvailableThemes();
    
    // Reset the theme if it doesn't exist
    if (!isset($themeList[$theme])) $theme='default';
    
    $selectedCssTheme = $themeList[$theme]['css'];
    $response->addStylesheet('/sfSyntaxHighlighterPlugin/css/'.$selectedCssTheme);

  }
  
  /**
   * Extract all languages in the pre tags.
   * Its aim is to include only the used brushes
   * 
   * @param string $content the content in which the function will search pre tags
   * @return void
   */
  private function extractBrushInPreTag($content)
  {
    // If there is no pre tags, nothing to do
    if (!$this->checkForPreTag($content)) return;
    
    $regex = '/\<pre[\ *]class=[\"|\'].*brush:([ 0-9a-zA-Z-#+]*)[;|\"|\']/';
  
    preg_match_all( $regex, $content, $matches, PREG_SET_ORDER );

    // Check if the brush is supported by SyntaxHighlighter
    foreach($matches as $match)
    {
      $brush = trim(strtolower($match[1]));
      if (isset($this->allBrush[$brush])) $this->usedBrush[$this->allBrush[$brush]['js']]=true; 
    }
    
  }
  
  /**
   * Generate the HTML code to include 
   * 
   * @return string the html code to include on the bottom of the page
   */
  private function generateHtmlToAddBrush()
  {
    $html = array();
    foreach ($this->usedBrush as $brush=>$status)
    {
      $html[] = '<script type="text/javascript" src="/sfSyntaxHighlighterPlugin/js/' . $brush.'.js"></script>';
    }
    return join("\n", $html);
  }
}