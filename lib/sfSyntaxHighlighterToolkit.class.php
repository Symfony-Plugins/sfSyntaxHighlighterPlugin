<?php

class sfSyntaxHighlighterToolkit
{
  
  /**
   * Return the list of all the brushes (languages) provided by SyntaxHighlighter
   *  
   * @return array
   */
  public static function getAvailableBrushes()
  {  
    $brushes = array(
      'cf'          => array('js' => 'shBrushColdFusion','name' => 'ColdFusion'),
      'coldfusion'  => array('js' => 'shBrushColdFusion','name' => 'ColdFusion'),
      'cpp'         => array('js' => 'shBrushCpp',      'name' => 'C++'),
      'c'           => array('js' => 'shBrushCpp',      'name' => 'C++'),
      'c++'         => array('js' => 'shBrushCpp',      'name' => 'C++'),
      'c#'          => array('js' => 'shBrushCSharp',   'name' => 'C#'),
      'c-sharp'     => array('js' => 'shBrushCSharp',   'name' => 'C#'),
      'csharp'      => array('js' => 'shBrushCSharp',   'name' => 'C#'),
      'css'         => array('js' => 'shBrushCss',      'name' => 'CSS'),
      'delphi'      => array('js' => 'shBrushDelphi',   'name' => 'Delphi'),
      'pascal'      => array('js' => 'shBrushDelphi',   'name' => 'Pascal'),
      'java'        => array('js' => 'shBrushJava',     'name' => 'Java'),
      'javafx'      => array('js' => 'shBrushJavaFX',   'name' => 'JavaFX'),
      'js'          => array('js' => 'shBrushJScript',  'name' => 'JavaScript'),
      'jscript'     => array('js' => 'shBrushJScript',  'name' => 'JavaScript'),
      'javascript'  => array('js' => 'shBrushJScript',  'name' => 'JavaScript'),
      'php'         => array('js' => 'shBrushPhp',      'name' => 'PHP'),
      'py'          => array('js' => 'shBrushPython',   'name' => 'Python'),
      'python'      => array('js' => 'shBrushPython',   'name' => 'Python'),
      'rb'          => array('js' => 'shBrushRuby',     'name' => 'Ruby'),
      'ruby'        => array('js' => 'shBrushRuby',     'name' => 'Ruby'),
      'rails'       => array('js' => 'shBrushRuby',     'name' => 'Ruby'),
      'ror'         => array('js' => 'shBrushRuby',     'name' => 'Ruby'),
      'sql'         => array('js' => 'shBrushSql',      'name' => 'SQL'),
      'vb'          => array('js' => 'shBrushVb',       'name' => 'Visual Basic'),
      'vb.net'      => array('js' => 'shBrushVb',       'name' => 'Visual Basic.net'),
      'xml'         => array('js' => 'shBrushXml',      'name' => 'XML'),
      'html'        => array('js' => 'shBrushXml',      'name' => 'HTML'),
      'xhtml'       => array('js' => 'shBrushXml',      'name' => 'XHTML'),
      'xslt'        => array('js' => 'shBrushXml',      'name' => 'XSLT'),
      'as3'         => array('js' => 'shBrushAS3',      'name' => 'ActionScript 3.0'),
      'actionscript'=> array('js' => 'shBrushAS3',      'name' => 'ActionScript'),
      'as'          => array('js' => 'shBrushAS3',      'name' => 'ActionScript'),
      'bash'        => array('js' => 'shBrushBash',     'name' => 'Bash'),
      'shell'       => array('js' => 'shBrushBash',     'name' => 'Shell'),
      'diff'        => array('js' => 'shBrushDiff',     'name' => 'Diff'),
      'patch'       => array('js' => 'shBrushDiff',     'name' => 'Patch'),
      'erlang'      => array('js' => 'shBrushErlang',   'name' => 'Erlang'),
      'erl'         => array('js' => 'shBrushErlang',   'name' => 'Erlang'),
      'groovy'      => array('js' => 'shBrushGroovy',   'name' => 'Groovy'),
      'perl'        => array('js' => 'shBrushPerl',     'name' => 'Perl'),
      'pl'          => array('js' => 'shBrushPerl',     'name' => 'Perl'),
      'plain'       => array('js' => 'shBrushPlain',    'name' => 'Plain Text'),
      'text'        => array('js' => 'shBrushPlain',    'name' => 'Plain Text'),
      'powershell'  => array('js' => 'shBrushPowerShell', 'name' => 'PowerShell'),
      'ps'          => array('js' => 'shBrushPowerShell', 'name' => 'PowerShell'),
      'scala'       => array('js' => 'shBrushScala',    'name' => 'Scala'),
    
      // Experimental
      
      'ada'         => array('js' => 'shBrushAda',      'name' => 'Ada'),
      'asm'         => array('js' => 'shBrushAsm',      'name' => 'Asm'),
      'x86'         => array('js' => 'shBrushAsm',      'name' => 'Asm'),
      'f#'          => array('js' => 'shBrushFSharp',   'name' => 'F#'),
      'fsharp'      => array('js' => 'shBrushFSharp',   'name' => 'F#'),
      'f-sharp'     => array('js' => 'shBrushFSharp',   'name' => 'F#'),
      'latex'       => array('js' => 'shBrushLatex',    'name' => 'Latex'),
      'tex'         => array('js' => 'shBrushLatex',    'name' => 'Latex'),
      'lua'         => array('js' => 'shBrushLua',      'name' => 'Lua'),
      'matlab'      => array('js' => 'shBrushMatlab',   'name' => 'Matlab'),
      'objc'        => array('js' => 'shBrushObjC',     'name' => 'Objective-C'),
      'obj-c'       => array('js' => 'shBrushObjC',     'name' => 'Objective-C'),
      'yaml'        => array('js' => 'shBrushYaml',     'name' => 'Yaml'),
      'yml'         => array('js' => 'shBrushYaml',     'name' => 'Yaml'),
    );
 
    return $brushes;
  }
  
  /**
   * Return the list of all the themes provided by SyntaxHighlighter
   *  
   * @return array
   */
  public static function getAvailableThemes()
  {  
    $themes = array(
      'default'     => array('css' => 'shThemeDefault',    'name' => 'Default'),
      'django'      => array('css' => 'shThemeDjango',     'name' => 'Django'),
      'emacs'       => array('css' => 'shThemeEmacs',      'name' => 'Emacs'),
      'fadetogrey'  => array('css' => 'shThemeFadeToGrey', 'name' => 'FadeToGrey'),
      'midnight'    => array('css' => 'shThemeMidnight',   'name' => 'Midnight'),
      'rdark'       => array('css' => 'shThemeRDark',      'name' => 'RDark'),
    );
    
    return $themes;
  }
  
  
  public static function getAvailableLanguages()
  {
    $brushes = sfSyntaxHighlighterToolkit::getAvailableBrushes();
    $aliases = array_keys($brushes);
    $languages = array();
    
    foreach($aliases as $alias)
    {
      if(!in_array($brushes[$alias]["name"], $languages))
      {
        $languages[$alias] = $brushes[$alias]["name"];      
      }
    }
    
    return $languages;
  }
  
  
  public static function getAliasesRegex()
  {
    $aliases = array_keys(sfSyntaxHighlighterToolkit::getAvailableBrushes());
    return "(" . implode('|', $aliases) . ')';
  }
  
}