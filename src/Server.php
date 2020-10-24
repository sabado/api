<?PHP namespace galgo\api;

Class Server {

    Public Static Function Headers( ){
        header( 'Server: Galgo.io Galgo/Api v0.1.7' );
	header( 'Server-UUID: '  . ( ( defined( '_SERVER_UUID_' ) ) ?  _SERVER_UUID_ 	 : 'NOT_CONFIGURED' ) );
        header( 'Server-Fancy: ' . ( ( defined( '_SERVER_FANCY_NAME_' ) ) ?  _SERVER_FANCY_NAME_ : 'NOT_CONFIGURED' ) );
	$Headers = getallheaders( );
	$Request = [ ];
        foreach($Headers as $Header => $Value){
		if( $Header == 'X-Auth' ) continue;
		$Request[ 'Headers' ] = [ $Header => $Value ];
        }
	return $Request;

    }

    Public Static Function Route( $Route, $Functionality ){

	$Request = [
		'Route' => $Route,
		'Accepted'  =>  null,
		'Type'  =>  null,
		'Content-Type' => null,
		'Body'  =>  file_get_contents( 'php://input' ),
		'Post'  =>  $_POST,
        	'Get'   =>  $_GET,
        	'Var'   =>  null
	];


	$RequestParts = explode( '/', $_SERVER['REQUEST_URI'] );
	$RouteParts   = explode( '/', $Route );	
	$Deep = ( $RouteParts[ count( $RouteParts ) -1 ] == '?') ?  count( $RouteParts ) -2 : false ;

	if(!$Deep) {
	        $Request['Accepted'] = $_SERVER['REQUEST_URI'];
		$Request['Type']='STATIC';

	        if($_SERVER['REQUEST_URI'] == $Route) {
		    $Args = [];
		    $Args[]=$Request;
		    call_user_func_array($Functionality,$Args);
	 	    exit(0);
        	}
		return ;
	}

	for($Elem = 0; $Elem <= $Deep; $Elem++){
		if( $RequestParts[$Elem] != $RouteParts[$Elem] ) return; 
		unset($RequestParts[$Elem]);
	}

        reset( $RequestParts );
	$Var = [];
	$Var = self::_upper( $RequestParts );
	$Request[ 'Accepted'] = $_SERVER[ 'REQUEST_URI' ];
	$Request[ 'Type' ]  = 'DYNAMIC';
        $Request[ 'Var'  ]  = $Var;
	$Request[ 'Post' ]  = $_POST;
	$Request[ 'Get'  ]  = $_GET;
	$Request[ 'Body' ]  = file_get_contents( 'php://input' );
	$Request[ 'Content-Type' ] = @getallheaders()['Content-Type'];
	$Request[ 'Token' ] =  @getallheaders()['Token'] ?? False;
        $Request[ 'Args'  ]  = $Var;
	array_unshift($Var,$Request);
	call_user_func_array($Functionality,$Var);
	exit(0);
    }

    Private Static Function _upper( array $Array ):array {
	$ARRAY = [];
	for($i = 0;$i <= count($Array)-1;$i++) $ARRAY[]=each($Array)['value']; 	
	return $ARRAY;
    }
    Public Static Function Auth($EnabledTokens){
        //echo '<PRE>' . json_encode( getallheaders(),JSON_PRETTY_PRINT) . '</PRE>';
        $Headers = getallheaders();
        foreach($Headers as $Header => $Value){
            $ProvidedKey = false;
            if($Header == 'X-Auth') {
                $ProvidedKey = $Value;
                break;
            }
        }
        if(!$ProvidedKey) return false;
        
        foreach($EnabledTokens as $Token){
            if($Token == $ProvidedKey) return true;
        }
        return false;
    }

}
