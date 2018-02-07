<?php
///
///@file lexicalAnalyzer.class.php
///@brief Analizes the InputString
///@author Sachin Ganesh
///
class lexicalAnalyzer{
	/// Lex Output Array
	private $LEX_OutputArray;
	private $PREG_InputPattern;
	
	//Gloval Variables
	private $PREG;
	private $OPERATORS;
	private $KEYWORDS;
	private $SPECIAL_SYMBOLS;
	private $COMP_OPERATORS;
	
	//Table
	private $SYMBOL_TABLE;
	private $STRING_TABLE;
	// Counter
	private $_SYMBOL_TABLE_COUNTER;
	private $_STRING_TABLE_COUNTER;
	
	public function __construct()
	{
		include('regex.php');
		$this->PREG = $PREG;
		
		include('tables/operators.php');
		$this->OPERATORS = $OPERATORS;
		
		include('tables/keywords.php');
		$this->KEYWORDS = $KEYWORDS;
		
		include('tables/specialSymbols.php');
		$this->SPECIAL_SYMBOLS = $SPECIAL_SYMBOLS;
		
		include('tables/comparisionOperators.php');
		$this->COMP_OPERATORS = $COMP_OPERATORS;
		
		
		/// Intialize Symbol table Counter
		$this->_SYMBOL_TABLE_COUNTER = 0;
		$this->_STRING_TABLE_COUNTER = 0;
		$this->SYMBOL_TABLE = array( );
		$this->STRING_TABLE = array( );
	}
	
	
	
/// Public getter
	
	
	///
	///@brief Converts the given String into array of all keywords
	///
	///@param [in] $LEX_inputString -> Input String
	///@return Returns a array of Keywords with their type
	///
	///
	public function getTokenArray($LEX_InputString){
		$this->PREG_InputPattern = 	'/' 
								.$this->PREG["STRING"].'|'
								.$this->PREG_CompOperators()   	/// Returns Regular Expression for Comparision Operators
								.$this->PREG_Operators()   	/// Returns Regular Expression for Operators
								.$this->PREG_SpecialSymbols()
								.$this->PREG_Keywords()		///	Returns Regular Expression for Keywords
								.$this->PREG["NUMBER"].'|'									
								.$this->PREG["IDENTIFIER"]								
								.'/' ; 
		
		//echo "<a>PREG_PATTERN : " . $PREG_InputPattern . '<br></a>';
		
		/// PREG_OFFSET_CAPTURE can be used to get the offset value
		/// PREG_SET_ORDER -> array containing match and back reference to the first match
		preg_match_all($this->PREG_InputPattern,$LEX_InputString,$this->LEX_OutputArray,PREG_SET_ORDER);
		
		/// Find the Token type 
		$this->getTokenType($this->LEX_OutputArray);
		
		return $this->LEX_OutputArray;
	}
	
	///
	///@brief Dispalys the LEX Output
	///
	///@param [in] $LEX_Output Array Containing all tokens
	///@return null
	///
	///
	public function getLexFormatedOutput()
	{
		$str = null;
		//echo '<br><br> Output From Lexical Analyser<br><br><a>';
		foreach($this->LEX_OutputArray as &$Output)
		{
			$str .= " &lt$Output[1],$Output[0]&gt ";
		}
		//echo "</a><br><br><br>";
		return $str;
	}
	
	
	///
	///@brief getter for SYMBOL Table
	///
	///@return -> SYMBOL_TABLE
	///
	///
	public function getSymbolTable()
	{
		return $this->SYMBOL_TABLE;
	}

	///
	///@brief getter for Keywords table
	///
	///@return -> Keyword table
	///
	///
	public function getKeywordsTable()
	{
		return $this->KEYWORDS;
	}
	
	///
	///@brief getter for STRING table
	///
	///@return -> STRING table
	///
	///
	public function getStringTable()
	{
		return $this->STRING_TABLE;
	}
	
	///
	///@brief getter for generated Regular Expression
	///
	///@return Regular Expression
	///
	///
	public function getRegularExpression()
	{
		return $this->PREG_InputPattern;
	}


/// private functions	
	
	///
	///@brief Finds the exact type of a keyword
	///
	///@param [in] $LEX_TokenArray -> Reference to $LEX_OutputArray
	///@return NULL
	///
	///@details Finds the type of keyword and updates $LEX_OutputArray
	///
	private function getTokenType(&$LEX_TokenArray)
	{
		foreach ($LEX_TokenArray as &$Token)
		{	
			//find STRING 
			if($this->isString($Token)) {}
			//find SPECIAL_SYMBOLS
			else if($this->isSpecialSymbols($Token)){}
			//find COMP_OPERATOR
			else if($this->isCompOperator($Token)){}
			//find OPERATOR
			else if($this->isOperator($Token)){}
			//find KEYWORD
			else if($this->isKeywords($Token)){}
			//find NUMBER
			else if($this->isNumber($Token)){}
			//find IDENTIFIER
			else if($this->isIdentifier($Token)){}			
		}
		return;		
	}
	
	
	
	///
	///@brief Generates Regular Expression for Operators
	///
	///@return Regular Expression for Operators
	///
	///
	private function PREG_Operators()
	{	
		$Regx = null;
		foreach($this->OPERATORS as $Op)
		{
			$Regx .= $Op[2] . '|' ;
		}
		return $Regx;
	}
	
	
	///
	///@brief Generates Regular Expression for Comparision Operators
	///
	///@return Regular Expression for Comparision Operators
	///
	///
	private function PREG_CompOperators()
	{	
		$Regx = null;
		foreach($this->COMP_OPERATORS as $Op)
		{
			$Regx .= $Op[2] . '|' ;
		}
		return $Regx;
	}
	
	///
	///@brief Generates Regular Expression for Keywords
	///
	///@return Regular Expression for Keywords
	///
	///
	private function PREG_Keywords()
	{
		$Regx = null;
		foreach($this->KEYWORDS as $Ky)
		{
			$Regx .= $Ky[2] . '|';
		}
		return $Regx;
	}
	
	///
	///@brief Generates Regular Expression for Special Symbols
	///
	///@return	Regular Expression for Speacial Symbols
	///
	///
	private function PREG_SpecialSymbols()
	{
		$Regx= null;
		foreach($this->SPECIAL_SYMBOLS as $Sym)
		{
			$Regx .=$Sym[2].'|';
		}
		return $Regx;
	}

	
	///
	///@brief Find OPERATOR and modify $LEX_OutputArray
	///
	///@param [in] $Token 
	///@return returns 1 if match found; else 0
	///
	///@details compares the Token with OPERATOR Table
	///
	private function isOperator(&$Token)
	{	
		$Counter = 0;
		/// take each row form OPERATOR table & compare it with Token
		foreach($this->OPERATORS as $Op)
		{
			if($Token[0] == $Op[0])
			{
				$Token[1] = 'OPERATOR';
				$Token[2] = $Counter;				
				return 1;
			} 
			$Counter++;
		}
		return 0;
	}
	
	///
	///@brief Find Comparision OPERATOR and modify $LEX_OutputArray
	///
	///@param [in] $Token 
	///@return returns 1 if match found; else 0
	///
	///@details compares the Token with Comp OPERATOR Table
	///
	private function isCompOperator(&$Token)
	{	
		$Counter = 0;
		/// take each row form OPERATOR table & compare it with Token
		foreach($this->COMP_OPERATORS as $Op)
		{
			if($Token[0] == $Op[0])
			{
				$Token[1] = 'COMP_OPERATOR';
				$Token[2] = $Counter;				
				return 1;
			} 
			$Counter++;
		}
		return 0;
	}
	
	///
	///@brief Find KEYWORDS and modify $LEX_OutputArray
	///
	///@param [in] $Token 
	///@return return 1 if match found, else 0
	///
	///@details compares the Token with KEYWORDS table
	///
	private function isKeywords(&$Token)
	{
		$Counter = 0;
		foreach($this->KEYWORDS as $Ky)
		{
			if($Token[0] == $Ky[0])
			{
				$Token[1] = 'KEYWORD';
				$Token[2] = $Counter;
				return 1;
			}
			$Counter++;
		}
		return 0;
	}
	
	///
	///@brief Find Speacial Symbols and modify $LEX_OutputArray
	///
	///@param [in] $Token
	///@return Return 1 if match found, else 0
	///
	///@details Compare the token with SPECIAL_SYMBOLS table
	///
	private function isSpecialSymbols(&$Token)
	{
		$Counter = 0;
		foreach($this->SPECIAL_SYMBOLS as $Sym)
		{
			if($Token[0] == $Sym[0])
			{
				$Token[1] = 'SPECIAL_SYMBOL';
				$Token[2] = $Counter;
				return 1;
			}
			$Counter++;
		}
		return 0;
	}
	
	///
	///@brief Find STRING and MOdify $LEX_OutputArray
	///
	///@param [in] $Token
	///@return Return 1 if match found, else 0
	///
	///
	private function isString(&$Token)
	{
		if(preg_match('/' . $this->PREG['STRING'] . '/',$Token[0],$temp))
		{
			/// Set type as String
			$Token[1] = 'STRING';
			/// find duplication in STRING_TABLE
			/// if duplication is not found add String to the STRING table
			$Key = array_search($Token[0],$this->STRING_TABLE);
			if(is_bool($Key) === false)
			{
				//echo "<br>Key $key Present";
				$Token[2] = $Key;
			}
			else 
			{
				//echo "<br>Adding $Token[0] to String Table";
				$this->STRING_TABLE[$this->_STRING_TABLE_COUNTER] = $Token[0];					
				/// Set Symbol Table Counter
				$Token[2] = $this->_STRING_TABLE_COUNTER;
				$this->_STRING_TABLE_COUNTER++;	
				
			}
			return 1;
		}
		return 0;
	}
	
	///
	///@brief Find number and Modify $LEX_OutputArray
	///
	///@param [in] $Token
	///@return null
	///
	///@details Details
	///
	private function isNumber(&$Token)
	{
		if(preg_match('/'. $this->PREG['NUMBER'] . '/' , $Token[0],$temp))
		{
			// Set  type as NUMBER
			$Token[1] = "NUMBER";
			
			//$Token[2] = $Token[0];
			
			
			/// find keyword duplication in SYMBOL_TABLE
			/// if duplication is not found add keyword to the symbol table
			$Key = array_search($Token[0],$this->SYMBOL_TABLE);
			if(is_bool($Key) === false)
			{
				$Token[2] = $Key;
			}
			else 
			{
				$this->SYMBOL_TABLE[$this->_SYMBOL_TABLE_COUNTER] = $Token[0];					
				/// Set Symbol Table Counter
				$Token[2] = $this->_SYMBOL_TABLE_COUNTER;
				$this->_SYMBOL_TABLE_COUNTER++;					
			}
			return 1;
		}
		return 0;
	}
	///
	///@brief Find IDENTIFIER and modify $LEX_OutputArray
	///
	///@param [in] $Token 
	///@return nill
	///
	///@details Comapres the Token with KEYWORD Table
	///
	private function isIdentifier(&$Token)
	{
		/// IDENTIFIER
		if(preg_match('/' . $this->PREG['IDENTIFIER'] . '/',$Token[0],$temp))
		{
			/// Set type as identifier
			$Token[1] = 'IDENTIFIER';
			/// find keyword duplication in SYMBOL_TABLE
			/// if duplication is not found add keyword to the symbol table
			$Key = array_search($Token[0],$this->SYMBOL_TABLE);
			if(is_bool($Key) === false)
			{
				$Token[2] = $Key;
			}
			else 
			{
				$this->SYMBOL_TABLE[$this->_SYMBOL_TABLE_COUNTER] = $Token[0];					
				/// Set Symbol Table Counter
				$Token[2] = $this->_SYMBOL_TABLE_COUNTER;
				$this->_SYMBOL_TABLE_COUNTER++;					
			}
			return 1;
		}
		return 0;
	}
	
}

?>